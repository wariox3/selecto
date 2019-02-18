<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class SolicitudTipoApiController extends FOSRestController
{

    /**
     * @Rest\Get("/api/solicitud/tipo/lista")
     */
    public function lista(Request $request)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $restresult = $this->getDoctrine()->getRepository('App:SolicitudTipo')->listar();

        if ($restresult === null) {
            return new View("No hay tipos de solicitudes", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }


}
