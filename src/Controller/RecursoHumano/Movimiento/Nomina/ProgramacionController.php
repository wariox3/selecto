<?php

namespace App\Controller\RecursoHumano\Movimiento\Nomina;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuNovedad;
use App\Entity\RecursoHumano\RhuPago;
use App\Entity\RecursoHumano\RhuPagoDetalle;
use App\Entity\RecursoHumano\RhuPagoTipo;
use App\Entity\RecursoHumano\RhuProgramacion;
use App\Entity\RecursoHumano\RhuProgramacionDetalle;
use App\Form\Type\RecursoHumano\ProgramacionType;
use App\Formatos\Programacion;
use App\Formatos\ResumenConceptos;
use App\Utilidades\Mensajes;
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
        return $this->render('recursoHumano/Movimiento/Nomina/Programacion/lista.html.twig', [
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
        return $this->render('recursoHumano/Movimiento/Nomina/Programacion/nuevo.html.twig', [
            'arProgramacion' => $arProgramacion,
            'form' => $form->createView()
        ]);


    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/recursoHumano/movimiento/nomina/programacion/detalle/{id}", name="recursoHumano_programacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arProgramacion = $em->getRepository(RhuProgramacion::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnCargarContratos = ['label' => 'Cargar Contratos', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnEliminarTodos = ['attr' => ['class' => 'btn btn-sm btn-danger'], 'label' => 'Eliminar todos'];
        if ($arProgramacion->getEstadoAutorizado()) {
            $arrBtnCargarContratos['disabled'] = true;
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
            $arrBtnEliminarTodos['attr']['class'] .= ' hidden';
        }
        if ($arProgramacion->getEstadoAprobado()) {
            $arrBtnDesautorizar['disabled'] = true;
            $arrBtnAprobado['disabled'] = true;
        }
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, $arrBtnEliminar)
            ->add('btnAutorizar', SubmitType::class, $arrBtnAutorizar)
            ->add('btnDesautorizar', SubmitType::class, $arrBtnDesautorizar)
            ->add('btnImprimir', SubmitType::class, ['label' => 'Imprimir', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnAprobar', SubmitType::class, $arrBtnAprobado)
            ->add('btnAnular', SubmitType::class, ['label' => 'Anular', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnImprimirResumen', SubmitType::class, ['label' => 'Imprimir resumen', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminarTodos', SubmitType::class, $arrBtnEliminarTodos)
            ->add('btnCargarContratos', SubmitType::class, $arrBtnCargarContratos)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arrSeleccionados = $request->request->get('ChkSeleccionar');
            if ($form->get('btnCargarContratos')->isClicked()) {
                $em->getRepository(RhuContrato::class)->cargarContratos($arProgramacion, $this->getUser()->getCodigoEmpresaFk());
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(RhuProgramacion::class)->autorizar($arProgramacion, $this->getUser()->getNombres(), $this->getUser()->getCodigoEmpresaFk());
                return $this->redirect($this->generateUrl('recursoHumano_programacion_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(RhuProgramacion::class)->desautorizar($arProgramacion, $this->getUser()->getNombres(), $this->getUser()->getCodigoEmpresaFk());
                return $this->redirect($this->generateUrl('recursoHumano_programacion_detalle', ['id' => $id]));
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormato = new Programacion();
                $objFormato->Generar($em, $id, $this->getUser()->getCodigoEmpresaFk());
            }
            if ($form->get('btnImprimirResumen')->isClicked()) {
                $objFormato = new ResumenConceptos();
                $objFormato->Generar($em, $id, $this->getUser()->getCodigoEmpresafK());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(RhuProgramacionDetalle::class)->eliminar($arrSeleccionados, $arProgramacion);
                return $this->redirect($this->generateUrl('recursoHumano_programacion_detalle', ['id' => $id]));
            }
            if ($form->get('btnEliminarTodos')->isClicked()) {
                if (!$arProgramacion->getEstadoAutorizado()) {
                    $em->getRepository(RhuProgramacionDetalle::class)->eliminarTodoDetalles($arProgramacion);
                    return $this->redirect($this->generateUrl('recursoHumano_programacion_detalle', ['id' => $id]));
                }
            }
        }

        $arProgramacionDetalles = $paginator->paginate($em->getRepository(RhuProgramacionDetalle::class)->lista($arProgramacion->getCodigoProgramacionPk()), $request->query->getInt('page', 1), 30);
        $arNovedades = $paginator->paginate($em->getRepository(RhuNovedad::class)->periodo($arProgramacion->getFechaDesde(), $arProgramacion->getFechaHasta(), ""), $request->query->getInt('page', 1, 30));
        return $this->render('recursoHumano/Movimiento/Nomina/Programacion/detalle.html.twig', [
            'form' => $form->createView(),
            'arProgramacion' => $arProgramacion,
            'arProgramacionDetalles' => $arProgramacionDetalles,
            'arNovedades' => $arNovedades
        ]);
    }

    /**
     * @Route("/recursoHumano/movimiento/nomina/programacion/detalle/resumen/{id}", name="recursoHumano_programacion_resumen")
     */
    public function resumenPagoDetalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arProgramacionDetalle = $em->getRepository(RhuProgramacionDetalle::class)->find($id);
        $arrBtnActualizar = ['attr' => ['class' => 'btn btn-sm btn-default'], 'label' => 'Actualizar'];
        $form = $this->createFormBuilder()
            ->add('btnActualizar', SubmitType::class, $arrBtnActualizar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnActualizar')->isClicked()) {
                $em->getRepository(RhuProgramacionDetalle::class)->actualizar($arProgramacionDetalle, $this->getUser()->getUsername(), $this->getUser()->getCodigoEmpresaFk());
            }
        }
        if (!$arProgramacionDetalle->getProgramacionRel()->getEstadoAutorizado()) {
            Mensajes::error('El empleado aun no tiene pagos generados');
            echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        $arPago = $em->getRepository(RhuPago::class)->findOneBy(array('codigoProgramacionDetalleFk' => $id));
        if($arPago) {
            $arPagoDetalles = $em->getRepository(RhuPagoDetalle::class)->lista($arPago->getCodigoPagoPk());
        } else {
            $arPagoDetalles = null;
        }
        return $this->render('recursoHumano/Movimiento/Nomina/Programacion/resumen.html.twig', [
            'arProgramacionDetalle' => $arProgramacionDetalle,
            'arPago' => $arPago,
            'arPagoDetalles' => $arPagoDetalles,
            'form' => $form->createView()
        ]);
    }



}