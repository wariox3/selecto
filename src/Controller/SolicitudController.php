<?php

namespace App\Controller;

use App\Entity\Solicitud;
use App\Forms\Type\FormTypeSolicitud;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SolicitudController extends Controller
{


    var $strDqlLista = "";

    /**
     * @Route("/solicitud/lista", name="solicitud_lista")
     */
    public function listaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $formFiltro = $this->formularioFiltro();
        $formFiltro->handleRequest($request);
        $this->listar();
        if ($formFiltro->isSubmitted() && $formFiltro->isValid()) {
            if ($formFiltro->get('BtnFiltrar')->isClicked()) {
                $this->filtrar($formFiltro);
                $this->listar();
            }
        }
        $form = $this::createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->request->has('arSolicitudAtender')) {
                $codigoSolicitud = $request->request->get('arSolicitudAtender');
                $arSolicitud = $em->getRepository('App:Solicitud')->find($codigoSolicitud);
                if (!$arSolicitud->getEstadoAtendido()) {
                    $arSolicitud->setEstadoAtendido(true);
                    $arSolicitud->setFechaAtencion(new \DateTime('now'));
                }
                $em->persist($arSolicitud);

            }
            if ($request->request->has('arSolicitudCerrar')) {
                $codigoSolicitud = $request->request->get('arSolicitudCerrar');
                $arSolicitud = $em->getRepository('App:Solicitud')->find($codigoSolicitud);
                if (!$arSolicitud->getEstadoCerrado()) {
                    $arSolicitud->setEstadoCerrado(true);
                }
                $em->persist($arSolicitud);

            }
            $em->flush();
            return $this->redirect($this->generateUrl('solicitud_lista'));

        }

        $sinAtender = 0;
        $sinCerrar = 0;

        /** @var  $arSolicitud Solicitud */
        $arSolicitudes = $em->createQuery($this->strDqlLista)->getResult();
        foreach ($arSolicitudes as $key => $arSolicitud) {
            if (!$arSolicitud->getEstadoAtendido()) {
                $sinAtender++;
            }
            if (!$arSolicitud->getEstadoCerrado()) {
                $sinCerrar++;
            }
        }

        $arrSolicitudes = $paginator->paginate($em->createQuery($this->strDqlLista), $request->query->get('page', 1), 20);
        return $this->render('Solicitud/listar.html.twig', [
            'arSolicitudes' => $arrSolicitudes,
            'sinAtender' => $sinAtender,
            'sinCerrar' => $sinCerrar,
            'formFiltro' => $formFiltro->createView(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/solicitud/comentarios/{codigoSolicitud}",requirements={"codigoSolicitudPk":"\d+"}, name="verComentariosSolicitud")
     */
    public function verComentariosSolicitud($codigoSolicitud)
    {
        $em = $this->getDoctrine()->getManager();
        $comentarios = $em->getRepository('App:Comentario')->findBy(array('codigoSolicitudFk' => $codigoSolicitud));
        return $this->render('Tarea/verComentarios.html.twig', array(
            'comentarios' => $comentarios
        ));
    }

    /**
     * @Route("/solicitud/modificar/{codigoSolicitud}",requirements={"codigoSolicitudPk":"\d+"}, name="modificarSolicitud")
     * @param Request $request
     * @param $codigoSolicitud
     */
    public function modificarSolicitudAction(Request $request, $codigoSolicitud)
    {
        $em = $this->getDoctrine()->getManager();
        $arSolicitud = $em->getRepository("App:Solicitud")->find($codigoSolicitud);
        if ($arSolicitud->getFechaEntrega() == null) {
            $arSolicitud->setFechaEntrega(new \DateTime('now'));
        }
        $form = $this->createForm(FormTypeSolicitud::class, $arSolicitud);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($arSolicitud);
            $em->flush();
            echo "<script>window.opener.location.reload();window.close()</script>";
        }
        return $this->render('Solicitud/modificar.html.twig', array(
            'arSolicitud' => $arSolicitud,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/solicitud/cerrar/{codigoSolicitud}",requirements={"codigoSolicitud":"\d+"}, name="cerrarSolicitud")
     */
    public function cerrarSolicitudAction(Request $request, $codigoSolicitud = null, \Swift_Mailer $mailer)
    {

        $em = $this->getDoctrine()->getManager(); // instancia el entity manager

        $arSolicitud = $em->getRepository('App:Solicitud')->find($codigoSolicitud);
        $user = $this->getUser()->getCodigoUsuarioPk();

        $form = $this->createFormBuilder()
            ->add('solucion', TextareaType::class, array(
                'attr' => array(
                    'id' => '_solucion',
                    'name' => '_solucion',
                    'class' => 'form-control',

                ),
                'required' => false
            ))
            ->add('btnEnviar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnEnviar',
                    'name' => '_btnEnviar'
                ), 'label' => 'Enviar'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnEnviar')->isClicked()) {
                if (filter_var($arSolicitud->getCorreo(), FILTER_VALIDATE_EMAIL)) {
                    $message = (new \Swift_Message('Solución de solicitud - AppSoga' . ' - ' . $arSolicitud->getCodigoSolicitudPk()))
                        ->setFrom('sogainformacion@gmail.com')
                        ->setTo($arSolicitud->getCorreo())
                        ->setBody(
                            $this->renderView(
                            // templates/emails/registration.html.twig
                                'Correo/Solicitud/solicitudInformacion.html.twig',
                                array('arSolicitud' => $arSolicitud,
                                    'mensaje' => $form->get('solucion')->getData())
                            ),
                            'text/html'
                        );
                    $mailer->send($message);
                }
                $arSolicitud->setSolucion($form->get('solucion')->getData());
                $arSolicitud->setEstadoCerrado(true);
                $em->persist($arSolicitud);
                $em->flush();
            }
            echo "<script>window.opener.location.reload();window.close()</script>";
        }
        return $this->render('Solicitud/solucion.html.twig', [
            'form' => $form->createView(),
            'arSolicitud' => $arSolicitud
        ]);
    }

    private function formularioFiltro()
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $formFiltro = $this::createFormBuilder()
            ->add('estado', ChoiceType::class, array('choices' => array('Todos' => '2', 'Sin atender' => '0', 'Atendido' => '1'),
                'label' => 'Atendido', 'data' => '2'))
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
            ->getForm();

        return $formFiltro;

    }

    private function filtrar($formFiltro)
    {
        $session = new Session();
        $session->set('filtroEstado', $formFiltro->get('estado')->getData());

    }

    private function listar()
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $estado = $session->get('filtroEstado') == null ? 2 : $session->get('filtroEstado');
        $this->strDqlLista = $em->getRepository("App:Solicitud")->listaDql($estado);
    }

}
