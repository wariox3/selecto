<?php

namespace App\Controller\Compra\Movimiento\Egreso;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Entity\Compra\ComCuentaPagar;
use App\Entity\Compra\ComEgreso;
use App\Entity\Compra\ComEgresoDetalle;
use App\Entity\General\GenCuenta;
use App\Entity\General\GenDocumento;
use App\Entity\General\GenTercero;
use App\Form\Type\Cartera\ReciboType;
use App\Form\Type\Compra\EgresoType;
use App\Formatos\Egreso;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class EgresoController extends Controller
{

    /**
     * @Route("/compra/movimiento/egreso/egreso/lista/{documento}", name="egreso_lista")
     */
    public function lista(Request $request, $documento)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha Desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroReciboFechaDesde') ? date_create($session->get('filtroReciboFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha Hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroReciboFechaHasta') ? date_create($session->get('filtroReciboFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(GenTercero::class)->llenarCombo($empresa))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroEgresoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroEgresoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('filtroMovimientoTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('filtroMovimientoTercero', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(ComEgreso::class, $arItems);
                return $this->redirect($this->generateUrl('recibo_lista'));
            }
        }
        $arEgresos = $paginator->paginate($em->getRepository(ComEgreso::class)->lista($empresa), $request->query->getInt('page', 1), 50);
        return $this->render('Compra/Movimiento/Egreso/lista.html.twig', [
            'arEgresos' => $arEgresos,
            'documento' => $documento,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compra/movimiento/egreso/egreso/nuevo/{id}/{documento}", name="egreso_nuevo")
     */
    public function nuevo(Request $request, $id, $documento)
    {
        $em = $this->getDoctrine()->getManager();
        $arEgreso = new ComEgreso();
        $arDocumento = $em->getRepository(GenDocumento::class)->find($documento);
        if ($id == 0) {
            $arEgreso->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
            $arEgreso->setFechaPago(new \DateTime('now'));
        } else {
            $arEgreso = $em->getRepository(ComEgreso::class)->find($id);
        }
        $arEgreso->setDocumentoRel($arDocumento);
        $form = $this->createForm(EgresoType::class, $arEgreso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($id == 0) {
                    $arEgreso->setFecha(new \DateTime('now'));
                }
                $arEgresos = $form->getData();
                $arEgresos->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFK());
                $em->persist($arEgreso);
                $em->flush();
                return $this->redirect($this->generateUrl('egreso_detalle', ['id' => $arEgreso->getCodigoEgresoPk()]));
            }
        }
        return $this->render('Compra/Movimiento/Egreso/nuevo.html.twig', [
            'arEgreso' => $arEgreso,
            'documento' => $documento,
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
     * @Route("/compra/movimiento/egreso/detalle/{id}", name="egreso_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arEgreso = $em->getRepository(ComEgreso::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arEgreso->getEstadoAutorizado()) {
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
        }
        if ($arEgreso->getEstadoAprobado()) {
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
                $em->getRepository(ComEgresoDetalle::class)->actualizarDetalles($arrControles, $form, $arEgreso);
                return $this->redirect($this->generateUrl('egreso_detalle', ['id' => $id]));
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(ComEgreso::class)->autorizar($arEgreso);
                return $this->redirect($this->generateUrl('egreso_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(ComEgreso::class)->desautorizar($arEgreso);
                return $this->redirect($this->generateUrl('egreso_detalle', ['id' => $id]));
            }
            if ($form->get('btnAprobado')->isClicked()) {
                $em->getRepository(ComEgreso::class)->aprobar($arEgreso);
                return $this->redirect($this->generateUrl('egreso_detalle', ['id' => $id]));
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormato = new Egreso();
                $objFormato->Generar($em, $arEgreso->getCodigoEgresoPk(), $arEgreso->getCodigoEmpresaFk());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(ComEgresoDetalle::class)->eliminar($arEgreso, $arrDetallesSeleccionados);
                $em->getRepository(ComEgreso::class)->liquidar($arEgreso);
            }
        }
        $arEgresoDetalles = $paginator->paginate($em->getRepository(ComEgresoDetalle::class)->lista($id), $request->query->getInt('page', 1), 50);
        return $this->render('Compra/Movimiento/Egreso/detalle.html.twig', [
            'form' => $form->createView(),
            'arEgreso' => $arEgreso,
            'arEgresoDetalles' => $arEgresoDetalles
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("/compra/movimiento/egreso/detalle/nuevo/{id}", name="egreso_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $paginator = $this->get('knp_paginator');
        $arEgreso = $em->getRepository(ComEgreso::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $arrControles = $request->request->All();
                if ($arrSeleccionados) {
                    foreach ($arrSeleccionados AS $codigoCuentaPagar) {
                        $arCuentaPagar = $em->getRepository(ComCuentaPagar::class)->find($codigoCuentaPagar);
                        $arEgresoDetalle = new ComEgresoDetalle();
                        $arEgresoDetalle->setEgresoRel($arEgreso);
                        $saldo = $arrControles['TxtSaldo' . $codigoCuentaPagar];
                        $pagoAfectar = $arrControles['TxtSaldo' . $codigoCuentaPagar];
                        $arEgresoDetalle->setVrPago($saldo);
                        $arEgresoDetalle->setCuentaPagarRel($arCuentaPagar);
                        $arEgresoDetalle->setCuentaPagarTipoRel($arCuentaPagar->getCuentaPagarTipoRel());
                        $arEgresoDetalle->setVrPagoAfectar($pagoAfectar);
                        $arEgresoDetalle->setNumeroCompra($arCuentaPagar->getNumeroDocumento());
                        $arEgresoDetalle->setOperacion(1);
                        $em->persist($arEgresoDetalle);
                    }
                    $em->flush();
                }
                $em->getRepository(ComEgreso::class)->liquidar($id);
            }
            echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        $arCuentasPagar = $paginator->paginate($em->getRepository(ComCuentaPagar::class)->cuentasPagar($empresa, $arEgreso->getCodigoTerceroFk()), $request->query->getInt('page', 1), 50);
        return $this->render('Compra/Movimiento/Egreso/detalleNuevo.html.twig', array(
            'form' => $form->createView(),
            'arCuentasPagar' => $arCuentasPagar,
            'arEgreso' => $arEgreso,
        ));
    }
}


