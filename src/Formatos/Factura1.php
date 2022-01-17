<?php

namespace App\Formatos;

use App\Entity\Empresa;
use App\Entity\Inventario\InvFacturaTipo;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Entity\General\GenTercero;
use App\Utilidades\BaseDatos;
use App\Utilidades\Estandares;
use Doctrine\Common\Persistence\ObjectManager;

class Factura1 extends \FPDF
{

    public static $em;
    public static $codigoMovimiento;
    public static $codigoEmpresa;

    /**
     * @param $em ObjectManager
     * @param $codigoMovimiento integer
     */
    public function
    Generar($em, $codigoMovimiento, $codigoEmpresa)
    {

        self::$em = $em;
        self::$codigoMovimiento = $codigoMovimiento;
        self::$codigoEmpresa = $codigoEmpresa;
        /** @var  $arMovimiento Movimiento */
        $arMovimiento = $em->getRepository(Movimiento::class)->find($codigoMovimiento);
        ob_clean();
        $pdf = new Factura1('P', 'mm', 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 40);
        $pdf->SetTextColor(255, 220, 220);
        if ($arMovimiento->isEstadoAnulado()) {
            $pdf->RotatedText(90, 150, 'ANULADO', 45);
        } elseif (!$arMovimiento->isEstadoAprobado()) {
            $pdf->RotatedText(90, 150, 'SIN APROBAR', 45);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Factura_{$arMovimiento->getNumero()}_{$arMovimiento->getTerceroRel()->getNombreCorto()}.pdf", 'D');
    }

    /**
     * @param $pdf
     * @param string $titulo
     */
    public function Header()
    {
        /**
         * @var $arMovimiento Movimiento
         */
        $arMovimiento = self::$em->getRepository(Movimiento::class)->find(self::$codigoMovimiento);
        $arEmpresa = BaseDatos::getEm()->getRepository(Empresa::class)->find(self::$codigoEmpresa);
        $this->setDrawColor('227', '227', '227');
        $this->SetFillColor(277, 277, 277);
        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(10, 10);
        try {
            $logo = self::$em->getRepository('App\Entity\Empresa')->find(self::$codigoEmpresa);
            if ($logo) {
                $this->Image("data:image/'{$logo->getExtension()}';base64," . base64_encode(stream_get_contents($logo->getLogo())), 20, 10, 40, 25, $logo->getExtension());
            }
        } catch (\Exception $exception) {
        }
        $this->SetXY(100, 10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 4, utf8_decode($arEmpresa ? $arEmpresa->getNombreCorto() : ''), 0, 0, 'C', 0);
        $this->SetXY(100, 14);
        $this->SetFont('Arial', '', 8);
        $this->Cell(10, 4, $arEmpresa ? "NIT: ".  $arEmpresa->getNit() . '- ' . $arEmpresa->getDigitoVerificacion() : '', 0, 0, 'C', 0);
        $this->SetXY(100, 18);
        $this->Cell(10, 4, substr(utf8_decode($arEmpresa ? $arEmpresa->getDireccion() : ''), 0, 45), 0, 0, 'C', 0);
        $this->SetXY(100, 22);
        $this->Cell(10, 4, $arEmpresa ? "TELS: " . $arEmpresa->getTelefono() : '', 0, 0, 'C', 0);



        $this->SetXY(150, 18);
        $this->SetFont('Arial', '', 8);
        $this->Cell(56,6,"CUENTA DE COBRO",'LTR',0,'C');
        $this->SetXY(150, 24);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(56,6,"No. ".$arMovimiento->getNumero(),'LBR',0,'C');

        //ENCABEZADO ORDEN DE COMPRA
        $intY = 40;

        $this->SetXY(8, $intY + 5);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(18, 5, "Propietario:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(100, 5, $arMovimiento->getTerceroRel()->getNombreCorto(), 1, 0, 'L', 1);

        $this->SetXY(8, $intY + 10);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(18, 5, "Ref:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(45, 5, $arMovimiento->getTerceroRel()->getNumeroIdentificacion(), 1, 0, 'L', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(18, 5, "Telefonos:", 1, 0, 'L', 1);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(37, 5, $arMovimiento->getTerceroRel()->getTelefono(), 1, 0, 'L', 1);

        $this->SetXY(150, $intY + 3);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(28, 6, "Fecha de Factura", 1, 0, 'C', 1);

        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(28, 6, "Fecha de vencimiento", 1, 0, 'C', 1);

        $this->SetXY(150, $intY + 9);
        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(28, 8, $arMovimiento->getFecha()->format('Y-m-d'), 1, 0, 'C', 1);

        $this->SetFont('Arial', '', 7);
        $this->SetFillColor(272, 272, 272);
        $this->Cell(28, 8, $arMovimiento->getFechaVence()->format('Y-m-d'), 1, 0, 'C', 1);
        $this->EncabezadoDetalles();

    }

    public function EncabezadoDetalles()
    {

        $this->Ln(10);
        $this->SetX(8);
        $header = array('ID','Concepto','Cantidad','Valor', 'Descuento', 'Iva', 'Total');
        $this->SetFillColor(227, 227, 227);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 7);

        //creamos la cabecera de la tabla.
        $w = array(15,100, 13,20,15, 15, 20);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
        }
        //Restauración de colores y fuentes
        $this->SetFillColor(200, 200, 200);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Ln(6);

    }

    /**
     * @param $pdf
     */
    public function Body($pdf)
    {
        /**
         * @var $arMovimiento Movimiento
         * @var $arMovimientoDetalles MovimientoDetalle
         */
        $arMovimiento = self::$em->getRepository(Movimiento::class)->find(self::$codigoMovimiento);
        $arMovimientoDetalles = self::$em->getRepository(MovimientoDetalle::class)->findBy(['codigoMovimientoFk' => self::$codigoMovimiento]);
        $pdf->SetFont('Arial', '', 7);
        /** @var  $arMovimientoDetalle MovimientoDetalle */
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $pdf->SetX(8);
            $pdf->Cell(15, 6, $arMovimientoDetalle->getCodigoItemFk(), 0, 0, 'L');
            $pdf->Cell(100, 6, utf8_decode($arMovimientoDetalle->getItemRel()->getNombre()),  0, 'L');
            $pdf->Cell(13, 6, $arMovimientoDetalle->getCantidad(), 0, 0, 'C');
            $pdf->Cell(20, 6, number_format($arMovimientoDetalle->getVrPrecio(), 0, '.', ','), 0, 0, 'R');
            $pdf->Cell(15, 6, number_format($arMovimientoDetalle->getPorcentajeDescuento(), 0, '.', ','), 0, 0, 'R');
            $pdf->Cell(15, 6, number_format($arMovimientoDetalle->getVrIva(), 0, '.', ','), 0, 0, 'R');
            $pdf->Cell(20, 6, number_format($arMovimientoDetalle->getVrTotal(), 0, '.', ','), 0, 0, 'R');
            $this->setDrawColor('227', '227', '227');
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
        }



    }

