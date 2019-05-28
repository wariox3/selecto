<?php
namespace App\Controller\RecursoHumano\Movimiento\Nomina;


use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuPagoTipo;
use App\Entity\RecursoHumano\RhuProgramacion;
use App\Form\Type\RecursoHumano\ProgramacionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdicionalController extends Controller
{
    /**
     * @Route("/recursoHumano/administracion/movimiento/programacion/lista", name="RecursoHumano_programacion_lista")
     */
    public function lista(Request $request){
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoEmpleado', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuCodigoEmpleado')])
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('fechaDesde', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('fechaHasta', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('Grupo', EntityType::class, $em->getRepository(RhuGrupo::class)->llenarCombo())
            ->add('tipo', EntityType::class, $em->getRepository(RhuPagoTipo::class)->llenarCombo())
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuCodigoEmpleado', $form->get('codigoEmpleado')->getData());
                $session->set('filtroRhuNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
                $session->set('filtroRhuNombreCorto', $form->get('nombreCorto')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuProgramacion::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('RecursoHumano_programacion_lista'));
            }
        }
        $arProgramaciones = $paginator->paginate($em->getRepository(RhuProgramacion::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/programacion/lista.html.twig', [
            'arProgramaciones' => $arProgramaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recursoHumano/administracion/movimiento/programacion/nuevo/{id}", name="RecursoHumano_programacion_nuevo")
     */
    public function nuevo(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arProgramacion = $this->getUser()->getCodigoEmpresaFk();
        $arProgramacion = new RhuProgramacion();
        if ($id != 0) {
            $arProgramacion = $em->getRepository(RhuProgramacion::class)->find($id);
        }
        $form = $this->createForm(ProgramacionType::class, $arProgramacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arProgramacion = $form->getData();
                $arProgramacion->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arProgramacion);
                $em->flush();
                return $this->redirect($this->generateUrl('RecursoHumano_programacion_detalle', ['id' => $arProgramacion->getCodigoProgramacionPk()]));

            }
        }
        return $this->render('recursoHumano/programacion/nuevo.html.twig', [
            'arProgramacion' => $arProgramacion,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/recursoHumano/administracion/movimiento/programacion/detalle/{id}", name="RecursoHumano_programacion_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arProgramacion = $em->getRepository(RhuProgramacion::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('RecursoHumano_programacion_detalle', ['id' => $id]));
        }

        return $this->render('recursoHumano/programacion/detalle.html.twig', [
            'form' => $form->createView(),
            'arProgramacion' => $arProgramacion,
        ]);
    }
}