<?php

namespace App\Formatos;

use Symfony\Component\HttpFoundation\Response;


class FormatoActaCapacitacion extends \FPDF
{

    public static $em;
    public static $arImplementacionDetalle;

    public function Generar($em, $arImplementacionDetalle)
    {
        ob_clean();
        self::$em = $em;
        self::$arImplementacionDetalle = $arImplementacionDetalle;
        $pdf = new FormatoActaCapacitacion();
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("ActaCapacitacion" . self::$arImplementacionDetalle->getCodigoImplementacionDetallePk() . ".pdf", 'D');


    }

    public function Header()
    {

        $this->SetFillColor(272, 272, 272);
        $this->SetFont('Arial', 'b', 8);
        $this->SetXY(10, 5);
        $this->Line(10, 5, 60, 5);
        $this->Line(10, 5, 10, 26);
        $this->Line(10, 26, 60, 26);
        if(file_exists('imagenes/logos/'.self::$arImplementacionDetalle->getImplementacionRel()->getClienteRel()->getNombreComercial().'.jpg')){
            $this->Image('imagenes/logos/'.self::$arImplementacionDetalle->getImplementacionRel()->getClienteRel()->getNombreComercial().'.jpg', 12, 7, 35, 17);
        }else{
            $this->Image('imagenes/logos/blanco.jpg', 12, 7, 35, 17);
        }

        $this->SetXY(50, 5);
        $this->SetFont('Arial', 'b', 12);
        $this->Cell(100, 10, "FORMATO CAPACITACION", 1, 0, 'C', 1);
        $this->SetXY(50, 15);
        $this->SetFont('Arial', 'b', 12);
        $this->Cell(100, 11, "REGIMEN ORGANIZACIONAL INTERNO ", 1, 0, 'C', 1);
        $this->SetFont('Arial', 'b', 8);
        $this->SetXY(150, 5);
        $this->Cell(27, 10, utf8_decode("Version: 1"), 1, 0, 'L', 1);
        $this->SetXY(177, 5);
        $this->Cell(27, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 1, 0, 'C', 1);
        $this->SetXY(150, 15);
        $this->Cell(54, 11, utf8_decode("Fecha: " . date("Y-m-d")), 1, 0, 'L', 1);


        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles()
    {
        $this->Ln(14);

        $header = array();
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 6.8);

        $w = array();
        for ($i = 0; $i < count($header); $i++)
            if ($i == 0 || $i == 1)
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'L', 1);
            else
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 1);

        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Ln(4);
    }

    public function Body($pdf)
    {


        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->SetX(10);
        $pdf->Cell(194, 9, "ASISTENCIA ", 1, 0, 'C');
        $pdf->SetFont('Arial', 'b', 8);
        $pdf->SetXY(10, 51.9);
        $pdf->Cell(28.5, 7, "FECHA: ", 1, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(120.5, 7, self::$arImplementacionDetalle->getFechaCapacitacion() != "" ? self::$arImplementacionDetalle->getFechaCapacitacion()->format('Y-m-d') : "", 1, 0, 'L');
        $pdf->SetFont('Arial', 'b', 8);
        $pdf->Cell(13.5, 7, "AREA:", 1, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(31.5, 7, utf8_decode(self::$arImplementacionDetalle->getImplementacionGrupoRel()->getNombre()), 1, 0, 'L');
        $pdf->SetFont('Arial', 'b', 8);
        $pdf->SetY(59);
        $pdf->Cell(28.5, 7, "TEMA Y/O EVENTO: ", 1, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(120.5, 7, utf8_decode(self::$arImplementacionDetalle->getImplementacionTemaRel()->getNombre()), 1, 0, 'L');
        $pdf->SetFont('Arial', 'b', 8);

        $pdf->Cell(13.5, 7, "HORA:", 1, 0, 'L');
        $pdf->Cell(31.5, 7, "", 1, 0, 'L');
        $pdf->SetY(66);
        $pdf->Cell(28.5, 7, "RESPONSABLE: ", 1, 0, 'L');
        $pdf->Cell(120.5, 7, "", 1, 0, 'L');
        $pdf->Cell(13.5, 7, "CARGO: ", 1, 0, 'L');
        $pdf->Cell(31.5, 7, "", 1, 0, 'L');
        $pdf->SetY(73);
        $pdf->Cell(28.5, 7, "EMPRESA: ", 1, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(165.5, 7, utf8_decode(self::$arImplementacionDetalle->getImplementacionRel()->getClienteRel()->getNombreComercial()), 1, 0, 'L');


        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->SetX(10);
        $pdf->Cell(194, 10, "ASISTENCIA ", 1, 0, 'C');
        $pdf->SetXY(10, 103);
        $pdf->Cell(64.6, 7, "CARGO", 1, 0, 'C');
        $pdf->Cell(64.6, 7, "NOMBRE Y APELLIDO", 1, 0, 'C');
        $pdf->Cell(64.6, 7, "FIRMAS DE ASISTENCIA", 1, 0, 'C');
        $pdf->SetY(103);
        $y = 103;
        for ($i = 0; $i <= 12; $i++) {
            $pdf->Cell(64.6, 7, "", 1, 0, 'C');
            $pdf->Cell(64.6, 7, "", 1, 0, 'C');
            $pdf->Cell(64.6, 7, "", 1, 0, 'C');
            $pdf->SetY($y += 7);
        }
        $pdf->Cell(64.6, 7, "NRO ACTA", 1, 0, 'C');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(129.2, 7, self::$arImplementacionDetalle->getCodigoImplementacionDetallePk(), 1, 0, 'C');
        $pdf->SetY($y += 7);
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->Cell(194, 10, "TEMAS ESPECIFICOS ", 1, 0, 'C');
        $pdf->SetY($y += 10);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Rect(10, 211, 194, 60);
        $pdf->MultiCell(194, 5, utf8_decode(self::$arImplementacionDetalle->getImplementacionTemaRel()->getDescripcion()), 0, 'L');


//        $pdf->SetFont('Arial', 'B', 7);
//        $pdf->SetFillColor(272, 272, 272);
//        $pdf->Cell(20, 4, "FECHA: ", 1, 0, 'L',true);
//        $pdf->Cell(25, 4, number_format(0, 0, '.', ','), 1, 0, 'L');
//        $pdf->Ln();
//        $pdf->Cell(151, 4, "", 0, 0, 'R');
//        $pdf->Cell(20, 4, "TEMA Y/O EVENTO: ", 1, 0, 'R',true);
//        $pdf->Cell(25, 4, number_format(0, 0, '.', ','), 1, 0, 'R');
//        $pdf->Ln();
//        $pdf->Cell(151, 4, "", 0, 0, 'R');
//        $pdf->Cell(20, 4, "RESPONSABLE: ", 1, 0, 'R',true);
//        $pdf->Cell(25, 4, number_format(0, 0, '.', ','), 1, 0, 'R');
//        $pdf->Ln(-8);


    }

    public function Footer()
    {

        $this->SetFont('Arial', '', 8);
        $this->Text(170, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }
}
