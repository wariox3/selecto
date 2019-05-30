<?php

namespace App\Controller\RecursoHumano\Movimiento\Nomina;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuPagoTipo;
use App\Entity\RecursoHumano\RhuProgramacion;
use App\Entity\RecursoHumano\RhuProgramacionDetalle;
use App\Form\Type\RecursoHumano\ProgramacionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProgramacionController extends Controller
{
    /**
     * @Route("/recursoHumano/movimiento/nomina/programacion/lista", name="recursoHumano_programacion_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigo', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuProgramacionCodigoProgramacion')])
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuProgramacionNombreProgramacion')])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaDesde') ? date_create($session->get('filtroInvInformeAsesorVentasFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaHasta') ? date_create($session->get('filtroInvInformeAsesorVentasFechaHasta')) : null])
            ->add('Grupo', EntityType::class, $em->getRepository(RhuGrupo::class)->llenarCombo())
            ->add('tipo', EntityType::class, $em->getRepository(RhuPagoTipo::class)->llenarCombo())
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuProgramacionCodigo', $form->get('codigo')->getData());
                $session->set('filtroRhuProgramacionNombre', $form->get('nombre')->getData());
                $session->set('filtroRhuProgramacionFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuProgramacionFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arGrupo = $form->get('Grupo')->getData();
                $arTipo = $form->get('tipo')->getData();
                if ($arGrupo) {
                    $session->set('filtroRhuProgramacionGrupo', $arGrupo->getNombre());
                } else {
                    $session->set('filtroRhuProgramacionGrupo', null);
                }
                if ($arTipo) {
                    $session->set('filtroRhuProgramaciontipo', $arTipo->getNombre());
                } else {
                    $session->set('filtroRhuProgramaciontipo', null);
                }

            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuProgramacion::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('recursoHumano_programacion_lista'));
            }
        }
        $arProgramaciones = $paginator->paginate($em->getRepository(RhuProgramacion::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/programacion/lista.html.twig', [
            'arProgramaciones' => $arProgramaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recursoHumano/movimiento/nomina/programacion/nuevo/{id}", name="recursoHumano_programacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
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
                return $this->redirect($this->generateUrl('recursoHumano_programacion_detalle', ['id' => $arProgramacion->getCodigoProgramacionPk()]));
            }
        }
        return $this->render('recursoHumano/programacion/nuevo.html.twig', [
            'arProgramacion' => $arProgramacion,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/recursoHumano/movimiento/nomina/programacion/detalle/{id}", name="recursoHumano_programacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arProgramacion = $em->getRepository(RhuProgramacion::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnAutorizar', SubmitType::class, ['label' => 'Autorizar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnDesautorizar', SubmitType::class, ['label' => 'Autorizar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnImprimir', SubmitType::class, ['label' => 'Imprimir', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnAprobar', SubmitType::class, ['label' => 'Aprobar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnAnular', SubmitType::class, ['label' => 'Anular', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnImprimirResumen', SubmitType::class, ['label' => 'Imprimir resumen', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnCargarContratos', SubmitType::class, ['label' => 'Cargar contratos', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnCargarContratos')->isClicked()) {
                $em->getRepository(RhuContrato::class)->cargarContratos($arProgramacion, $this->getUser()->getCodigoEmpresaFk());
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(RhuProgramacion::class)->autorizar($arProgramacion, $this->getUser()->getNombres(), $this->getUser()->getCodigoEmpresaFk());
            }
        }

        $arProgramacionDetalles = $paginator->paginate($em->getRepository(RhuProgramacionDetalle::class)->lista($arProgramacion->getCodigoProgramacionPk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/programacion/detalle.html.twig', [
            'form' => $form->createView(),
            'arProgramacion' => $arProgramacion,
            'arProgramacionDetalles' => $arProgramacionDetalles
        ]);
    }

}