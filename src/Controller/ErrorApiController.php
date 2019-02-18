<?php
/**
 * Created by PhpStorm.
 * User: jako
 * Date: 5/03/18
 * Time: 09:04 AM
 */

namespace App\Controller;


use App\Entity\Error;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ErrorApiController extends Controller
{

    /**
     * @Rest\Post("/api/error/nuevo")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);

        $cliente = $em->getRepository("App:Cliente")->find($data['codigo_cliente']);
        $error = new Error();
        if($cliente) {
            $error->setClienteRel($cliente);
        }
        $error->setCliente($data['nombre_cliente'])
            ->setMensaje($data['mensaje'])
            ->setCodigo($data['codigo'])
            ->setLinea($data['linea'])
            ->setRuta($data['ruta'])
            ->setArchivo($data['archivo'])
            ->setTraza($data['traza'])
            ->setFecha(new \DateTime($data['fecha']))
            ->setUrl($data['url'])
            ->setUsuario($data['usuario'])
            ->setNombreUsuario($data['nombre_usuario'])
            ->setEmail($data['email']);
        $em->persist($error);
        $em->flush();
        return $error->getCodigoErrorPk() != null;
    }

    /**
     * @Rest\Get("/api/error/lista/{pagina}/{cliente}/{fecha}/{atendido}/{solucionado}", requirements={"pagina"="\d+"}, defaults={"pagina"=1, "cliente"=null, "fecha"=null, "atendido"=0, "solucionado"=0})
     */
    public function lista(Request $request, $pagina, $cliente, $fecha, $atendido, $solucionado)
    {
        $limite = 100;
        $em = $this->getDoctrine()->getManager();
        $arrResultados = $em->getRepository("App:Error")->listaApi($pagina, $cliente, $fecha, $atendido, $solucionado, $limite);
        if(!$arrResultados) {
            return new View("No hay errores", Response::HTTP_NOT_FOUND);
        }
        return $arrResultados;
    }

    /**
     * @Rest\Get("/api/error/get/{codigo}", requirements={"codigo"="\d+"})
     * @param Request $request
     * @param $codigo
     */
    public function listaUno(Request $request, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $arError = $em->getRepository("App:Error")->listaUnoApi($codigo);
        if(!$arError) {
            return new View("No hay errores", Response::HTTP_NOT_FOUND);
        }
        return $arError;
    }
}
