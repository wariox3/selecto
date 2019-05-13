<?php


namespace App\Controller\RecursoHumano;


use App\Entity\RecursoHumano\RhuContrato;
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
     * @Route("/inventario/administracion/RecursoHumano/Contrato/lista", name="RecursoHumano_contrato_lista")
     */
    public function lista(Request $request){
        $session = new Session();
        $em= $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('fechaInicio', DateType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('fechaFin', DateType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            /**cambiar a un select**/->add('Grupo', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('estado', ChoiceType::class, ['choices' => ['TODOS' => '', 'Activos' => '1', 'Inactivos' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($form->get('btnFiltrar')->isClicked()) {
               // $session->set('filtroRhuCodigoEmpleado', $form->get('codigoEmpleado')->getData());
               // $session->set('filtroRhuNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
               // $session->set('filtroRhuNombreCorto', $form->get('nombreCorto')->getData());
            }
            if($form->get('btnEliminar')->isClicked()){
                $arRhuContrato= $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuContrato::class, $arRhuContrato);
                return $this->redirect($this->generateUrl('RecursoHumano_empleado_lista'));
            }
        }
        $arRhuContratos = $paginator->paginate($em->getRepository(RhuContrato::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/contrato/lista.html.twig', [
            'arRhuContratos' => $arRhuContratos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inventario/administracion/RecursoHumano/Contrato/detalle/{id}", name="RecursoHumano_contrato_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arContrato = $em->getRepository(RhuContrato::class)->find($id);
        //dd($arContrato);
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