<?php

namespace App\Controller\General\Api;


use App\Entity\Movimiento;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FacturaController extends Controller
{
    public $tipo = "api";

    /**
     * @return array
     * @Rest\Post("/general/api/factura/lista")
     */
    public function factura(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $codigoFactura = $raw['codigoFactura'];
            $arrFactura = $em->getRepository(Movimiento::class)->apiExternoFacturaLista($codigoFactura);
            if ($arrFactura) {
                return [
                    'error' => false,
                    'factura' => $arrFactura
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No se encontró la factura"
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }

    }

    /**
     * @return array
     * @Rest\Post("/general/api/factura/respuesta")
     */
    public function resultado(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Movimiento::class)->apiExternoFactura($raw);

        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }

    }

}
