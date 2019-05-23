<?php

namespace App\Controller\Cartera\Movimiento\Recibo;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Entity\General\GenCuenta;
use App\Entity\Inventario\InvTercero;
use App\Form\Type\Cartera\ReciboType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ReciboController extends Controller
{

    /**
     * @Route("/cartera/movimiento/recibo/recibo/lista", name="recibo_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha Desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroReciboFechaDesde') ? date_create($session->get('filtroReciboFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha Hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroReciboFechaHasta') ? date_create($session->get('filtroReciboFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(InvTercero::class)->llenarCombo($empresa))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroReciboFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroReciboFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('filtroMovimientoTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('filtroMovimientoTercero', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(CarRecibo::class, $arItems);
                return $this->redirect($this->generateUrl('recibo_lista'));
            }
        }
        $arRecibos = $paginator->paginate($em->getRepository(CarRecibo::class)->lista($empresa), $request->query->getInt('page', 1), 50);
        return $this->render('Cartera/Movimiento/Recibo/lista.html.twig', [
            'arRecibos' => $arRecibos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/cartera/movimiento/recibo/recibo/nuevo/{id}", name="recibo_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arRecibo = new CarRecibo();
        if ($id == 0) {
            $arRecibo->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
        } else {
            $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
        }
        $form = $this->createForm(ReciboType::class, $arRecibo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($id == 0) {
                    $arRecibo->setFecha(new \DateTime('now'));
                }
                $arRecibo = $form->getData();
                $arRecibo->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFK());
                $em->persist($arRecibo);
                $em->flush();
                return $this->redirect($this->generateUrl('recibo_detalle', ['id' => $arRecibo->getCodigoReciboPk()]));
            }
        }
        return $this->render('Cartera/Movimiento/Recibo/nuevo.html.twig', [
            'arRecibo' => $arRecibo,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/cartera/movimiento/recibo/detalle/{id}", name="recibo_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arRecibo->getEstadoAutorizado()) {
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
        }
        if ($arRecibo->getEstadoAprobado()) {
            $arrBtnDesautorizar['disabled'] = true;
            $arrBtnAprobado['disabled'] = true;
        }
        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, $arrBtnEliminar)
            ->add('btnActualizar', SubmitType::class, $arrBtnActualizar)
            ->add('btnImprimir', SubmitType::class, ['label' => 'Imprimir', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnAprobado', SubmitType::class, $arrBtnAprobado)
            ->add('btnAutorizar', SubmitType::class, $arrBtnAutorizar)
            ->add('btnDesautorizar', SubmitType::class, $arrBtnDesautorizar)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arrControles = $request->request->all();
            $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
            if ($form->get('btnActualizar')->isClicked()) {
                $em->getRepository(CarReciboDetalle::class)->actualizarDetalles($arrControles, $form, $arRecibo);
                return $this->redirect($this->generateUrl('recibo_detalle', ['id' => $id]));
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(CarRecibo::class)->autorizar($arRecibo);
                return $this->redirect($this->generateUrl('recibo_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(CarRecibo::class)->desautorizar($arRecibo);
                return $this->redirect($this->generateUrl('recibo_detalle', ['id' => $id]));
            }
            if ($form->get('btnAprobado')->isClicked()) {
                $em->getRepository(CarRecibo::class)->aprobar($arRecibo);
                return $this->redirect($this->generateUrl('recibo_detalle', ['id' => $id]));
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(CarReciboDetalle::class)->eliminar($arRecibo, $arrDetallesSeleccionados);
                $em->getRepository(CarRecibo::class)->liquidar($arRecibo);
            }
        }
        $arReciboDetalles = $paginator->paginate($em->getRepository(CarReciboDetalle::class)->lista($id), $request->query->getInt('page', 1), 50);
        return $this->render('Cartera/Movimiento/Recibo/detalle.html.twig', [
            'form' => $form->createView(),
            'arRecibo' => $arRecibo,
            'arReciboDetalles' => $arReciboDetalles
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/cartera/movimiento/recibo/detalle/nuevo/{id}", name="recibo_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $paginator = $this->get('knp_paginator');
        $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $arrControles = $request->request->All();
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados AS $codigoCuentaCobrar) {
                        $arCuentaCobrar = $em->getRepository(CarCuentaCobrar::class)->find($codigoCuentaCobrar);
                        $arReciboDetalle = new CarReciboDetalle();
                        $arReciboDetalle->setReciboRel($arRecibo);
                        $saldo = $arrControles['TxtSaldo' . $codigoCuentaCobrar];
                        $pagoAfectar = $arrControles['TxtSaldo' . $codigoCuentaCobrar];
                        $arReciboDetalle->setVrPago($saldo);
                        $arReciboDetalle->setCuentaCobrarRel($arCuentaCobrar);
                        $arReciboDetalle->setCuentaCobrarTipoRel($arCuentaCobrar->getCuentaCobrarTipoRel());
                        $arReciboDetalle->setVrPagoAfectar($pagoAfectar);
                        $arReciboDetalle->setNumeroFactura($arCuentaCobrar->getNumeroDocumento());
                        $arReciboDetalle->setOperacion(1);
                        $em->persist($arReciboDetalle);
                    }
                    $em->flush();
                }
                $em->getRepository(CarRecibo::class)->liquidar($id);
            }
            echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        $arCuentasCobrar = $paginator->paginate($em->getRepository(CarCuentaCobrar::class)->cuentasCobrar($empresa, $arRecibo->getCodigoTerceroFk()), $request->query->getInt('page', 1), 50);
        return $this->render('Cartera/Movimiento/Recibo/detalleNuevo.html.twig', array(
            'form' => $form->createView(),
            'arCuentasCobrar' => $arCuentasCobrar,
            'arRecibo' => $arRecibo,
        ));
    }
}


