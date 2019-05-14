<?php


namespace App\Controller\RecursoHumano;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuGrupo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContratoController extends Controller
{
    /**
     * @Route("/RecursoHumano/administracion/Contrato/lista", name="RecursoHumano_contrato_lista")
     */
    public function lista(Request $request){
        $session = new Session();
        $em= $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoContato', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuCodigoEmpleado')])
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('Grupo', EntityType::class, $em->getRepository(RhuGrupo::class)->llenarCombo())
            ->add('estado', ChoiceType::class, ['choices' => ['TODOS' => '', 'Activos' => '1', 'Inactivos' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($form->get('btnFiltrar')->isClicked()) {
               $session->set('filtroRhuContratoCodigoContato', $form->get('codigoContato')->getData());
               $session->set('filtroRhuContratoNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
               $session->set('filtroRhuContratoNombreCorto', $form->get('nombreCorto')->getData());
                $session->set('filtroRhuContratoEstado',   $form->get('estado')->getData());
                $arGrupo = $form->get('Grupo')->getData();

                if($arGrupo) {
                    $session->set('filtroRhuContratoGrupo', $arGrupo->getCodigoGrupoPk());
                } else {
                    $session->set('filtroRhuContratoGrupo', null);
                }

            }
            if($form->get('btnEliminar')->isClicked()){
                $arRhuContrato= $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuContrato::class, $arRhuContrato);
                return $this->redirect($this->generateUrl('RecursoHumano_empleado_lista'));
            }
        }
        $empresa = $this->getUser()->getCodigoEmpresaFk();

        $arRhuContratos = $paginator->paginate($em->getRepository(RhuContrato::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/contrato/lista.html.twig', [
            'arRhuContratos' => $arRhuContratos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/RecursoHumano/administracion/Contrato/detalle/{id}", name="RecursoHumano_contrato_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arContrato = $em->getRepository(RhuContrato::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('RecursoHumano_contrato_detalle', ['id' => $id]));
        }

        return $this->render('recursoHumano/contrato/detalle.html.twig', [
            'form' => $form->createView(),
            'arContrato'=>$arContrato
        ]);
    }
}