<?php

namespace App\Formatos;

use App\Controller\Estructura\FuncionesController;
use App\Entity\Empresa;
use App\Entity\General\GenResolucion;
use App\Entity\Inventario\InvFacturaTipo;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Entity\General\GenTercero;
use App\Utilidades\BaseDatos;
use App\Utilidades\Estandares;
use Doctrine\Common\Persistence\ObjectManager;

class Factura extends \FPDF
{

    public static $em;
    public static $codigoMovimiento;
    public static $codigoEmpresa;

    /**
     * @param $em ObjectManager
     * @param $codigoMovimiento integer
     */
    public function Generar($em, $codigoMovimiento, $codigoEmpresa, $ruta = null)
    {
        self::$em = $em;
        self::$codigoMovimiento = $codigoMovimiento;
        self::$codigoEmpresa = $codigoEmpresa;
        /** @var  $arMovimiento InvMovimiento */
        $arMovimiento = $em->getRepository(InvMovimiento::class)->find($codigoMovimiento);
        ob_clean();
        $pdf = new Factura('P', 'mm', 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 40);
        $pdf->SetTextColor(255, 220, 220);
        if ($arMovimiento->isEstadoAnulado()) {
            $pdf->RotatedText(70, 160, 'ANULADO', 45);
        } elseif (!$arMovimiento->isEstadoAprobado()) {
            $pdf->RotatedText(70, 160, 'SIN APROBAR', 45);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        if($ruta) {
            $pdf->Output($ruta, 'F');
        } else {
            $pdf->Output("Factura{$codigoMovimiento}.pdf", 'D');
        }
    }

    public function Header()
    {
        /** @var  $em ObjectManager */
        $em = self::$em;
        $arMovimiento = $em->getRepository(InvMovimiento::class)->imprimirFactura(self::$codigoMovimiento);
        try {
            if ($arMovimiento['empresaLogo']) {
                $this->Image("data:image/'{$arMovimiento['empresaLogoExtension']}';base64," . base64_encode(stream_get_contents($arMovimiento['empresaLogo'])), 10, 10, 30, 30, $arMovimiento['empresaLogoExtension']);
            }
        } catch (\Exception $exception) {
        }

        $this->SetFont('helvetica', '', 5);
        $date = new \DateTime('now');
        $this->Text(170, 10, $date->format('Y-m-d H:i:s') . ' [Selecto | Facturacion]');

        $this->SetFont('helvetica', 'B', 11);
        $this->Text(140, 20, 'FACTURA ELECTRONICA DE VENTA');
        $this->SetFont('helvetica', 'B', 14);
        $this->Text(170, 25, $arMovimiento['resolucionPrefijo'] .$arMovimiento['numero']);

        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(140, 30);
        $this->Cell(45, 4, 'FECHA EMISION:', 0, 0, 'L', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, $arMovimiento['fecha']->format('Y-m-d'), 0, 0, 'R', 0);

        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(140, 34);
        $this->Cell(45, 4, 'FECHA VENCIMIENTO:', 0, 0, 'L', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, $arMovimiento['fechaVence']->format('Y-m-d'), 0, 0, 'R', 0);

        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(140, 38);
        $this->Cell(45, 4, 'FORMA PAGO:', 0, 0, 'L', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, $arMovimiento['formaPagoNombre'], 0, 0, 'R', 0);

        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(140, 42);
        $this->Cell(45, 4, 'PLAZO PAGO:', 0, 0, 'L', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, $arMovimiento['plazoPago'], 0, 0, 'R', 0);

        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(140, 46);
        $this->Cell(45, 4, 'DOC SOPORTE:', 0, 0, 'L', 0);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, $arMovimiento['documentoSoporte'], 0, 0, 'R', 0);

        $this->SetFont('helvetica', 'B', 11);
        $this->Text(50, 20, utf8_decode($arMovimiento['empresaNombreCorto']));
        $this->SetFont('helvetica', '', 8);
        $this->Text(50, 24, utf8_decode($arMovimiento['empresaTipoPersonaNombre'] . ' - ' . $arMovimiento['empresaRegimenNombre']));
        $this->Text(50, 28, 'NIT: ' . $arMovimiento['empresaNit'] . '-' . $arMovimiento['empresaDigitoVerificacion']);
        $this->Text(50, 32, utf8_decode($arMovimiento['empresaDireccion']));
        $this->Text(50, 36, 'TEL: ' . $arMovimiento['empresaTelefono']);

        $this->SetFont('helvetica', 'B', 8);
        $this->Text(10, 46, 'CLIENTE:');
        $this->Text(10, 50, 'NIT:');
        $this->Text(10, 54, 'DIRECCION:');
        $this->Text(10, 58, 'CIUDAD:');
        $this->Text(10, 62, 'TELEFONO:');

        $this->SetFont('helvetica', '', 8);
        $this->Text(40, 46, utf8_decode($arMovimiento['terceroNombreCorto']));
        $this->Text(40, 50, utf8_decode($arMovimiento['terceroNumeroIdentificacion']));
        $this->Text(40, 54, utf8_decode($arMovimiento['terceroDireccion']));
        $this->Text(40, 58, utf8_decode($arMovimiento['terceroCiudadNombre']));
        $this->Text(40, 62, utf8_decode($arMovimiento['terceroTelefono']));
        $this->Ln();
        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles()
    {
        $this->Ln(6);
        $this->SetXY(10, 64);
        $header = array('#','COD','DESCRIPCION', 'CANT', 'PRECIO', '%DSC', 'SUBTOTAL', 'IVA', 'TOTAL');
        $this->SetFillColor(225, 225, 225);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 7);

        //creamos la cabecera de la tabla.
        $w = array(7, 15, 90, 10, 17, 10, 17, 17, 17);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 1);
        }
        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Ln(4);

    }

    /**
     * @param $pdf
     */
    public function Body($pdf)
    {
        $arMovimientoDetalles = self::$em->getRepository(InvMovimientoDetalle::class)->listaImprimirFactura(self::$codigoMovimiento);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetX(10);
        $contador = 1;
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $pdf->Cell(7, 4, $contador, 1, 0, 'L');
            $pdf->Cell(15, 4, $arMovimientoDetalle['itemCodigo'], 1, 0, 'L');
            $pdf->Cell(90, 4, substr(utf8_decode($arMovimientoDetalle['itemNombre']), 0, 60), 1, 0, 'L');
            $pdf->Cell(10, 4, $arMovimientoDetalle['cantidad'], 1, 0, 'R');
            $pdf->Cell(17, 4, number_format($arMovimientoDetalle['vrPrecio'], 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(10, 4, number_format($arMovimientoDetalle['porcentajeDescuento'], 0,'.', ','), 1, 0, 'R');
            $pdf->Cell(17, 4, number_format($arMovimientoDetalle['vrSubtotal'], 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(17, 4, number_format($arMovimientoDetalle['vrIva'], 0,'.', ','), 1, 0, 'R');
            $pdf->Cell(17, 4, number_format($arMovimientoDetalle['vrTotal']), 1, 0, 'R');
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
            $contador++;
        }
    }

    public function Footer()
    {
        /** @var  $em ObjectManager */
        $em = self::$em;
        $arMovimiento = $em->getRepository(InvMovimiento::class)->imprimirFacturaFooter(self::$codigoMovimiento);
        $this->Ln();
        $this->SetXY(10, 180);
        $this->SetFont('helvetica', 'B', 9);
        $this->SetFillColor(225, 225, 225);
        $this->Cell(150, 5, 'COMENTARIOS', 1, 0, 'C', 1);
        $this->Cell(50, 5, 'TOTALES', 1, 0, 'C', 1);
        $this->Rect(10,185,150,25);
        $this->Rect(160,185,50,25);
        $this->SetXY(10,186);
        $this->MultiCell(150, 3, $arMovimiento['comentario'],0,'L', 0);
        $this->Image(FuncionesController::codigoQr($arMovimiento['cadenaCodigoQr'] . "", $arMovimiento['codigoMovimientoPk']), 168, 211, 33, 33);
        $this->SetXY(162,188);
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(20, 4, 'Subtotal', 0, 0, 'L');
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, number_format($arMovimiento['vrSubtotal']), 0, 0, 'R');
        $this->Ln();
        $this->SetX(162);
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(20, 4, 'Base gravable', 0, 0, 'L');
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, number_format($arMovimiento['vrBaseIva']), 0, 0, 'R');
        $this->Ln();
        $this->SetX(162);
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(20, 4, 'Total impuesto', 0, 0, 'L');
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, number_format($arMovimiento['vrIva']), 0, 0, 'R');
        $this->Ln();
        $this->SetX(162);
        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(20, 4, 'Total', 0, 0, 'L');
        $this->SetFont('helvetica', '', 8);
        $this->Cell(25, 4, number_format($arMovimiento['vrTotalNeto']), 0, 0, 'R');
        $this->Ln();
        $this->SetXY(10, 210);
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(150, 5, 'INFORMACION PAGO', 1, 0, 'C', 1);
        $this->Rect(10,215,150,30);
        $this->SetXY(10, 221);
        $this->SetFont('helvetica', '', 8);
        $this->MultiCell(150, 3,$arMovimiento['empresaInformacionPago'],0,'L', 0);
        $this->SetXY(10, 245);
        $this->Cell(200, 5, $this->devolverNumeroLetras($arMovimiento['vrTotalNeto']), 1, 0, 'L');
        $this->SetXY(10, 250);
        $this->Cell(200, 5, 'CUFE/CUDE: ' . $arMovimiento['cue'], 1, 0, 'L');
        $this->SetXY(10, 255);
        $this->Cell(65, 5, 'Numero de autorizacion: ' . $arMovimiento['resolucionNumero'], 1, 0, 'L');
        $this->Cell(50, 5, 'Rango autorizado: Desde: ' . $arMovimiento['resolucionNumeroDesde'], 1, 0, 'L');
        $this->Cell(50, 5, 'Rango autorizado: Hasta: ' . $arMovimiento['resolucionNumeroHasta'], 1, 0, 'L');
        $this->Cell(35, 5, 'Vigencia: ' . $arMovimiento['resolucionFechaHasta']->format('Y-m-d'), 1, 0, 'L');
        $this->SetXY(10, 260);
        $this->Cell(100, 5, 'Generado por: Selecto App una marca de Semantica Digital S.A.S', 1, 0, 'L');
        $this->Cell(100, 5, 'Proveedor tecnologico: Software Estrategico', 1, 0, 'L');
        $this->Text(188, 275, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

    private function devolverNumeroLetras($num, $fem = true, $dec = true)
    {

        //if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");

        $matuni[2] = "dos";

        $matuni[3] = "tres";

        $matuni[4] = "cuatro";

        $matuni[5] = "cinco";

        $matuni[6] = "seis";

        $matuni[7] = "siete";

        $matuni[8] = "ocho";

        $matuni[9] = "nueve";

        $matuni[10] = "diez";

        $matuni[11] = "once";

        $matuni[12] = "doce";

        $matuni[13] = "trece";

        $matuni[14] = "catorce";

        $matuni[15] = "quince";

        $matuni[16] = "dieciseis";

        $matuni[17] = "diecisiete";

        $matuni[18] = "dieciocho";

        $matuni[19] = "diecinueve";

        $matuni[20] = "veinte";

        $matunisub[2] = "dos";

        $matunisub[3] = "tres";

        $matunisub[4] = "cuatro";

        $matunisub[5] = "quin";

        $matunisub[6] = "seis";

        $matunisub[7] = "sete";

        $matunisub[8] = "ocho";

        $matunisub[9] = "nove";


        $matdec[2] = "veint";

        $matdec[3] = "treinta";

        $matdec[4] = "cuarenta";

        $matdec[5] = "cincuenta";

        $matdec[6] = "sesenta";

        $matdec[7] = "setenta";

        $matdec[8] = "ochenta";

        $matdec[9] = "noventa";

        $matsub[3] = 'mill';

        $matsub[5] = 'bill';

        $matsub[7] = 'mill';

        $matsub[9] = 'trill';

        $matsub[11] = 'mill';

        $matsub[13] = 'bill';

        $matsub[15] = 'mill';

        $matmil[4] = 'millones';

        $matmil[6] = 'billones';

        $matmil[7] = 'de billones';

        $matmil[8] = 'millones de billones';

        $matmil[10] = 'trillones';

        $matmil[11] = 'de trillones';

        $matmil[12] = 'millones de trillones';

        $matmil[13] = 'de trillones';

        $matmil[14] = 'billones de trillones';

        $matmil[15] = 'de billones de trillones';

        $matmil[16] = 'millones de billones de trillones';


        if ($num == '')
            $num = 0;

        $num = trim((string)@$num);

        if ($num[0] == '-') {

            $neg = 'menos ';

            $num = substr($num, 1);

        } else

            $neg = '';

        while ($num[0] == '0') $num = substr($num, 1);

        if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;

        $zeros = true;

        $punt = false;

        $ent = '';

        $fra = '';

        for ($c = 0; $c < strlen($num); $c++) {

            $n = $num[$c];

            if (!(strpos(".,'''", $n) === false)) {

                if ($punt) break;

                else {

                    $punt = true;

                    continue;

                }


            } elseif (!(strpos('0123456789', $n) === false)) {

                if ($punt) {

                    if ($n != '0') $zeros = false;

                    $fra .= $n;

                } else



                    $ent .= $n;

            } else



                break;


        }

        $ent = '     ' . $ent;

        if ($dec and $fra and !$zeros) {

            $fin = ' coma';

            for ($n = 0; $n < strlen($fra); $n++) {

                if (($s = $fra[$n]) == '0')

                    $fin .= ' cero';

                elseif ($s == '1')

                    $fin .= $fem ? ' uno' : ' un';

                else

                    $fin .= ' ' . $matuni[$s];

            }

        } else

            $fin = '';

        if ((int)$ent === 0) return 'Cero ' . $fin;

        $tex = '';

        $sub = 0;

        $mils = 0;

        $neutro = false;

        while (($num = substr($ent, -3)) != '   ') {

            $ent = substr($ent, 0, -3);

            if (++$sub < 3 and $fem) {

//          $matuni[1] = 'uno';
                $matuni[1] = 'un';

                $subcent = 'os';

            } else {

                $matuni[1] = $neutro ? 'un' : 'uno';

                $subcent = 'os';

            }

            $t = '';

            $n2 = substr($num, 1);

            if ($n2 == '00') {

            } elseif ($n2 < 21)

                $t = ' ' . $matuni[(int)$n2];

            elseif ($n2 < 30) {

                $n3 = $num[2];

                if ($n3 != 0) $t = 'i' . $matuni[$n3];

                $n2 = $num[1];

                $t = ' ' . $matdec[$n2] . $t;

            } else {

                $n3 = $num[2];

                if ($n3 != 0) $t = ' y ' . $matuni[$n3];

                $n2 = $num[1];

                $t = ' ' . $matdec[$n2] . $t;

            }

            $n = $num[0];

            if ($n == 1) {

                $t = ' ciento' . $t;

            } elseif ($n == 5) {

                $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;

            } elseif ($n != 0) {

                $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;

            }

            if ($sub == 1) {

            } elseif (!isset($matsub[$sub])) {

                if ($num == 1) {

                    $t = ' mil';

                } elseif ($num > 1) {

                    $t .= ' mil';

                }

            } elseif ($num == 1) {

                $t .= ' ' . $matsub[$sub] . 'on';

            } elseif ($num > 1) {

                $t .= ' ' . $matsub[$sub] . 'ones';

            }

            if ($num == '000') $mils++;

            elseif ($mils != 0) {

                if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];

                $mils = 0;

            }

            $neutro = true;

            $tex = $t . $tex;

        }

        $tex = $neg . substr($tex, 1) . $fin;

        return ucfirst($tex);

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

}

