<?php
namespace App\Controller;

use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiImplementacionController extends FOSRestController
{

/**
 *@Rest\Get("/api/implementacion/lista/{codigoCliente}", defaults={"codigoCliente" = 0})
 */
public function lista(Request $request,$codigoCliente)
{

  set_time_limit(0);
  ini_set("memory_limit", -1);

  if ($codigoCliente != 0) {
      $jsonRestResult = $this->getDoctrine()->getRepository(Implementacion::class)->apiLista($codigoCliente);
  }

  if ($jsonRestResult === null) {
      return new View("No hay Implementaciones", Response::HTTP_NOT_FOUND);
  }
  return $jsonRestResult;

}

    /**
     *@Rest\Get("/api/implementacion/cabezera/{codigoImplementacion}", defaults={"codigoImplementacion" = 0})
     */
    public function cabezera(Request $request,$codigoImplementacion)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($codigoImplementacion != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository(Implementacion::class)->apiCabezera($codigoImplementacion);
        }

        if ($jsonRestResult === null) {
            return new View("No hay Implementaciones", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

/**
 *@Rest\Get("/api/implementacion/detalle/{codigoImplementacion}", defaults={"codigoImplementacion" = 0})
 */
 public function detalle(Request $request,$codigoImplementacion)
 {
   set_time_limit(0);
   ini_set("memory_limit", -1);

   if ($codigoImplementacion != 0) {
     $jsonRestResult = $this->getDoctrine()->getRepository(ImplementacionDetalle::class)->apiDetalle($codigoImplementacion);
   }

   if ($jsonRestResult === null) {
       return new View("No hay Implementaciones", Response::HTTP_NOT_FOUND);
   }
   return $jsonRestResult;
 }


}


 ?>
