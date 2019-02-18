<?php

namespace App\Controller;

use App\Entity\Archivo;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiArchivoController extends FOSRestController
{
    /**
     * @Rest\Post("/api/archivo/nuevo/")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrArchivo = json_decode($request->getContent(), true);
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $arArchivo = new Archivo();
        $arArchivo->setFecha(new \DateTime('now'));
        $arArchivo->setNombre($arrArchivo['nombre']);
        $arArchivo->setNombreAlmacenamiento($arrArchivo['nombreAlmacenamiento']);
        $arArchivo->setExtension($arrArchivo['extension']);
        $arArchivo->setTamano($arrArchivo['tamano']);
        $arArchivo->setTipo($arrArchivo['tipo']);
        $arArchivo->setDirectorio($arrArchivo['directorio']);
        $arArchivo->setNumero($arrArchivo['numero']);
        $arArchivo->setCodigoDocumentoFk($arrArchivo['codigoDocumento']);
        $em->persist($arArchivo);
        $em->flush();
        return true;
    }

    /**
     * @Rest\Get("/api/archivo/lista/{codigoDocumento}/{numero}", requirements={"codigoDocumento" = "\d+", "numero" = "\d+"}, defaults={"codigoDocumento" = 0, "numero" = 0})
     */
    public function lista(Request $request, $codigoDocumento = 0, $numero = 0)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($codigoDocumento != 0 && $numero != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Archivo')->apiLista($codigoDocumento, $numero);
        }

        if ($jsonRestResult === null) {
            return new View("No hay archivos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/archivo/descargar/{codigoArchivo}")
     */
    public function descargar(Request $request, $codigoArchivo)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($codigoArchivo != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Archivo')->apiArchivoDescargar($codigoArchivo);
        }

        if ($jsonRestResult === null) {
            return new View("No se encontro el archivo", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

}
