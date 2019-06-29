<?php

namespace App\Formatos;

use App\Entity\Empresa;
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
    public function Generar($em, $codigoMovimiento, $codigoEmpresa)
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
        $pdf->SetFont('Arial', '', 40);
        $pdf->SetTextColor(255, 220, 220);
        if ($arMovimiento->getEstadoAnulado()) {
            $pdf->RotatedText(70, 160, 'ANULADO', 45);
        } elseif (!$arMovimiento->getEstadoAprobado()) {
            $pdf->RotatedText(70, 160, 'SIN APROBAR', 45);
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', '', 12);
        $this->Body($pdf);
        $pdf->Output("Factura{$codigoMovimiento}.pdf", 'D');
    }

    public function Header()
    {
        /** @var  $em ObjectManager */
        $em = self::$em;
        /** @var  $arMovimiento InvMovimiento */
        $arMovimiento = $em->getRepository('App:Inventario\InvMovimiento')->find(self::$codigoMovimiento);
        $arEmpresa = BaseDatos::getEm()->getRepository(Empresa::class)->find(self::$codigoEmpresa);

        $this->SetFont('Arial', '', 5);
        $date = new \DateTime('now');
        $this->Text(170, 10, $date->format('Y-m-d H:i:s') . ' [Selecto | Inventario]');

        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(140, 26);
        $this->Cell(35, 4, 'FACTURA DE VENTA', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(25, 4, $arMovimiento->getNumero(), 0, 0, 'R', 0);
        //
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(140, 30);
        $this->Cell(35, 4, 'FECHA EMISION:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, $arMovimiento->getFecha()->format('Y-m-d'), 0, 0, 'R', 0);
        //
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(140, 34);
        $this->Cell(35, 4, 'FECHA VENCIMIENTO:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, $arMovimiento->getFechaVence()->format('Y-m-d'), 0, 0, 'R', 0);
        //
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(140, 38);
        $this->Cell(35, 4, 'FORMA PAGO:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, $arMovimiento->getFormaPagoRel()->getNombre(), 0, 0, 'R', 0);
        //
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(140, 42);
        $this->Cell(35, 4, 'PLAZO PAGO:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(25, 4, $arMovimiento->getPlazoPago(), 0, 0, 'R', 0);

        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 10);
        //Logo
        try {
            $logo = $em->getRepository('App\Entity\Empresa')->find(self::$codigoEmpresa);
            if ($logo) {
                $this->Image("data:image/'{$logo->getExtension()}';base64," . base64_encode(stream_get_contents($logo->getLogo())), 20, 18, 40, 25, $logo->getExtension());
            }
        } catch (\Exception $exception) {
        }

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(95, 24);
        $this->Cell(10, 4, utf8_decode($arEmpresa->getNombreCorto()), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 8);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(95, 28);
        $this->Cell(10, 4, 'REGIMEN COMUN', 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 8);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(95, 32);
        $this->Cell(10, 4, 'NIT: ' . $arEmpresa->getNit() . '-' . $arEmpresa->getDigitoVerificacion(), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 8);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(95, 36);
        $this->Cell(10, 4, utf8_decode($arEmpresa->getDireccion()), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 8);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(95, 40);
        $this->Cell(10, 4, 'TEL: ' . $arEmpresa->getTelefono(), 0, 0, 'C', 0);
        $this->SetFont('Arial', '', 8);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 44);
        $this->Cell(15, 4, 'CLIENTE:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, utf8_decode($arMovimiento->getTerceroRel()->getNombreCorto()), 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 48);
        $this->Cell(15, 4, 'NIT:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, utf8_decode($arMovimiento->getTerceroRel()->getNumeroIdentificacion()), 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 52);
        $this->Cell(15, 4, 'DIRECCION:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, utf8_decode($arMovimiento->getTerceroRel()->getDireccion()), 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 56);
        $this->Cell(15, 4, 'CIUDAD:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, utf8_decode($arMovimiento->getTerceroRel()->getCiudadRel()->getNombre()), 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 60);
        $this->Cell(15, 4, 'TELEFONO:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, utf8_decode($arMovimiento->getTerceroRel()->getTelefono()), 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 64);
        $this->Cell(15, 4, 'SOPORTE:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, '', 0, 0, 'L', 0);

        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(18.5, 68);
        $this->Cell(15, 4, 'COMENTARIO:', 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->SetX(52);
        $this->Cell(15, 4, "", 0, 0, 'L', 0);

        $this->Ln();

        $this->EncabezadoDetalles();
    }

    public function EncabezadoDetalles()
    {
        $this->Ln(6);
        $this->SetX(19.5);
        $header = array('DESCRIPCION', 'CANT', 'VR UNIT', 'IVA', 'TOTAL');
        $this->SetFillColor(225, 225, 225);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 7);

        //creamos la cabecera de la tabla.
        $w = array(120, 10, 15, 10, 25);
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
        /**
         * @var $arMovimiento InvMovimiento
         * @var $arMovimientoDetalles InvMovimientoDetalle
         */
        $arMovimiento = self::$em->getRepository('App:Inventario\InvMovimiento')->find(self::$codigoMovimiento);
        $arMovimientoDetalles = self::$em->getRepository('App:Inventario\InvMovimientoDetalle')->findBy(['codigoMovimientoFk' => self::$codigoMovimiento]);
        $pdf->SetFont('Arial', '', 7);
        /** @var  $arMovimientoDetalle InvMovimientoDetalle */
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $pdf->SetX(19.5);
            $pdf->Cell(120, 4, substr(utf8_decode($arMovimientoDetalle->getItemRel()->getDescripcion()), 0, 60), 1, 0, 'L');
            $pdf->Cell(10, 4, $arMovimientoDetalle->getCantidad(), 1, 0, 'R');
            $pdf->Cell(15, 4, number_format($arMovimientoDetalle->getVrSubtotal(), 0, '.', ','), 1, 0, 'R');
            $pdf->Cell(10, 4, $arMovimientoDetalle->getPorcentajeIva() . '%', 1, 0, 'C');
            $pdf->Cell(25, 4, number_format($arMovimientoDetalle->getVrTotal()), 1, 0, 'R');
            $pdf->Ln();
            $pdf->SetAutoPageBreak(true, 15);
        }
        $pdf->Ln();
        $pdf->SetX(140);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(35, 4, utf8_decode('SUBTOTAL'), 1, 0, 'L');
        $pdf->Cell(25, 4, number_format($arMovimiento->getVrSubtotal()), 1, 0, 'R');
        $pdf->Ln();
        $pdf->SetX(140);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(35, 4, utf8_decode('IVA'), 1, 0, 'L');
        $pdf->Cell(25, 4, number_format($arMovimiento->getVrIva()), 1, 0, 'R');
        $pdf->Ln();
        $pdf->SetX(140);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(35, 4, utf8_decode('TOTAL FACTURADO'), 1, 0, 'L');
        $pdf->Cell(25, 4, number_format($arMovimiento->getVrTotalNeto()), 1, 0, 'R');
    }

    public function Footer()
    {
        /**
         * @var $arMovimiento InvMovimiento
         * @var $arMovimientoDetalles InvMovimientoDetalle
         */
        $arMovimiento = self::$em->getRepository('App:Inventario\InvMovimiento')->find(self::$codigoMovimiento);
        $arEmpresa = BaseDatos::getEm()->getRepository(Empresa::class)->find(self::$codigoEmpresa);
        $this->Ln();
        $this->SetFont('Arial', 'B', 7.5);
        //Bloque informacion de conformidad
        $this->Text(19.5, 180, utf8_decode('Esta factura de venta se asimila en todos sus efectos a una letra de cambio(Art. 774 codigo comercio). Se hace constar que la firma de una'));
        $this->Text(19.5, 184, utf8_decode('persona diferente al comprador, implica que dicha persona se entienda autorizada y facultada tacita y expresamente, para aceptar y recibirla'));
        $this->Text(19.5, 188, utf8_decode('Pasados 10 dias calendario, contados a partir de la fecha de recepcion de la factura, si no se ha recibido una reclamacion por escrito, esta se'));
        $this->Text(19.5, 192, utf8_decode('entendera irrevocablemente acaptada. El pago no oportuno causara intereses moratorios a la tasa maxima legal autorizada.'));
        //Bloque firmas
        $this->Text(24, 216, utf8_decode('ELABORADO POR:'));
        $this->Text(80, 216, utf8_decode('RECIBIDO POR:________________________'));
        $this->Text(140, 216, utf8_decode('ACEPTADO POR:_______________________'));
        $this->Text(24, 222, utf8_decode('__________________________________'));
        $this->Text(80, 222, utf8_decode('C.C / NIT:______________________________'));
        $this->Text(140, 222, utf8_decode('C.C / NIT:______________________________'));
        $this->Text(24, 228, utf8_decode('__________________________________'));
        $this->Text(80, 228, utf8_decode('FECHA:________________________________'));
        $this->Text(140, 228, utf8_decode('FECHA:________________________________'));
        //Bloque resolucion facturacion
        $this->Text(48, 236, utf8_decode($arEmpresa->getNumeroResolucionDianFactura()) . ' Intervalo ' . $arEmpresa->getNumeracionDesde() . ' al ' . $arEmpresa->getNumeracionHasta());
        $this->Text(32, 240, utf8_decode($arEmpresa->getInformacionCuentaPago()));
        //Informacion final
        $this->SetXY(160, 244);
        $this->Cell(10, 4, utf8_decode('Impreso por computador'), 0, 0, 'C');
        $this->SetXY(160, 248);
        $this->Cell(10, 4, utf8_decode('SEMANTICA DIGITAL SAS Nit: 901192048-4'), 0, 0, 'C');
        $this->SetXY(160, 252);
        $this->Cell(10, 4, utf8_decode('CALLE 34 NRO 66A-33 OF 201'), 0, 0, 'C');
        $this->SetXY(160, 256);
        $this->Cell(10, 4, utf8_decode('Régimen Común. No retenedores del impuesto a las ventas.'), 0, 0, 'C');
        $this->SetXY(160, 260);
        $this->Cell(10, 4, utf8_decode('ORIGINAL: EMISOR - COPIA: CLIENTE'), 0, 0, 'C');
        $this->SetFont('Arial', '', 6.5);
        $this->Text(188, 275, utf8_decode('Página ') . $this->PageNo() . ' de {nb}');
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

