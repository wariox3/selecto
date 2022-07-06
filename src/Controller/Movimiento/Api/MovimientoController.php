<?php

namespace App\Controller\Movimiento\Api;


use App\Entity\Movimiento;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MovimientoController extends AbstractController
{
    public $tipo = "api";

    /**
     * @return array
     * @Rest\Post("/api/movimiento/nuevo")
     */
    public function movimiento(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Movimiento::class)->apiExternoMovimientoNuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => "Ocurrió un error en la api " . $e->getMessage()];
        }
    }
}
