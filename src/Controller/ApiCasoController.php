<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Caso;

class ApiCasoController extends FOSRestController
{

    /**
     * @Rest\Get("/api/caso/lista/{intCodigoCliente}", requirements={"intCodigoCliente" = "\d+"}, defaults={"intCodigoCliente" = 0} )
     */

    /*
    * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
    * listar los casos de un cliente al logueo
    */
    public function listaEmpresa(Request $request, $intCodigoCliente)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($intCodigoCliente != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->listarPorEmpresa($intCodigoCliente);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/caso/lista/{intCodigoCliente}/{intCodigoCaso}", requirements={"intCodigoCliente" = "\d+", "intCodigoCaso" = "\d+"}, defaults={"intCodigoCliente" = 0, "intCodigoCaso" = 0} )
     */
    /*
     * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
     * $intCodigoCaso = 0 default Es el CodigoCasoPk seteado en base de datos(requerido)
     */

    public function listaUno(Request $request, $intCodigoCliente, $intCodigoCaso)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($intCodigoCaso != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->listarPorCaso($intCodigoCliente, $intCodigoCaso);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }


    /**
     * @Rest\Get("/api/caso/borra/{intCodigoCaso}", requirements={"intCodigoCaso" = "\d+"}, defaults={"intCodigoCaso" = 0} )
     */
    /*
     * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
     * $intCodigoCaso = 0 default Es el CodigoCasoPk seteado en base de datos(requerido)
     */

    public function borraUno(Request $request, $intCodigoCaso)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($intCodigoCaso != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->borraUnCaso($intCodigoCaso);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/caso/lista/atendido/{intCodigoCliente}/{boolEstado}", requirements={"intCodigoCliente" = "\d+", "boolEstado" = "\d+"}, defaults={"intCodigoCliente" = 0, "boolEstado" = -1} )
     */
    /*
     * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
     * $boolEstado = 0 == false
     * $boolEstado = 1 == true
     * Lista los casos de un cliente filtrados por el estado de Atendido
     */
    public function listaAtendidos(Request $request, $intCodigoCliente, $boolEstado)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($boolEstado <= 1 && $boolEstado > -1) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->listarPorEstadoAtendido($intCodigoCliente, $boolEstado);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/caso/reabrir/{intCodigoCasoPk}", requirements={"intCodigoCasoPk" = "\d+"}, defaults={"intCodigoCasoPk" = 0} )
     */
    /*
     * /api/caso/reabir/{intCodigoCasoPk}
     * $intCodigoCaso = 0 default Es el código del caso seteado en base de datos(requerido).
     * Reactiva el caso de un cliente despues de cerrado
     */
    public function reabrirCaso(Request $request, $intCodigoCasoPk)
    {

        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        if ($intCodigoCasoPk != null) {
            $arCaso = $em->getRepository('App:Caso')->find($intCodigoCasoPk);
            $arCaso->setEstadoSolucionado(false);
            $arCaso->setEstadoReabierto(true);
            $em->flush();
            $jsonRestResult = true;
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }

    /**
     * @Rest\Get("/api/caso/lista/solucionado/{intCodigoCliente}/{boolEstado}", requirements={"intCodigoCliente" = "\d+", "boolEstado" = "\d+"}, defaults={"intCodigoCliente" = 0, "boolEstado" = -1} )
     */
    /*
     * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
     * $boolEstado = 0 == false
     * $boolEstado = 1 == true
     * Lista los casos de un cliente filtrados por el estado de Solucionado
     */
    public function listaSolucionados(Request $request, $intCodigoCliente, $boolEstado)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);

        if ($boolEstado <= 1 && $boolEstado > -1) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->listarPorEstadoSolucionado($intCodigoCliente, $boolEstado);
        }

        if ($jsonRestResult === null) {
            return new View("No hay casos", Response::HTTP_NOT_FOUND);
        }
        return $jsonRestResult;
    }


