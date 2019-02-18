<?php

namespace App\Controller;

use App\Entity\Solicitud;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tarea;

class ApiSolicitudController extends FOSRestController
{
    /**
     * @Rest\Get("/api/solicitud/lista/{intCodigoCliente}", requirements={"intCodigoCliente" = "\d+"}, defaults={"intCodigoCliente" = 0} )
     */
    public function listaEmpresa(Request $request, $intCodigoCliente)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($intCodigoCliente != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Solicitud')->listarPorEmpresa($intCodigoCliente);
        }

        if ($jsonRestResult === null) {
            return new View("No hay solicitudes", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Post("/api/solicitud/nuevo/{intCodigoSolicitudPk}", requirements={"intCodigoSolicitudPk" = "\d+" } ,defaults={"intCodigoSolicitudPk" = 0})
     */
    public function nuevo(Request $request, $intCodigoSolicitudPk = 0)
    {

        /**
         * @var $arSolicitud Solicitud
         */
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $data = json_decode($request->getContent(), true);
        if ($intCodigoSolicitudPk == 0 && $data != null) {
            //captura datos del post
            $descripcion = $data['descripcion'];
            $nombre = $data['nombre'];
            $contacto = $data['contacto'];
            $telefono = $data['telefono'];
            $extension = $data['extension'];
            $correo = $data['correo'];
            $horas = $data['horas'];
            $intCodigoClienteFk = $data['codigo_cliente_fk'];
            $codigoSolicitudTipo = $data['codigo_solicitud_tipo_fk'];

            //consulta las entidades a relacionar
            $arCliente = $this->getDoctrine()->getRepository('App:Cliente')->find($intCodigoClienteFk);
            $arSolicitudTipo = $this->getDoctrine()->getRepository('App:SolicitudTipo')->find($codigoSolicitudTipo);

            //crea objeto tipo caso y setea las propiedades del post
            $arSolicitud = new Solicitud();
            $arSolicitud->setClienteRel($arCliente);
            $arSolicitud->setFechaSolicitud(new \DateTime('now'));
            $arSolicitud->setSolicitudTipoRel($arSolicitudTipo);
            $arSolicitud->setDescripcion($descripcion);
            $arSolicitud->setNombre($nombre);
            $arSolicitud->setCorreo($correo);
            $arSolicitud->setContacto($contacto);
            $arSolicitud->setTelefono($telefono);
            $arSolicitud->setExtension($extension);
            if ($horas != "") {
                $arSolicitud->setHoras(new \DateTime($horas));
            } else {
                $arSolicitud->setHoras(new \DateTime('00:00:00'));
            }

        }
        if ($data != null && $intCodigoSolicitudPk != 0) {
            $descripcion = $data['descripcion'];
            $nombre = $data['nombre'];
            $contacto = $data['contacto'];
            $telefono = $data['telefono'];
            $extension = $data['extension'];
            $correo = $data['correo'];
            $codigoSolicitudTipo = $data['codigo_solicitud_tipo_fk'];
            $horas = $data['horas'];

            $arSolicitud = $em->getRepository('App:Solicitud')->find($intCodigoSolicitudPk);

            if ($arSolicitud != null && $arSolicitud->getEstadoAtendido() == false) {
                if ($codigoSolicitudTipo != null) {
                    $arSolicitudTipo = $em->getRepository('App:SolicitudTipo')->find($codigoSolicitudTipo);
                    if ($arSolicitudTipo != null) {
                        $arSolicitud->setSolicitudTipoRel($arSolicitudTipo);
                    }
                }
                if ($descripcion != null) {
                    $arSolicitud->setDescripcion($descripcion);
                }
                if ($nombre != null) {
                    $arSolicitud->setNombre($nombre);
                }
                if ($correo != null) {
                    $arSolicitud->setCorreo($correo);
                }
                if ($contacto != null) {
                    $arSolicitud->setContacto($contacto);
                }
                if ($telefono != null) {
                    $arSolicitud->setTelefono($telefono);
                }
                if ($extension != null) {
                    $arSolicitud->setExtension($extension);
                }
                if ($horas != "") {
                    $arSolicitud->setHoras(new \DateTime($horas));
                }
            }

        }

        $em->persist($arSolicitud);
        $em->flush();

        return true;


    }

    /**
     * @Rest\Get("/api/solicitud/{intCodigoCliente}/{intCodigoSolicitud}", requirements={"intCodigoCliente" = "\d+", "intCodigoSolicitud" = "\d+"}, defaults={"intCodigoCliente" = 0, "intCodigoSolicitud" = 0} )
     */

    public function listaUno(Request $request, $intCodigoCliente, $intCodigoSolicitud)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($intCodigoSolicitud != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Solicitud')->listarPorSolicitud($intCodigoCliente, $intCodigoSolicitud);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/solicitud/aprobar/{intCodigoSolicitud}", requirements={"intCodigoSolicitud" = "\d+"}, defaults={"intCodigoSolicitud" = 0} )
     */

    public function aprobarSolicitud(Request $request, $intCodigoSolicitud)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        $em = $this->getDoctrine()->getManager();
        if ($intCodigoSolicitud != 0) {
            $arSolicitud = $em->getRepository("App:Solicitud")->find($intCodigoSolicitud);
            $arSolicitud->setEstadoAprobado(true);
            $em->persist($arSolicitud);
            $em->flush();
        }

        return true;
    }

}