    public function Footer()
    {
        /**
         * @var $arMovimiento Movimiento
         * @var $arMovimientoDetalles MovimientoDetalle
         * @var $arEmpresa Empresa
         */
        $arMovimiento = self::$em->getRepository(Movimiento::class)->find(self::$codigoMovimiento);
        $arMovimientoDetalles = self::$em->getRepository(MovimientoDetalle::class)->findBy(['codigoMovimientoFk' => self::$codigoMovimiento]);
        $arEmpresa = self::$em->getRepository(Empresa::class)->find(self::$codigoEmpresa);

        $this->setDrawColor('227', '227', '227');

        $nr = count($arMovimientoDetalles);
        $y = 71+($nr*6)+8;
        $x = 171;

        $this->Line(136, 60,136, $y-2); //Linea body tabla

        $this->Line(8, $y-2, 206, $y-2); //Linea Inferior tabla

        $this->SetXY(125, $y);
        $this->SetFont('Arial', '', 7);
        $this->Cell(46, 6, 'Total Cuotas y Cargos Del Mes', 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->SetX($x);
        $this->SetFont('Arial', '', 7);
        $this->Cell(35, 6, number_format($arMovimiento->getVrSubtotal(), 0, '.', ','), 1, 0, 'R');

        $y += 6;
        $this->SetXY(125, $y);
        $this->SetFont('Arial', '', 7);
        $this->Cell(46, 6, 'Valor de Iva', 1, 0, 'L');
        $this->SetX($x);
        $this->SetFont('Arial', '', 7);
        $this->Cell(35, 6, number_format($arMovimiento->getVrIva()), 1, 0, 'R');

        $y += 6;
        $this->SetFont('Arial', '', 7);
        $this->SetXY(125, $y);
        $this->Cell(46, 6, 'Anticipos', 1, 0, 'L');
        $this->SetX($x);
        $this->SetFont('Arial', '', 7);
        $this->Cell(35, 6, number_format(0), 1, 0, 'R');

        $y += 6;
        $this->SetFont('Arial', '', 7);
        $this->SetXY(125, $y);
        $this->Cell(46, 6, 'Saldo Anterior', 1, 0, 'L');
        $this->SetX($x);
        $this->SetFont('Arial', '', 7);
        $this->Cell(35, 6, number_format($arMovimiento->getVrTotalNeto()), 1, 0, 'R');

        $y += 6;
        $this->SetXY(125, $y);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227);
        $this->Cell(46, 6, 'Total Neto', 1, 0, 'L',1);
        $this->SetX($x);
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(227, 227, 227   );
        $this->Cell(35, 6, number_format($arMovimiento->getVrTotalNeto()), 1, 0, 'R',1);


        if ($arMovimiento->getVrTotalNeto() != 0) {
            $vrTotalLetras = self::devolverNumeroLetras($arMovimiento->getVrTotalNeto());
        } else {
            $vrTotalLetras = 'CERO PESOS';
        }

        $this->SetXY(7.5, $y-22);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(46, 6, 'Valor en letras', 0, 0, 'L');
        $this->SetXY(7.5, $y-17.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 3,  strtoupper($vrTotalLetras), 0, 0, 'L');

        $this->SetXY(7.5, $y-12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(46, 6, 'Condiciones de Pago', 0, 0, 'L');
        $this->SetXY(7.5,$y-7.5 );
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 3, strtoupper($vrTotalLetras), 0, 'R');
        $this->SetXY(7.5,$y-4 );
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 3, "-.00", 0, 'R');
        $this->SetXY(7.5,$y-1 );
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 3, "-.00", 0, 'R');

        $this->SetFont('Arial', 'B', 7);
        $this->Text(8.5, $y+12, utf8_decode("Observaciones: ") . utf8_decode($arMovimiento->getComentario()));
        $this->SetFont('Arial', '', 7);
        $this->SetXY(7.5,$y+16 );
        $this->MultiCell(198, 3, utf8_decode($arEmpresa->getInformacionPago()), 0, 'L', false);

        //Marco
        $y+=28;
        $this->Line(8, 5,206 , 5); //Linea Superior
        $this->Line(206, 5,206 , $y); //Linea Derecha
        $this->Line(8, 5,8, $y); //Linea Izquierda
        $this->Line(8, $y, 206,$y ); //Linea Inferior


        $this->Text(188, 257, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');

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

}

