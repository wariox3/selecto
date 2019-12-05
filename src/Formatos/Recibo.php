<?php

namespace App\Formatos;

use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Utilidades\Estandares;
use function Complex\subtract;

class Recibo extends \FPDF {

    public static $em;
    public static $codigoRecibo;
    public static $codigoEmpresa;

    public function Generar($em, $codigoRecibo, $codigoEmpresa) {
        ob_clean();
        self::$em = $em;
        self::$codigoRecibo = $codigoRecibo;
        self::$codigoEmpresa = $codigoEmpresa;

        $pdf = new Recibo();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 40);
        $arRecibo = $em->getRepository(CarRecibo::class)->find($codigoRecibo);
        $pdf->SetTextColor(255, 220, 220);
        if ($arRecibo->isEstadoAnulado()) {
            $pdf->RotatedText(90, 150, 'ANULADO', 45);
        } elseif (!$arRecibo->isEstadoAprobado()) {
            $pdf->RotatedText(90, 150, 'SIN APROBAR', 45);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Recibo$codigoRecibo.pdf", 'D');
    }

    /**
     * @throws \Exception
     */
    public function Header() {

        /**
         * @var $arRecibo CarRecibo
         */
        $arRecibo = self::$em->getRepository(CarRecibo::class)->find(self::$codigoRecibo);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 10);
        //INFORMACIÓN EMPRESA
        Estandares::generarEncabezado($this, 'RECIBO DE CAJA', self::$em, null, self::$codigoEmpresa);

        //ENCABEZADO ORDEN DE COMPRA
        $intY = 40;
        $this->SetXY(10, $intY);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "NUMERO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arRecibo->getNumero(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "DOCUMENTO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, $arRecibo->getDocumentoRel()->getNombre(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, "PAGO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, number_format($arRecibo->getVrPago()), 1, 0, 'R', 1);
        $this->SetXY(10, $intY + 4);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "TERCERO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(104, 4, $arRecibo->getTerceroRel()->getNombreCorto(), 1, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, 'TOTAL:', 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, number_format($arRecibo->getVrPagoTotal()), 1, 0, 'R', 1);
        $this->SetXY(10, $intY+8);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "CUENTA BANCO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arRecibo->getCuentaRel()->getNombre(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "NIT:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, $arRecibo->getTerceroRel()->getNumeroIdentificacion(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, '', 1, 0, 'L', 1);
        $this->SetXY(10, $intY+12);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "FECHA:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arRecibo->getFecha()->format('Y-m-d'), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, '', 1, 0, 'L', 1);
        $this->SetXY(10, $intY+16);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "FECHA PAGO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arRecibo->getFechaPago()->format('Y-m-d'), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, "", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, '', 1, 0, 'L', 1);
        $this->SetXY(10, $intY+20);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "COMENTARIO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(158, 4, $arRecibo->getComentario(), 1, 0, 'L', 1);

        $this->EncabezadoDetalles();

    }

    public function EncabezadoDetalles() {
        $this->Ln(12);
        $header = array('ID', 'TIPO','FACTURA', 'FECHA','VALOR', 'SALDO');
        $this->SetFillColor(236, 236, 236);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 7);
        //creamos la cabecera de la tabla.
        $w = array(15, 30, 20, 20, 20, 20);
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

    public function Body($pdf) {
        $arRecibosDetalle = self::$em->getRepository(CarReciboDetalle::class)->listaFormato(self::$codigoRecibo);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 7);
        if($arRecibosDetalle) {
            foreach ($arRecibosDetalle as $arReciboDetalle) {
                $pdf->Cell(15, 4, $arReciboDetalle['codigoReciboDetallePk'], 1, 0, 'L');
                $pdf->Cell(30, 4, substr($arReciboDetalle['cuentaCobrarTipo'], 0 , 18), 1, 0, 'L');
                $pdf->Cell(20, 4, $arReciboDetalle['numeroFactura'], 1, 0, 'L');
                $pdf->Cell(20, 4, $arReciboDetalle['fecha']->format('Y-m-d'), 1, 0, 'L');
                $pdf->Cell(20, 4, number_format($arReciboDetalle['vrPagoAfectar'], 0, '.', ','), 1, 0, 'R');
                $pdf->Cell(20, 4, number_format($arReciboDetalle['vrSaldo'], 0, '.', ','), 1, 0, 'R');
                $pdf->Ln();
                $pdf->SetAutoPageBreak(true, 85);
            }
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
        }
    }

    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    public function Footer()
    {
        $this->Text(188, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

}

?>