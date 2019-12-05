<?php

namespace App\Controller\Inventario\Movimiento;

use App\Entity\Inventario\InvContrato;
use App\Entity\Inventario\InvContratoDetalle;
use App\Entity\Inventario\InvItem;
use App\Entity\General\GenTercero;
use App\Form\Type\Inventario\Contrato\ContratoType;
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

class ContratoController extends Controller
{
    /**
     * @Route("/inventario/contrato/lista", name="inventario_contrato_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroContratoFechaDesde') ? date_create($session->get('filtroContratoFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroContratoFechaHasta') ? date_create($session->get('filtroContratoFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(GenTercero::class)->llenarCombo($empresa))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroContratoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroContratoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('filtroContratoTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('filtroContratoTercero', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(InvContrato::class, $arItems);
                return $this->redirect($this->generateUrl('inventario_contrato_lista'));
            }
        }
        $arContratos = $paginator->paginate($em->getRepository(InvContrato::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('Inventario/Contrato/lista.html.twig', [
            'arContratos' => $arContratos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inventario/contrato/nuevo/{id}/", name="inventario_contrato_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arContratos = new InvContrato();
        if ($id != 0) {
            $arContratos = $em->getRepository(InvContrato::class)->find($id);
        }
        $form = $this->createForm(ContratoType::class, $arContratos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($id == 0) {
                    $arContratos->setFecha(new \DateTime('now'));
                }
                $arContratos = $form->getData();
                $arContratos->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arContratos);
                $em->flush();
                return $this->redirect($this->generateUrl('inventario_contrato_detalle', array('id' => $arContratos->getCodigoContratoPk())));
            }
        }
        return $this->render('Inventario/Contrato/nuevo.html.twig', [
            'arContratos' => $arContratos,
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
     * @Route("/inventario/contrato/detalle/{id}", name="inventario_contrato_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arContrato = $em->getRepository(InvContrato::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arContrato->isEstadoAutorizado()) {
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
        }
        if ($arContrato->isEstadoAprobado()) {
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
                $em->getRepository(InvContratoDetalle::class)->actualizarDetalles($arrControles, $form, $arContrato);
                return $this->redirect($this->generateUrl('inventario_contrato_detalle', ['id' => $id]));
            }
//            if ($form->get('btnAprobado')->isClicked()) {
//                $em->getRepository(InvContrato::class)->aprobar($arContrato);
//                return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
//            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(InvContrato::class)->autorizar($arContrato);
                $em->getRepository(InvContratoDetalle::class)->actualizarDetalles($arrControles, $form, $arContrato);
                return $this->redirect($this->generateUrl('inventario_contrato_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(InvContrato::class)->desautorizar($arContrato);
                return $this->redirect($this->generateUrl('inventario_contrato_detalle', ['id' => $id]));
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(InvContratoDetalle::class)->eliminar($arContrato, $arrDetallesSeleccionados);
                $em->getRepository(InvContrato::class)->liquidar($arContrato);
                return $this->redirect($this->generateUrl('inventario_contrato_detalle', ['id' => $id]));
            }
//            if ($form->get('btnImprimir')->isClicked()) {
//                    $objFormato->Generar($em, $arContrato->getCodigoContratoPk());
//            }
        }
        $arContratoDetalles = $paginator->paginate($em->getRepository(InvContratoDetalle::class)->lista($id), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Contrato/detalle.html.twig', [
            'form' => $form->createView(),
            'arContrato' => $arContrato,
            'arContratoDetalles' => $arContratoDetalles
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/inventario/contrato/detalle/nuevo/{id}", name="inventario_contrato_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $respuesta = '';
        $arContrato = $em->getRepository(InvContrato::class)->find($id);
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
                        $arContratoDetalle = new InvContratoDetalle();
                        $arContratoDetalle->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                        $arContratoDetalle->setContratoRel($arContrato);
                        $arContratoDetalle->setItemRel($arItem);
                        $arContratoDetalle->setCantidad($cantidad);
                        $arContratoDetalle->setPorcentajeIva($arItem->getPorcentajeIva());
                        $em->persist($arContratoDetalle);
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
        $arItems = $paginator->paginate($em->getRepository(InvItem::class)->lista($empresa), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Contrato/detalleNuevo.html.twig', [
            'form' => $form->createView(),
            'arItems' => $arItems
        ]);
    }
}


