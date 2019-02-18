<?php

namespace App\Controller;

use App\Entity\Archivo;
use App\Entity\Implementacion;
use App\Entity\ImplementacionDetalle;
use App\Forms\Type\FormTypeImplementacion;
use App\Forms\Type\FormTypeImplementacionDetalle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ImplementacionController extends Controller
{

    var $strLista = "";

    /**
     * @Route("/implementacion/lista", name="implementacion_lista")
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->formularioLista();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        $this->listar();
        $arImplementaciones = $paginator->paginate($em->createQuery($this->strLista), $request->query->get('page', 1),20);

        return $this->render('Implementacion/lista.html.twig', [
            'arImplementaciones' => $arImplementaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param int $codigoImplementacion
     * @Route("/implementacion/nuevo/{codigoImplementacion}", name="implementacion_nuevo")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function nuevoAction(Request $request, $codigoImplementacion = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = new Implementacion();
        if ($codigoImplementacion != 0) {
            $arImplementacion = $em->getRepository("App:Implementacion")->find($codigoImplementacion);
        }
        $form = $this->createForm(FormTypeImplementacion::class, $arImplementacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arImplementacion);
            $em->flush();
            return $this->redirectToRoute("implementacion_lista");
        }
        return $this->render("Implementacion/nuevo.html.twig", [
            'form' => $form->createView(),
            'arImplementacion' => $arImplementacion
        ]);

    }

    /**
     * @param Request $request
     * @param $codigoImplementacion
     * @Route("/implementacion/detalle/{codigoImplementacion}", name="implementacion_detalle")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detalleAction(Request $request, $codigoImplementacion)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository("App:Implementacion")->find($codigoImplementacion);
        $arImplementacionDetalles = $em->getRepository("App:ImplementacionDetalle")->listaDetalle($codigoImplementacion);
        $form = $this::createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->has('arImplementacionDetalleCapacitar')) {
                $codigoImplementacionDetalle = $request->request->get('arImplementacionDetalleCapacitar');
                $arImplementacionDetalle = $em->getRepository('App:ImplementacionDetalle')->find($codigoImplementacionDetalle);
                if (!$arImplementacionDetalle->getEstadoCapacitado()) {
                    $arImplementacionDetalle->setEstadoCapacitado(true);
                    $arImplementacionDetalle->setFechaCapacitacion(new \DateTime('now'));
                }
                $em->persist($arImplementacionDetalle);
            }
            if ($request->request->has('arImplementacionDetalleTerminar')) {
                $codigoImplementacionDetalle = $request->request->get('arImplementacionDetalleTerminar');
                $arImplementacionDetalle = $em->getRepository('App:ImplementacionDetalle')->find($codigoImplementacionDetalle);
                if (!$arImplementacionDetalle->getEstadoTerminado()) {
                    $arImplementacionDetalle->setEstadoTerminado(true);
                }
                $em->persist($arImplementacionDetalle);
            }
            if ($request->request->has('BtnImprimir')) {
                $codigoImplementacionDetalle = $request->request->get('BtnImprimir');
                $arImplementacionDetalle = $em->getRepository('App:ImplementacionDetalle')->find($codigoImplementacionDetalle);
                $objActaCapacitacion = new \App\Formatos\FormatoActaCapacitacion();
                $objActaCapacitacion->Generar($em, $arImplementacionDetalle);
            }
            $em->flush();
            return $this->redirectToRoute("implementacion_detalle", ['codigoImplementacion' => $codigoImplementacion]);
        }
        return $this->render("Implementacion/detalle.html.twig", [
            'arImplementacion' => $arImplementacion,
            'arImplementacionDetalles' => $arImplementacionDetalles,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $codigoImplementacion
     * @param $codigoImplementacionDetalle
     * @Route("/implementacion/detalle/nuevo/{codigoImplementacion}/{codigoImplementacionDetalle}", name="implementacion_detalle_nuevo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detalleNuevoAction(Request $request, $codigoImplementacion, $codigoImplementacionDetalle = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $arImplementacion = $em->getRepository("App:Implementacion")->find($codigoImplementacion);
        $arImplementacionDetalle = new ImplementacionDetalle();
        $arImplementacionDetalle->setFechaCapacitacion(new \DateTime('now'));
        if ($codigoImplementacionDetalle != 0) {
            $arImplementacionDetalle = $em->getRepository("App:ImplementacionDetalle")->find($codigoImplementacionDetalle);
        }
        $form = $this->createForm(FormTypeImplementacionDetalle::class, $arImplementacionDetalle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arImplementacionDetalle = $form->getData();
            $arImplementacionDetalle->setImplementacionRel($arImplementacion);
            $arImplementacionDetalle->setImplementacionGrupoRel($arImplementacionDetalle->getImplementacionTemaRel()->getImplementacionGrupoRel());
            $em->persist($arImplementacionDetalle);
            $em->flush();
            echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
        }
        return $this->render("Implementacion/detalleNuevo.html.twig", [
            'arImplementacion' => $arImplementacion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @Route("/implementacion/detalle/adjunto/{codigoImplementacionDetalle}", name="implementacion_detalle_adjunto")
     * @param $codigoImplementacionDetalle
     */
    public function detalleAdjuntosAction(Request $request, $codigoImplementacionDetalle)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('archivo', FileType::class)
            ->add('btnGuardar', SubmitType::class, array('label' => 'Cargar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $objArchivo = $form['archivo']->getData();
                if ($objArchivo->getClientSize()) {
                    $strDestino = "/var/www/archivosoro/3/";
                    $strArchivo = md5(uniqid()) . '.' . $objArchivo->guessExtension();

                    $arArchivo = new Archivo();
                    $arArchivo->setFecha(new \DateTime('now'));
                    $arArchivo->setNombre($objArchivo->getClientOriginalName());
                    $arArchivo->setNombreAlmacenamiento($strArchivo);
                    $arArchivo->setExtension($objArchivo->getClientOriginalExtension());
                    $arArchivo->setTamano($objArchivo->getClientSize());
                    $arArchivo->setTipo($objArchivo->getClientMimeType());
                    $arArchivo->setDirectorio(3);
                    $arArchivo->setNumero($codigoImplementacionDetalle);
                    $arArchivo->setCodigoDocumentoFk(3);
                    $em->persist($arArchivo);
                    $em->flush();

                    $form['archivo']->getData()->move($strDestino, $strArchivo);

                    return $this->redirect($this->generateUrl('implementacion_detalle_adjunto', array('codigoImplementacionDetalle' => $codigoImplementacionDetalle)));

                } else {
                    echo "El archivo tiene un tamaño mayor al permitido";
                }
            }
        }
        $arArchivos = $em->getRepository("App:Archivo")->findBy(["codigoDocumentoFk" => 3, 'numero' => $codigoImplementacionDetalle]);
        return $this->render("Implementacion/detalleAdjunto.html.twig", [
            'arArchivos' => $arArchivos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/archivo/descargar/{codigoArchivo}", name="archivo_descarga")
     */
    public function descargar($codigoArchivo)
    {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arArchivo = $em->getRepository("App:Archivo")->find($codigoArchivo);

        $strRuta = "/var/www/archivosoro/{$arArchivo->getCodigoDocumentoFk()}/" . $arArchivo->getNombreAlmacenamiento();
        // Generate response
        $response = new Response();
        // Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', $arArchivo->getTipo());
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $arArchivo->getNombre() . '";');
        $response->headers->set('Content-length', $arArchivo->getTamano());
        $response->sendHeaders();
        if (file_exists($strRuta)) {
            $response->setContent(readfile($strRuta));
        } else {
            echo "<script>alert('No existe el archivo en el servidor a pesar de estar asociado en base de datos, por favor comuniquese con soporte');window.close()</script>";
        }
        return $response;
    }

    public function listar()
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $this->strLista = $em->getRepository("App:Implementacion")->listaDql();
    }

    public function formularioLista()
    {
        return $this::createFormBuilder()->getForm();
    }

}
