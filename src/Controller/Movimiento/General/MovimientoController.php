<?php

namespace App\Controller\Movimiento\General;

use App\Controller\Estructura\FuncionesController;
use App\Entity\Empresa;
use App\Entity\Impuesto;
use App\Entity\Item;
use App\Entity\MovimientoTipo;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Entity\Tercero;
use App\Form\Type\MovimientoType;
use App\Formatos\Compra;
use App\Formatos\Entrada;
use App\Formatos\Factura;
use App\Formatos\Factura1;
use App\Formatos\Factura2;
use App\Formatos\Salida;
use App\Repository\EmpresaRepository;
use App\Utilidades\FacturaElectronica;
use App\Utilidades\Mensajes;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
     * @Route("/movimiento/general/lista/{movimientoTipo}", name="movimiento_general_lista")
     */
    public function lista(Request $request, $movimientoTipo)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroMovimientoFechaDesde') ? date_create($session->get('filtroMovimientoFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroMovimientoFechaHasta') ? date_create($session->get('filtroMovimientoFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(Tercero::class)->llenarCombo($empresa))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnExcel', SubmitType::class, ['label' => 'Excel', 'attr' => ['class' => 'btn btn-sm btn-default']])
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
                $this->get("UtilidadesModelo")->eliminar(Movimiento::class, $arItems);
                return $this->redirect($this->generateUrl('movimiento_general_lista', ['movimientoTipo' => $movimientoTipo]));
            }
            if ($form->get('btnExcel')->isClicked()) {
                $arMovimientos = $em->getRepository(Movimiento::class)->lista($movimientoTipo, $empresa);
                $this->exportarExcel($arMovimientos);
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(Movimiento::class)->lista($movimientoTipo, $empresa), $request->query->getInt('page', 1), 30);
        return $this->render('movimiento/general/lista.html.twig', [
            'arMovimientos' => $arMovimientos,
            'movimientoTipo' => $movimientoTipo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/movimiento/general/nuevo/{id}/{movimientoTipo}", name="movimiento_general_nuevo")
     */
    public function nuevo(Request $request, $id, $movimientoTipo)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $em->getRepository(Empresa::class)->find($this->getUser()->getCodigoEmpresaFk());
        if($movimientoTipo == 'FAC' || $movimientoTipo == 'NC' || $movimientoTipo == 'ND' ) {
            if(!$arEmpresa->getCodigoResolucionFk()) {
                Mensajes::error("Para crear una documento factura debe tener una resolucion asignada");
                return $this->redirect($this->generateUrl('movimiento_general_lista', array('movimientoTipo' => $movimientoTipo)));
            }
        }
        $arMovimiento = new Movimiento();
        $arMovimientoTipo = $em->getRepository(MovimientoTipo::class)->find($movimientoTipo);
        if ($id == 0) {
            $arMovimiento->setEmpresaRel($arEmpresa);
            if($movimientoTipo == 'FAC' || $movimientoTipo == 'NC' || $movimientoTipo == 'ND') {
                $arMovimiento->setResolucionRel($arEmpresa->getResolucionRel());
            }
            $arMovimiento->setFecha(new \DateTime('now'));
            $arMovimiento->setFechaVence(new \DateTime('now'));
        } else {
            $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        }
        $arMovimiento->setMovimientoTipoRel($arMovimientoTipo);
        $form = $this->createForm(MovimientoType::class, $arMovimiento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arMovimiento = $form->getData();
                $em->persist($arMovimiento);
                $em->flush();
                return $this->redirect($this->generateUrl('movimiento_general_detalle', array('id' => $arMovimiento->getCodigoMovimientoPk())));
            }
        }
        return $this->render('movimiento/general/nuevo.html.twig', [
            'arMovimiento' => $arMovimiento,
            'movimientoTipo' => $movimientoTipo,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/movimiento/general/detalle/{id}", name="movimiento_general_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  $arMovimiento Movimiento */
        $paginator = $this->get('knp_paginator');
        $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        $arrBtnEliminar = ['label' => 'Eliminar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-danger']];
        $arrBtnActualizar = ['label' => 'Actualizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAutorizar = ['label' => 'Autorizar', 'disabled' => false, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnAprobado = ['label' => 'Aprobar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        $arrBtnDesautorizar = ['label' => 'Desautorizar', 'disabled' => true, 'attr' => ['class' => 'btn btn-sm btn-default']];
        if ($arMovimiento->isEstadoAutorizado()) {
            $arrBtnAutorizar['disabled'] = true;
            $arrBtnEliminar['disabled'] = true;
            $arrBtnAprobado['disabled'] = false;
            $arrBtnActualizar['disabled'] = true;
            $arrBtnDesautorizar['disabled'] = false;
        }
        if ($arMovimiento->isEstadoAprobado()) {
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
                $em->getRepository(MovimientoDetalle::class)->actualizarDetalles($arrControles, $form, $arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_general_detalle', ['id' => $id]));
            }
            if ($form->get('btnAprobado')->isClicked()) {
                $em->getRepository(Movimiento::class)->aprobar($arMovimiento);
                $em->flush();
                return $this->redirect($this->generateUrl('movimiento_general_detalle', ['id' => $id]));
            }
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(Movimiento::class)->autorizar($arMovimiento);
                $em->getRepository(MovimientoDetalle::class)->actualizarDetalles($arrControles, $form, $arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_general_detalle', ['id' => $id]));
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(Movimiento::class)->desautorizar($arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_general_detalle', ['id' => $id]));
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $em->getRepository(MovimientoDetalle::class)->eliminar($arMovimiento, $arrDetallesSeleccionados);
                $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
                return $this->redirect($this->generateUrl('movimiento_general_detalle', ['id' => $id]));
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $em->getRepository(Movimiento::class)->generarFormato([
                    'codigoMovimientoPk' => $arMovimiento->getCodigoMovimientoPk(),
                    'codigoMovimientoTipoFk' => $arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk()],
                    $this->getUser()->getCodigoEmpresaFk(), false);
            }
        }
        $arMovimientoDetalles = $paginator->paginate($em->getRepository(MovimientoDetalle::class)->lista($id), $request->query->getInt('page', 1), 50);
        $arImpuestosRetencion = $em->getRepository(Impuesto::class)->findBy(array('codigoImpuestoTipoFk' => 'R'));
        $arImpuestosIva = $em->getRepository(Impuesto::class)->findBy(array('codigoImpuestoTipoFk' => 'I'));
        return $this->render('movimiento/general/detalle.html.twig', [
            'form' => $form->createView(),
            'arMovimiento' => $arMovimiento,
            'arMovimientoDetalles' => $arMovimientoDetalles,
            'arImpuestosIva' => $arImpuestosIva,
            'arImpuestosRetencion' => $arImpuestosRetencion,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/general/detalle/nuevo/{id}", name="movimiento_general_detalle_nuevo")
     */
    public function detalleNuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $paginator = $this->get('knp_paginator');
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $respuesta = '';
        $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('txtID', IntegerType::class, ['label' => 'ID: ', 'required' => false])
            ->add('txtCodigo', TextType::class, ['label' => 'Codigo: ', 'required' => false])
            ->add('txtReferencia', TextType::class, ['label' => 'Referencia: ', 'required' => false])
            ->add('txtNombre', TextType::class, ['label' => 'Nombre: ', 'required' => false, 'data' => $session->get('filtroItemDescripcion')])
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemId', $form->get('txtID')->getData());
                $session->set('filtroItemCodigo', $form->get('txtCodigo')->getData());
                $session->set('filtroItemReferencia', $form->get('txtReferencia')->getData());
                $session->set('filtroItemNombre', $form->get('txtNombre')->getData());
            }
        }
        if ($form->get('btnGuardar')->isClicked()) {
            $arrItems = $request->request->get('itemCantidad');
            if (count($arrItems) > 0) {
                foreach ($arrItems as $codigoItem => $cantidad) {
                    $arItem = $em->getRepository(Item::class)->find($codigoItem);
                    if ($cantidad != '' && $cantidad != 0) {
                        if ($arItem->isAfectaInventario() == true) {
                            if (($arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk() == "ENT") || ($arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk() == "COM") || ($cantidad <= $arItem->getCantidadExistencia())) {
                            } else {
                                $respuesta = "La cantidad seleccionada para el item: " . $arItem->getDescripcion() . " no puede ser mayor a las existencias del mismo.";
                                break;
                            }
                        }
                        $arMovimientoDetalle = new MovimientoDetalle();
                        $arMovimientoDetalle->setMovimientoRel($arMovimiento);
                        $arMovimientoDetalle->setItemRel($arItem);
                        $arMovimientoDetalle->setVrPrecio($arItem->getVrPrecio());
                        $arMovimientoDetalle->setCantidad($cantidad);
                        $arMovimientoDetalle->setCodigoImpuestoRetencionFk($arItem->getCodigoImpuestoRetencionFk());
                        $arMovimientoDetalle->setCodigoImpuestoIvaFk($arItem->getCodigoImpuestoIvaVentaFk());
                        $arMovimientoDetalle->setPorcentajeIva($arItem->getPorcentajeIva());
                        $em->persist($arMovimientoDetalle);
                    }
                }
                if ($respuesta == '') {
                    $em->flush();
                    $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
                    echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                } else {
                    Mensajes::error($respuesta);
                }
            }
        }
        $arItems = $paginator->paginate($em->getRepository(Item::class)->lista($empresa), $request->query->getInt('page', 1), 50);
        return $this->render('movimiento/general/detalleNuevo.html.twig', [
            'form' => $form->createView(),
            'arItems' => $arItems
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/movimiento/general/referencia/{id}", name="movimiento_general_referencia")
     */
    public function referencia(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $paginator = $this->get('knp_paginator');
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('txtNumero', IntegerType::class, ['label' => 'Numero: ', 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemCodigo', $form->get('txtCodigoItem')->getData());
                $session->set('filtroItemDescripcion', $form->get('txtDescripcion')->getData());
            }
            if ($request->request->get('OpSeleccionar')) {
                $codigo = $request->request->get('OpSeleccionar');
                $arMovimientoReferencia = $em->getRepository(Movimiento::class)->find($codigo);
                $arMovimiento->setMovimientoRel($arMovimientoReferencia);
                $em->persist($arMovimiento);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(Movimiento::class)->listaReferencia($arMovimiento->getCodigoTerceroFk(), $empresa), $request->query->getInt('page', 1), 50);
        return $this->render('movimiento/general/referencia.html.twig', [
            'form' => $form->createView(),
            'arMovimientos' => $arMovimientos
        ]);
    }

    /**
     * @Route("/movimiento/general/enviarcorreo/{id}", name="movimiento_general_enviarcorreo")
     */
    public function enviarCorreoElectronica(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('btnEnviar', SubmitType::class, ['label' => 'Enviar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEnviar')->isClicked()) {
                $facturaElectronica = new FacturaElectronica($em);
                $facturaElectronica->correo($id, $this->getUser()->getCodigoEmpresaFk());
            }
        }
        return $this->render('movimiento/general/enviarCorreoFE.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function exportarExcel($arMovimientos)
    {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $libro = new Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setTitle('movimiento');
        $j = 0;
        $arrColumnas = ['ID', 'DOCUMENTO', 'NUMERO', 'FECHA', 'REF', 'COD', 'NIT', 'TERCERO', 'CC','SUBTOTAL', 'IVA', 'NETO'];
        for ($i = 'A'; $j <= sizeof($arrColumnas) - 1; $i++) {
            $hoja->getColumnDimension($i)->setAutoSize(true);
            $hoja->getStyle(1)->getFont()->setName('Arial')->setSize(8);
            $hoja->getStyle(1)->getFont()->setBold(true);
            $hoja->setCellValue($i . '1', strtoupper($arrColumnas[$j]));
            $j++;
        }
        $j = 2;
        foreach ($arMovimientos as $arMovimiento) {
            $hoja->getStyle($j)->getFont()->setName('Arial')->setSize(8);
            $hoja->getStyle("I{$j}:K{$j}")->getNumberFormat()->setFormatCode('#,##0');
            $hoja->getStyle("D{$j}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            $hoja->setCellValue('A' . $j, $arMovimiento['codigoMovimientoPk']);
            $hoja->setCellValue('B' . $j, $arMovimiento['documentoNombre']);
            $hoja->setCellValue('C' . $j, $arMovimiento['numero']);
            $hoja->setCellValue('D' . $j, Date::PHPToExcel($arMovimiento['fecha']->format('Y-m-d')));
            $hoja->setCellValue('E' . $j, $arMovimiento['referencia']);
            $hoja->setCellValue('F' . $j, $arMovimiento['codigoTerceroFk']);
            $hoja->setCellValue('G' . $j, $arMovimiento['terceroNumeroIdentificacion']);
            $hoja->setCellValue('H' . $j, $arMovimiento['terceroNombreCorto']);
            $hoja->setCellValue('I' . $j, $arMovimiento['centroCostoNombre']);
            $hoja->setCellValue('J' . $j, $arMovimiento['vrSubtotal']);
            $hoja->setCellValue('K' . $j, $arMovimiento['vrIva']);
            $hoja->setCellValue('L' . $j, $arMovimiento['vrTotalNeto']);
            $j++;
        }

        $libro->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="movimiento.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = new Xlsx($libro);
        $writer->save('php://output');
        exit;

    }

}