    /**
     * @Rest\Post("/api/caso/adjuntar/{intCodigoCasoPk}", requirements={"intCodigoCasoPk"="\d+"}, defaults={"intCodigoCasoPk"=0})
     */
    /*
     * Recibe un adjunto para un caso recibiendo como parametro el codigo del caso
     *
     */
    public function adjuntarArchivoCaso(Request $request, $intCodigoCasoPk)
    {
        // codigo para guardar archivo
    }
    /**
     * @Rest\Post("/api/caso/nuevo/{intCodigoCasoPk}", requirements={"intCodigoCasoPk" = "\d+" } ,defaults={"intCodigoCasoPk" = 0})
     */
    /* crear nuevo caso de un cliente o editarlo
     * En caso de venir seteado el parametro de codigoCaso se editara el caso con los valores enviados
     *
     */
    public function nuevo(Request $request, $intCodigoCasoPk)
    {

        /**
         * @var $arCaso Caso
         */
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $data = json_decode($request->getContent(), true);
        if ($intCodigoCasoPk == 0 && $data != null) {
            //captura datos del post
            $asunto = $data['asunto'];
            $correo = $data['correo'];
            $contacto = $data['contacto'];
            $telefono = $data['telefono'];
            $extension = $data['extension'];
            $descripcion = $data['descripcion'];
            $codigoCategoriaCasoFk = $data['codigo_categoria_caso_fk'];
            $codigoPrioridadFk = $data['codigo_prioridad_fk'];
            $intCodigoClienteFk = $data['codigo_cliente_fk'];
            $codigoAreaFk = $data['codigo_area_fk'];
            $codigoCargoFk = $data['codigo_cargo_fk'];

            //consulta las entidades a relacionar
            $arCliente = $this->getDoctrine()->getRepository('App:Cliente')->find($intCodigoClienteFk);
            $arCategoria = $this->getDoctrine()->getRepository('App:CasoCategoria')->find($codigoCategoriaCasoFk);
            $arPrioridad = $this->getDoctrine()->getRepository('App:Prioridad')->find($codigoPrioridadFk);
            $arArea = $this->getDoctrine()->getRepository('App:Area')->find($codigoAreaFk);
            $arCargo = $this->getDoctrine()->getRepository('App:Cargo')->find($codigoCargoFk);

            //crea objeto tipo caso y setea las propiedades del post
            $arCaso = new Caso();
            $arCaso->setDescripcion($descripcion);
            $arCaso->setAsunto($asunto);
            $arCaso->setCorreo($correo);
            $arCaso->setContacto($contacto);
            $arCaso->setTelefono($telefono);
            $arCaso->setExtension($extension);
            $arCaso->setFechaRegistro(new \DateTime('now'));
            $arCaso->setCodigoCategoriaCasoFk($codigoCategoriaCasoFk);
            $arCaso->setCodigoPrioridadFk($codigoPrioridadFk);
            $arCaso->setEstadoAtendido(false);
            $arCaso->setEstadoSolucionado(false);
            $arCaso->setClienteRel($arCliente);
            $arCaso->setCategoriaRel($arCategoria);
            $arCaso->setPrioridadRel($arPrioridad);
            $arCaso->setAreaRel($arArea);
            $arCaso->setCargoRel($arCargo);
        }
        if ($data != null && $intCodigoCasoPk != 0) {
            $asunto = $data['asunto'];
            $correo = $data['correo'];
            $contacto = $data['contacto'];
            $telefono = $data['telefono'];
            $extension = $data['extension'];
            $descripcion = $data['descripcion'];
            $codigoCategoriaCasoFk = $data['codigo_categoria_caso_fk'];
            $codigoPrioridadFk = $data['codigo_prioridad_fk'];
            $codigoAreaFk = $data['codigo_area_fk'];
            $codigoCargoFk = $data['codigo_cargo_fk'];

            $arCaso = $em->getRepository('App:Caso')->find($intCodigoCasoPk);

            if ($arCaso != null && $arCaso->getEstadoAtendido() == false) {
                if ($asunto != null) {
                    $arCaso->setAsunto($asunto);
                }
                if ($correo != null) {
                    $arCaso->setCorreo($correo);
                }
                if ($contacto != null) {
                    $arCaso->setContacto($contacto);
                }
                if ($telefono != null) {
                    $arCaso->setTelefono($telefono);
                }
                if ($extension != null) {
                    $arCaso->setExtension($extension);
                }
                if ($descripcion != null) {
                    $arCaso->setDescripcion($descripcion);
                }
                if ($codigoCategoriaCasoFk != null) {
                    $arCategoriaCaso = $em->getRepository('App:CasoCategoria')->find($codigoCategoriaCasoFk);
                    if ($arCategoriaCaso != null) {
                        $arCaso->setCategoriaRel($arCategoriaCaso);
                    }
                }
                if ($codigoPrioridadFk != null) {
                    $arPrioridad = $em->getRepository('App:Prioridad')->find($codigoPrioridadFk);
                    if ($arPrioridad != null) {
                        $arCaso->setPrioridadRel($arPrioridad);
                    }
                }

                if ($codigoAreaFk != null) {
                    $arArea = $em->getRepository('App:Area')->find($codigoAreaFk);
                    if ($arArea != null) {
                        $arCaso->setAreaRel($arArea);
                    }
                }
                if ($codigoCargoFk != null) {
                    $arCargo = $em->getRepository('App:Cargo')->find($codigoCargoFk);
                    if ($arCargo != null) {
                        $arCaso->setCargoRel($arCargo);
                    }
                }
            }

        }

        $em->persist($arCaso);
        $respuesta = true;
        try {
            $em->flush();
        } catch (\Exception $exception) {
            $respuesta = $exception;
        }

        return $respuesta;


    }

