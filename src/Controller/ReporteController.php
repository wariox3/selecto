<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class ReporteController extends Controller{

    /**
     * @Route("/reporte/generar", name="reporte_generar")
     */
    public function generarReportes(Request $request){
        $em = $this->getDoctrine()->getManager();
        $form = $this::createFormBuilder()
            ->add('fecha',DateType::class, array('widget'=> 'choice'))
            ->add('btnGenerarSoportes', SubmitType::class, array('label' => 'Generar soportes'))
            ->add('btnGenerarCasos',SubmitType::class, array('label' => 'Generar casos'))
//            ->add('btnGenerarLlamadas',SubmitType::class, array('label' => 'Generar Llamadas'))
            ->getForm();
        $form->handleRequest($request);

        if($form->get('btnGenerarSoportes')->isClicked()){
            $fechaDesde = $form->get('fecha')->getData()->format("Y-m-d H:i:s");
            $fechaHasta = $form->get('fecha')->getData()->format("Y-m-d")." 23:00:00";
            $arLlamadas = $em->getRepository("App:Llamada")->reporteSoporte($fechaDesde,$fechaHasta);
            $nombre = "Reporte soportes";
            $this->generarExcel($arLlamadas,$nombre);
        }
        if($form->get('btnGenerarCasos')->isClicked()){
            $fecha = $form->get('fecha')->getData()->format("Y-m-d");
            $fechaDesde = strtotime ( '-7 day' , strtotime ( $fecha ) ) ;
            $fechaDesde = date ( 'Y-m-d' , $fechaDesde )." 00:00:00";
            $fechaHasta = $form->get('fecha')->getData()->format("Y-m-d")." 23:00:00";
            $arCasos = $em->getRepository("App:Caso")->reporteCaso($fechaDesde,$fechaHasta);
            $nombre = "Reporte casos";
            $this->generarExcel($arCasos,$nombre);
        }
//        if($form->get('btnGenerarLlamadas')->isClicked()){
//        }

        return $this->render('Reporte/generarReporte.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $arrDatos
     * @param $nombre
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generarExcel($arrDatos,$nombre){

        if (count($arrDatos) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $j = 0;
            //Se obtienen las columnas del archivo
            $arrColumnas = array_keys($arrDatos[0]);
            for ($i = 'A'; $j <= sizeof($arrColumnas) - 1; $i++) {
                $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
                $spreadsheet->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
                $sheet->setCellValue($i . '1', strtoupper($arrColumnas[$j]));
                $j++;
            }
            $j = 1;
            foreach ($arrDatos as $datos) {
                $i = 'A';
                $j++;
                for ($col = 0; $col <= sizeof($arrColumnas) - 1; $col++) {
                    $dato = $datos[$arrColumnas[$col]];
                    if ($dato instanceof \DateTime) {
                        $dato = $dato->format('Y-m-d');
                    }
                    if(is_bool($dato)){
                        $dato = $dato == 1 ? "SI":"NO";
                    }
                    $spreadsheet->getActiveSheet()->getStyle($i)->getFont()->setBold(false);
                    $sheet->setCellValue($i . $j, $dato);
                    $i++;
                }
            }
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename='{$nombre}.xls'");
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
        }
    }
}