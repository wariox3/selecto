<?php


namespace App\Controller\Informe;


use App\Entity\Tercero;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class VentaController  extends Controller
{
    /**
     * @Route("/informe/venta/lista/", name="informe_venta_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('fitroInformeVentasFechaDesde') ? date_create($session->get('fitroInformeVentasFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('fitroInformeVentasFechaHasta') ? date_create($session->get('fitroInformeVentasFechaHasta')) : null])
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(Tercero::class)->llenarCombo($empresa))
            ->add('btnExcel', SubmitType::class, ['label' => 'Excel', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('fitroInformeVentasFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('fitroInformeVentasFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('fitroInformeVentasTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('fitroInformeVentasTercero', null);
                }
            }
            if ($form->get('btnExcel')->isClicked()) {
                $arMovimiento = $em->getRepository(Movimiento::class)->informeVenta($empresa);
                $this->excel($arMovimiento);
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(Movimiento::class)->informeVenta($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('informe/venta/venta.html.twig', [
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/informe/ventadetalle/lista/", name="informe_ventadetalle_lista")
     */
    public function listaDetalle(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('numero', NumberType::class, ['required' => false, 'data'=>$session->get('fitroInformeVentaDetalleNumero')])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('fitroInformeVentaDetalleFechaDesde') ? date_create($session->get('fitroInformeVentaDetalleFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('fitroInformeVentaDetalleFechaHasta') ? date_create($session->get('fitroInformeVentaDetalleFechaHasta')) : null])
            ->add('cboItemRel', EntityType::class, $em->getRepository(Item::class)->llenarCombo($empresa))
            ->add('btnExcel', SubmitType::class, ['label' => 'Excel', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('fitroInformeVentaDetalleFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('fitroInformeVentaDetalleFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('fitroInformeVentaDetalleNumero', $form->get('numero')->getData() ? $form->get('numero')->getData() : null);
                $arItem = $form->get('cboItemRel')->getData();
                if ($arItem) {
                    $session->set('fitroInformeVentaDetalleItem', $arItem->getCodigoItemPk());
                } else {
                    $session->set('fitroInformeVentaDetalleItem', null);
                }
            }
            if ($form->get('btnExcel')->isClicked()) {
                $arMovimientoDetalles = $em->getRepository(MovimientoDetalle::class)->informeVenta($empresa)->getQuery()->execute();
                $this->excelDetalle($arMovimientoDetalles);
            }
        }
        $arMovimientoDetalles = $paginator->paginate($em->getRepository(MovimientoDetalle::class)->informeVenta($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('informe/venta/ventaDetalle.html.twig', [
            'arMovimientoDetalles' => $arMovimientoDetalles,
            'form' => $form->createView()
        ]);
    }

    public function excel($arMovimientos)
    {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $libro = new Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setTitle('movimiento');
        $j = 0;
        $arrColumnas = ['ID','TIPO', 'NUMERO','FECHA', 'REFERENCIA', 'NIT', 'TERCERO', 'CC','SUBTOTAL','IVA','NETO'];
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
            $hoja->getStyle("D{$j}:D{$j}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            $hoja->getStyle("I{$j}:K{$j}")->getNumberFormat()->setFormatCode('#,##0');
            $hoja->setCellValue('A' . $j, $arMovimiento['codigoMovimientoPk']);
            $hoja->setCellValue('B' . $j, $arMovimiento['movimientoTipoNombre']);
            $hoja->setCellValue('C' . $j, $arMovimiento['numero']);
            $hoja->setCellValue('D' . $j, Date::PHPToExcel($arMovimiento['fecha']->format("Y-m-d")));
            $hoja->setCellValue('E' . $j, $arMovimiento['referencia']);
            $hoja->setCellValue('F' . $j, $arMovimiento['terceroNumeroIdentificacion']);
            $hoja->setCellValue('G' . $j, $arMovimiento['terceroNombreCorto']);
            $hoja->setCellValue('H' . $j, $arMovimiento['centroCostoNombre']);
            $hoja->setCellValue('I' . $j, $arMovimiento['vrSubtotal']);
            $hoja->setCellValue('J' . $j, $arMovimiento['vrIva']);
            $hoja->setCellValue('K' . $j, $arMovimiento['vrTotalNeto']);
            $j++;
        }
        $libro->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=ventas.xls");
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($libro, 'Xls');
        $writer->save('php://output');
        $writer = new Xlsx($libro);
        $writer->save('php://output');
        exit;

    }


    public function excelDetalle($arMovimientos)
    {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $libro = new Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setTitle('movimiento detalle');
        $j = 0;
        $arrColumnas = ['ID', 'TP', 'NUMERO', 'FECHA', 'NIT', 'NOMBRE', 'CC', 'COD', 'ITEM','REF', 'CANT', 'PRECIO','DCTO','SUBTOTAL', 'IVA', 'TOTAL'];
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
            $hoja->getStyle("D{$j}:D{$j}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            $hoja->getStyle("L{$j}:P{$j}")->getNumberFormat()->setFormatCode('#,##0');
            $hoja->setCellValue('A' . $j, $arMovimiento['codigoMovimientoDetallePk']);
            $hoja->setCellValue('B' . $j, $arMovimiento['codigoMovimientoTipoFk']);
            $hoja->setCellValue('C' . $j, $arMovimiento['movimientoNumero']);
            $hoja->setCellValue('D' . $j, Date::PHPToExcel($arMovimiento['movimientoFecha']->format("Y-m-d")));
            $hoja->setCellValue('E' . $j, $arMovimiento['terceroNumeroIdentificacion']);
            $hoja->setCellValue('F' . $j, $arMovimiento['terceroNombreCorto']);
            $hoja->setCellValue('G' . $j, $arMovimiento['centroCostoNombre']);
            $hoja->setCellValue('H' . $j, $arMovimiento['codigoItemFk']);
            $hoja->setCellValue('I' . $j, $arMovimiento['itemNombre']);
            $hoja->setCellValue('J' . $j, $arMovimiento['referencia']);
            $hoja->setCellValue('K' . $j, $arMovimiento['cantidad']);
            $hoja->setCellValue('L' . $j, $arMovimiento['vrPrecio']);
            $hoja->setCellValue('M' . $j, $arMovimiento['porcentajeDescuento']);
            $hoja->setCellValue('N' . $j, $arMovimiento['vrSubtotal']);
            $hoja->setCellValue('O' . $j, $arMovimiento['vrIva']);
            $hoja->setCellValue('P' . $j, $arMovimiento['vrTotal']);
            $j++;
        }

        $libro->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=ventasDetalle.xls");
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($libro, 'Xls');
        $writer->save('php://output');
        $writer = new Xlsx($libro);
        $writer->save('php://output');
        exit;

    }
}