<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tarea;

class ApiTareaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/tarea/lista/caso/{codigoCaso}", requirements={"codigoCaso" = "\d+"}, defaults={"codigoCaso" = 0})
     */
    public function listaCaso(Request $request, $codigoCaso)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($codigoCaso != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Tarea')->apiListaCaso($codigoCaso);
        }

        if ($jsonRestResult === null) {
            return new View("No hay tareas", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }
}