    /**
     * @Rest\Post("/api/caso/solicitud/informacion/{intCodigoCasoPk}", requirements={"intCodigoCasoPk" = "\d+" } ,defaults={"intCodigoCasoPk" = 0})
     */
    /* recibe la respuesta de un cliente ferente a una solicitud de ampliacion de informacion
     * En caso de venir seteado el parametro de codigoCaso se editara el caso con los valores enviados
     *
     */

    public function solicitudInformacion(Request $request, $intCodigoCasoPk)
    {

        /**
         * @var $arCaso Caso
         */
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager

        $data = json_decode($request->getContent(), true);
        $arCaso = $em->getRepository()->find($intCodigoCasoPk);
        if ($arCaso != null) {
            $respuestaSolicitudInformacion = $data['respuestaSolicitud'];
            $arCaso->setEstadoRespuestaSolicitudInformacion(true);
            $arCaso->setRespuestaSolicitudInformacion($respuestaSolicitudInformacion);
            $arCaso->setFechaRespuestaSolicitudInformacion(new \DateTime('now'));
            $em->persist($arCaso);
            $em->flush();
        }


        //acá metodo de creacion de solicitud de informacion para el caso
    }

    /**
     * @Rest\Get("/api/caso/lista/propiedad/{intCodigoCliente}/{strPropiedad}/{value}/{strPropiedadOrdenar}/{strOrder}", requirements={"intCodigoCliente" = "\d+"} ,defaults={"intCodigoCliente" = 0} )
     */
    /*
     * $intCodigoCLiente = 0 default Es el códigoClientePk seteado en base de datos(requerido).
     * $strPropiedad = nombre de la propiedad a filtrar debe estar escrita tal cual estan creadas las propiedades de la entidad (requerido)
     * * $strPropiedad = nombre de la propiedad a ordenar debe estar escrita tal cual estan creadas las propiedades de la entidad
     * $value = no se pone tipo debidoa que las propiedades tienen varios valores, esta deberá estar seteada con el valor y tipo guardado en la base de datos y definido para la propiedad en la entidad(requerido)
     * $strOrder = ASC || DESC // en caso de que se desee filtrar la propiedad en un orden especifico, predeterminado ASC
     * Lista los casos de un cliente filtrados por la propiedad enviada
     */

    public function filtroPorPropiedad($strPropiedad = '', $value = null, $strOrder = 'ASC', $intCodigoCliente, $strPropiedadOrdenar = '', $jsonRestResult = null)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        if ($strPropiedad != '' && $value !== null && $intCodigoCliente != 0) {
            $jsonRestResult = $this->getDoctrine()->getRepository('App:Caso')->listarPorPropiedad($strPropiedad, $value, $strOrder, $intCodigoCliente, $strPropiedadOrdenar);
        }

        if ($jsonRestResult === null) {
            return new View("No estan bien seteados los parametros recuerde: /api/caso/lista/propiedad/{intCodigoCliente}/{strPropiedad}/{value}/{strPropiedadOrdenar}/{strOrder} Para mas informacón lea la docmentacion del controlador en https://github.com/ju4nr3v0l/oro4/blob/master/src/Controller/CasoApiController.php ", Response::HTTP_NOT_FOUND);
        } else {
            return $jsonRestResult;
        }

    }

    /**
     * @Rest\Post("/api/caso/respuesta/informacion/{codigoCaso}",requirements={"codigoCaso" = "\d+"}, defaults={"codigoCaso" = 0} )
     */
    public function respuestaInformacion(Request $request, $codigoCaso)
    {
        $em = $this->getDoctrine()->getManager();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $arrCaso = json_decode($request->getContent(), true);
        if ($codigoCaso != 0) {
            $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
            $arCaso->setRespuestaSolicitudInformacion($arrCaso['respuestaInformacion']);
            $arCaso->setEstadoRespuestaSolicitudInformacion(1);
            $arCaso->setfechaRespuestaSolicitudInformacion(new \DateTime('now'));
            $em->persist($arCaso);
            $em->flush();
        }

        return true;
    }

}
