<?php

namespace App\Formatos;

use App\Entity\Compra\ComEgreso;
use App\Entity\Compra\ComEgresoDetalle;
use App\Entity\Empresa;
use App\Entity\General\GenTercero;
use App\Utilidades\Estandares;
use Doctrine\Common\Persistence\ObjectManager;

class Egreso extends \FPDF
{

    public static $em;
    public static $codigoEgreso;
    public static $codigoEmpresa;

    /**
     * @param $em ObjectManager
     * @param $codigoEgreso integer
     */
    public function
    Generar($em, $codigoEgreso, $codigoEmpresa)
    {
        self::$em = $em;
        self::$codigoEgreso = $codigoEgreso;
        self::$codigoEmpresa = $codigoEmpresa;
        /** @var  $arEgreso ComEgreso */
        $arEgreso = $em->getRepository(ComEgreso::class)->find($codigoEgreso);
        ob_clean();
        $pdf = new Egreso('P', 'mm', 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 40);
        $pdf->SetTextColor(255, 220, 220);
        if ($arEgreso->isEstadoAnulado()) {
            $pdf->RotatedText(90, 150, 'ANULADO', 45);
        } elseif (!$arEgreso->isEstadoAprobado()) {
            $pdf->RotatedText(90, 150, 'SIN APROBAR', 45);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Egreso{$arEgreso->getNumero()}_{$arEgreso->getTerceroRel()->getNombreCorto()}.pdf", 'D');
    }

    /**
     * @throws \Exception
     */
    public function Header()
    {
        /**
         * @var $arEgreso ComEgreso
         */
        $arEgreso = self::$em->getRepository(ComEgreso::class)->find(self::$codigoEgreso);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 10);
        //INFORMACIÓN EMPRESA
        Estandares::generarEncabezado($this, 'EGRESO', self::$em, null, self::$codigoEmpresa);

        //ENCABEZADO ORDEN DE COMPRA
        $intY = 40;
        $this->SetXY(10, $intY);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "NUMERO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arEgreso->getNumero(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "DOCUMENTO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, $arEgreso->getMovimientoTipoRel()->getNombre(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, "PAGO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, number_format($arEgreso->getVrPago()), 1, 0, 'R', 1);
        $this->SetXY(10, $intY + 4);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "TERCERO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(104, 4, $arEgreso->getTerceroRel()->getNombreCorto(), 1, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(25, 4, 'TOTAL:', 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(29, 4, number_format($arEgreso->getVrPagoTotal()), 1, 0, 'R', 1);
        $this->SetXY(10, $intY+8);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(32, 4, "CUENTA BANCO:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(40, 4, $arEgreso->getCuentaRel()->getNombre(), 1, 0, 'L', 1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(32, 4, "NIT:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(32, 4, $arEgreso->getTerceroRel()->getNumeroIdentificacion(), 1, 0, 'L', 1);
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
        $this->Cell(40, 4, $arEgreso->getFecha()->format('Y-m-d'), 1, 0, 'L', 1);
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
        $this->Cell(40, 4, $arEgreso->getFechaPago()->format('Y-m-d'), 1, 0, 'L', 1);
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
        $this->Cell(158, 4, $arEgreso->getComentario(), 1, 0, 'L', 1);

        $this->EncabezadoDetalles();

    }

    public function EncabezadoDetalles() {
        $this->Ln(12);
        $header = array('ID', 'TIPO','NUMERO', 'FECHA','VALOR');
        $this->SetFillColor(236, 236, 236);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 7);
        //creamos la cabecera de la tabla.
        $w = array(15, 30, 20, 20, 20);
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
        $arEgresoDetalle = self::$em->getRepository(ComEgresoDetalle::class)->listaFormato(self::$codigoEgreso);
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 7);
        if($arEgresoDetalle) {
            foreach ($arEgresoDetalle as $arEgresoDetalle) {
                $pdf->Cell(15, 4, $arEgresoDetalle['codigoEgresoDetallePk'], 1, 0, 'L');
                $pdf->Cell(30, 4, substr($arEgresoDetalle['cuentaPagarTipo'], 0 , 18), 1, 0, 'L');
                $pdf->Cell(20, 4, $arEgresoDetalle['numeroCompra'], 1, 0, 'L');
                $pdf->Cell(20, 4, $arEgresoDetalle['fecha']->format('Y-m-d'), 1, 0, 'L');
                $pdf->Cell(20, 4, number_format($arEgresoDetalle['vrPagoAfectar'], 0, '.', ','), 1, 0, 'R');
                $pdf->Ln();
                $pdf->SetAutoPageBreak(true, 85);
            }
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
        }
    }

    public static function devolverNumeroLetras($num, $fem = true, $dec = true)
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

    public function Footer()
    {
        $this->Text(188, 290, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
    }

}

