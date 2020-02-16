<?php

namespace App\Controller\Estructura;


use App\Entity\General\GenNotificacion;
use App\Entity\General\GenNotificacionTipo;

include_once(realpath(__DIR__ . "/../../../public/plugins/phpqrcode/phpqrcode/qrlib.php"));

/**
 * Class Mensajes
 * @package App\Util
 */
final class FuncionesController
{

    private static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new FuncionesController();
        }
        return $instance;
    }

    /**
     * @param $dateFecha \DateTime
     * @param string $intDias
     * @param string $intMeses
     * @param string $intAnios
     * @return \DateTime|false
     */
    public function sumarDiasFecha($dateFecha, $intDias = '', $intMeses = '', $intAnios = '')
    {
        if ($dateFecha instanceof \DateTime) {
            $fecha = $dateFecha->format('Y-m-j');
        } else {
            $fecha = $dateFecha;
        }
        if ($intDias != '') {
            $nuevafecha = strtotime('+' . $intDias . ' day', strtotime($fecha));
        }
        if ($intMeses != '') {
            $nuevafecha = strtotime('+' . $intMeses . ' month', strtotime($fecha));
        }
        if ($intAnios != '') {
            $nuevafecha = strtotime('+' . $intAnios . ' year', strtotime($fecha));
        }
        $nuevafecha = date('Y-m-j', $nuevafecha);
        $dateNuevaFecha = date_create($nuevafecha);
        return $dateNuevaFecha;
    }

    /**
     * @param
     * @return string
     */
    public static function codigoQr($contenido)
    {
        $filename = '/var/www/html/temporal/qrTest.png';

        $tamano = 10; //Tamaño de Pixel
        $level = 'L'; //Precisión Baja
        $framSize = 3; //Tamaño en blanco

        \QRcode::png($contenido, $filename, $level, $tamano, $framSize);

        return $filename;
    }

}