<?php

namespace App\Controller\Inventario\Movimiento;

use App\Entity\Inventario\InvDocumento;
use App\Entity\Inventario\InvItem;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Entity\Inventario\InvTercero;
use App\Form\Type\MovimientoType;
use App\Formatos\Factura;
use App\Utilidades\Mensajes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MovimientoController extends Controller
{
    /**
     * @Route("/movimiento/lista/{documento}", name="movimiento_lista")
     */
    public function lista(Request $request, $documento)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroMovimientoFechaDesde') ? date_create($session->get('filtroMovimientoFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroMovimientoFechaHasta') ? date_create($session->get('filtroMovimientoFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(InvTercero::class)->llenarCombo())
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroMovimientoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroMovimientoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('filtroMovimientoTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('filtroMovimientoTercero', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(InvMovimiento::class, $arItems);
                return $this->redirect($this->generateUrl('movimiento_lista'));
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(InvMovimiento::class)->lista($documento), $request->query->getInt('page', 1), 30);
        return $this->render('Inventario/Movimiento/lista.html.twig', [
            'arMovimientos' => $arMovimientos,
            'documento' => $documento,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movimiento/nuevo/{id}/{documento}", name="movimiento_nuevo")
     */
    public function nuevo(Request $request, $id, $documento)
    {
        $em = $this->getDoctrine()->getManager();
        $arMovimiento = new InvMovimiento();
        $arDocumento = $em->getRepository(InvDocumento::class)->find($documento);
        if ($id != 0) {
            $arMovimiento = $em->getRepository(InvMovimiento::class)->find($id);
        }
        $arMovimiento->setDocumentoRel($arDocumento);
        $form = $this->createForm(MovimientoType::class, $arMovimiento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($id == 0) {
                    $arMovimiento->setFecha(new \DateTime('now'));
                }
                $arMovimiento = $form->getData();
                $arMovimiento->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arMovimiento);
                $em->flush();
                return $this->redirect($this->generateUrl('movimiento_detalle', array('id' => $arMovimiento->getCodigoMovimientoPk())));
            }
        }
        return $this->render('Inventario/Movimiento/nuevo.html.twig', [
            'arMovimiento' => $arMovimiento,
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
     * @Route("/movimiento/detalle/{id}", name="movimiento_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  $arMovimiento InvMovimiento */
        $paginator = $this->get('knp_paginator');
        $arMovimiento = $em->getRepository(InvMovimiento::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arMovimiento->getEstadoAutorizado()) {
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
        }
        if ($arMovimiento->getEstadoAprobado()) {
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
                $em->getRepository(InvMovimientoDetalle::class)->actualizarDetalles($arrControles, $form, $arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
            }
            if ($form->get('btnAprobado')->isClicked()) {
                $em->getRepository(InvMovimiento::class)->aprobar($arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(InvMovimiento::class)->autorizar($arMovimiento);
                $em->getRepository(InvMovimientoDetalle::class)->actualizarDetalles($arrControles, $form, $arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(InvMovimiento::class)->desautorizar($arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(InvMovimientoDetalle::class)->eliminar($arMovimiento, $arrDetallesSeleccionados);
                $em->getRepository(InvMovimiento::class)->liquidar($arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormato = new Factura();
                $objFormato->Generar($em, $arMovimiento->getCodigoMovimientoPk());
            }
        }
        $arMovimientoDetalles = $paginator->paginate($em->getRepository(InvMovimientoDetalle::class)->lista($id), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Movimiento/detalle.html.twig', [
            'form' => $form->createView(),
            'arMovimiento' => $arMovimiento,
            'arMovimientoDetalles' => $arMovimientoDetalles
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/detalle/nuevo/{id}", name="movimiento_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $respuesta = '';
        $arMovimiento = $em->getRepository(InvMovimiento::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('txtCodigoItem', IntegerType::class, ['label' => 'Codigo: ', 'required' => false])
            ->add('txtDescripcion', TextType::class, ['label' => 'Nombre: ', 'required' => false, 'data' => $session->get('filtroItemDescripcion')])
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemCodigo', $form->get('txtCodigoItem')->getData());
                $session->set('filtroItemDescripcion', $form->get('txtDescripcion')->getData());
            }
        }
        if ($form->get('btnGuardar')->isClicked()) {
            $arrItems = $request->request->get('itemCantidad');
            if (count($arrItems) > 0) {
                foreach ($arrItems as $codigoItem => $cantidad) {
                    $arItem = $em->getRepository(InvItem::class)->find($codigoItem);
                    if ($cantidad != '' && $cantidad != 0) {
                        if (($arMovimiento->getDocumentoRel()->getCodigoDocumentoPk() == "ENT") || ($arMovimiento->getDocumentoRel()->getCodigoDocumentoPk() == "COM") || ($cantidad <= $arItem->getCantidadExistencia())) {
                            $arMovimientoDetalle = new InvMovimientoDetalle();
                            $arMovimientoDetalle->setMovimientoRel($arMovimiento);
                            $arMovimientoDetalle->setItemRel($arItem);
                            $arMovimientoDetalle->setCantidad($cantidad);
                            $arMovimientoDetalle->setPorcentajeIva($arItem->getPorcentajeIva());
                            $em->persist($arMovimientoDetalle);
                        } else {
                            $respuesta = "La cantidad seleccionada para el item: " . $arItem->getDescripcion() . " no puede ser mayor a las existencias del mismo.";
                            break;
                        }
                    }
                }
                if ($respuesta == '') {
                    $em->flush();
                    echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                } else {
                    Mensajes::error($respuesta);
                }
            }
        }
        $arItems = $paginator->paginate($em->getRepository(InvItem::class)->lista(), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Movimiento/detalleNuevo.html.twig', [
            'form' => $form->createView(),
            'arItems' => $arItems
        ]);
    }
}

