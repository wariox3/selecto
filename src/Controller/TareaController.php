<?php

/**
 * Created by Juan David Marulanda V.
 * User: @ju4nr3v0l
 * appSoga developers Team.
 */

namespace App\Controller;


use App\Entity\Caso;
use App\Entity\Comentario;
use App\Entity\TareaDevolucion;
use App\Forms\Type\FormTypeTarea;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Tarea;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TareaController extends Controller
{
    var $strDqlLista = "";


    /**
     * @Route("/tarea/nuevo/{codigoTarea}", requirements={"codigoTarea":"\d+"}, name="registrarTarea")
     */
    public function nuevo(Request $request, $codigoTarea = null)
    {

        /**
         * @var Usuario $arUser
         **/
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $user = $this->getUser(); // trae el usuario actual
        $arTarea = new Tarea(); //instance class
        if ($codigoTarea) {
            $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
        } else {
            $arTarea->setEstadoTerminado(false);

        }

        $form = $this->createForm(FormTypeTarea::class, $arTarea); //create form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$codigoTarea) {
                $id = $user->getCodigoUsuarioPk();
                $arTarea->setFechaRegistro(new \DateTime('now'));
                $arTarea->setCodigoUsuarioRegistraFk($id);
            }
            $arUser = $arTarea->getCodigoUsuarioAsignaFk();
            if ($arUser != null) {
                $arTarea->setFechaGestion(new \DateTime('now'));
                $arTarea->setCodigoUsuarioAsignaFk($arUser->getCodigoUsuarioPk());
            }
            $em->persist($arTarea);
            $em->flush();
            if ($codigoTarea) {
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            } else {
                return $this->redirect($this->generateUrl('listaTareaGeneral'));
            }
        }

        return $this->render('Tarea/crear.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/tarea/ver/{codigoTarea}", requirements={"codigoTarea":"\d+"}, name="verTarea")
     */
    /*
     * Ver una tarea y sus comentarios
     */
    public function verTarea(Request $request, $codigoTarea = null)
    {

        /**
         * @var Usuario $arUser
         **/
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
        $arDevoluciones = $em->getRepository("App:TareaDevolucion")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoTareaDevolucionPk' => 'DESC'));
        $arTareaTiempos = $em->getRepository("App:TareaTiempo")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoTareaTiempoPk' => 'DESC'));
        $arComentarios = $em->getRepository("App:Comentario")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoComentarioPk' => 'DESC'));
        $form = $this->formularioVer($arTarea);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('BtnEjecucion')->isClicked()) {
                $arTarea->setEstadoEjecucion(1);
                $arTarea->setFechaEjecucion(new \DateTime('now'));
                $em->persist($arTarea);

            }
            if ($form->get('BtnResuelto')->isClicked()) {
                $arTarea->setEstadoTerminado(1);
                $arTarea->setFechaSolucion(new \DateTime('now'));
                $em->persist($arTarea);
                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaTerminada(1);
                    $em->persist($arCaso);
                }
            }
            if ($form->get('BtnVerificado')->isClicked()) {
                $arTarea->setEstadoVerificado(1);
                $arTarea->setFechaVerificado(new \DateTime('now'));
                $em->persist($arTarea);
                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaRevisada(1);
                    $em->persist($arCaso);
                }
                $em->flush();
                return $this->redirect($this->generateUrl('listaTareaGeneral'));


            }
            if($form->get("btnGuardar")->isClicked()){
                $arComentario = new Comentario();
                $arComentario->setTareaRel($arTarea);
                $arComentario->setFechaRegistro(new \DateTime('now'));
                $arComentario->setComentario($form->get("comentario")->getData());
                $arComentario->setCodigoUsuarioFk($this->getUser()->getCodigoUsuarioPk());
                $em->persist($arComentario);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('verTarea', array('codigoTarea' => $codigoTarea)));

        }
        return $this->render('Tarea/verTarea.html.twig',

            array(
                'tarea' => $arTarea,
                'arDevoluciones' => $arDevoluciones,
                'arTareaTiempos' => $arTareaTiempos,
                'arComentarios' => $arComentarios,
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/tarea/nuevo/caso/{codigoCaso}", requirements={"codigoCaso":"\d+"}, name="registrarTareaDesdeCaso")
     *
     */
    /*
     * Registra una tarea desde caso
     */
    public function nuevoTareaDesdeCaso(Request $request, $codigoCaso = null)
    {

        /**
         * @var Usuario $arUser
         **/

        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $user = $this->getUser(); // trae el usuario actual
        $arTarea = new Tarea(); //instance class
        if ($codigoCaso != null) {
            $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
        }
        $form = $this->createForm(FormTypeTarea::class, $arTarea); //create form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arTarea->setCasoRel($arCaso);
            $arTarea->setCodigoUsuarioRegistraFk($user->getCodigoUsuarioPk());
            $arTarea->setFechaRegistro(new \DateTime('now'));

//			$prioridadRel = $form->get('prioridadRel')->getData();
//			$tareaTipoRel = $form->get('tareaTipoRel')->getData();
//			$arPrioridadRel = $em->getRepository('App:Prioridad')->find($prioridadRel);
//			$arTareaTipoRel = $em->getRepository('App:TareaTipo')->find($tareaTipoRel);
            $usuarioAsignado = $form->get('codigoUsuarioAsignaFk')->getData();
            if ($usuarioAsignado != null) {
                $arTarea->setCodigoUsuarioAsignaFk($usuarioAsignado->getCodigoUsuarioPk());
//				$arTarea->setPrioridadRel($arPrioridadRel);
//				$arTarea->setTareaTipoRel($arTareaTipoRel);
            }
            $arTarea->setFechaGestion(new \DateTime('now'));

            if ($arCaso->getEstadoAtendido() == true) {
                $arCaso->setEstadoTarea(1);
                $em->persist($arCaso);

                $em->persist($arTarea);
                $em->flush();
                echo "<script>window.opener.location.reload();window.close()</script>";
            } else {
                echo "<script>alert('El caso debe estar atendido para asignar una tarea');window.close()</script>";
            }


        }

        return $this->render('Tarea/crearDesdeCaso.html.twig',
            array(
                'form' => $form->createView(),
                'caso' => $arCaso
            )
        );
    }


    /**
     * @Route("/tarea/lista", name="listaTareaGeneral")
     */
    public function listaGeneral(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
//        $arTarea = new \App\Entity\Tarea();
        //   $session = $this->get('session');
//        $session->set('filtroEstado', 2);
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
            if ($request->request->has('TareaSolucionar')) {
                $codigoTarea = $request->request->get('TareaSolucionar');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                if (!$arTarea->getEstadoTerminado()) {
                    $arTarea->setEstadoTerminado(true);
                    $arTarea->setFechaSolucion(new \DateTime('now'));
                }
                $em->persist($arTarea);

                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaTerminada(1);
                    $em->persist($arCaso);
                }

            }
            if ($request->request->has('TareaVerificar')) {
                $codigoTarea = $request->request->get('TareaVerificar');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                if (!$arTarea->getEstadoVerificado()) {
                    $arTarea->setFechaVerificado(new \DateTime('now'));
                    $arTarea->setEstadoVerificado(true);
                }
                $em->persist($arTarea);
                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaRevisada(1);
                    $em->persist($arCaso);
                }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('listaTareaGeneral'));

        }

        $sinTerminar = 0;
        $sinAsignar = 0;
        $sinVerificar = 0;

        $arTarea = $em->createQuery($this->strDqlLista)->getResult();
        foreach ($arTarea as $key => $value) {
            if ($value->getCodigoUsuarioAsignaFk() == null) {
                $sinAsignar++;
            } else if (!$value->getEstadoTerminado()) {
                $sinTerminar++;
            } else if ($value->getEstadoTerminado() && !$value->getEstadoVerificado()) {
                $sinVerificar++;
            }
        }

        $arrTareas = $paginator->paginate($em->createQuery($this->strDqlLista), $request->query->get('page', 1), 20);
        return $this->render('Tarea/listar.html.twig', [
            'tareas' => $arrTareas,
            'sinTerminar' => $sinTerminar,
            'sinAsignar' => $sinAsignar,
            'sinVerificar' => $sinVerificar,
            'formFiltro' => $formFiltro->createView(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tarea/comentarios/{codigoTareaPk}",requirements={"codigoTareaPk":"\d+"}, name="verComentariosTarea")
     */

    public function verComentariosTarea($codigoTareaPk)
    {
        $em = $this->getDoctrine()->getManager();
        $comentarios = $em->getRepository('App:Comentario')->findBy(array('codigoTareaFk' => $codigoTareaPk));
        return $this->render('Tarea/verComentarios.html.twig', array(
            'comentarios' => $comentarios
        ));
    }

    /**
     * @Route("/tarea/lista/usuario", name="listaTareaUsuario")
     */
    public function listaUsuario(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $user = $this->getUser();
        $arTarea = $em->getRepository('App:Tarea')->findBy(array('codigoUsuarioAsignaFk' => $user->getCodigoUsuarioPk(), 'estadoTerminado' => false), array('estadoTerminado' => 'ASC', 'estadoVerificado' => 'ASC', 'fechaGestion' => 'DESC'));// consulta llamadas por usuario logueado
        $form = $this::createFormBuilder()->getForm(); // form para manejar actualizacion de estado de llamadas
        $form->handleRequest($request);
        $sinTerminar = 0;
        $sinVerificar = 0;
        foreach ($arTarea as $key => $value) {
            if (!$value->getEstadoTerminado()) {
                $sinTerminar++;
            } else if (!$value->getEstadoVerificado()) {
                $sinVerificar++;
            }
        }
        if ($form->isSubmitted() && $form->isValid()) { // actualiza el estado de las llamadas
            if ($request->request->has('TareaEjecucion')) {
                $codigoTarea = $request->request->get('TareaEjecucion');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                if ($arTarea->getEstadoEjecucion() == 0) {
                    $arTarea->setEstadoEjecucion(true);
                    $arTarea->setFechaEjecucion(new \DateTime('now'));
                    $em->persist($arTarea);

                    $arUsuario = $em->getRepository('App:Usuario')->find($this->getUser()->getCodigoUsuarioPk());
                    $arUsuario->setTareaRel($arTarea);
                    $em->persist($arUsuario);
                } else {
                    $arTarea->setEstadoEjecucion(false);
                    $em->persist($arTarea);

                    $arUsuario = $em->getRepository('App:Usuario')->find($this->getUser()->getCodigoUsuarioPk());
                    $arUsuario->setTareaRel(null);
                    $em->persist($arUsuario);
                }
            }
            if ($request->request->has('TareaSolucionar')) {
                $codigoTarea = $request->request->get('TareaSolucionar');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                if (!$arTarea->getEstadoTerminado()) {
                    $arTarea->setEstadoTerminado(true);
                    $arTarea->setFechaSolucion(new \DateTime('now'));
                    $em->persist($arTarea);
                    $arUsuario = $em->getRepository('App:Usuario')->find($this->getUser()->getCodigoUsuarioPk());
                    if ($arUsuario->getCodigoTareaFk() == $codigoTarea) {
                        $arUsuario->setTareaRel(null);
                        $em->persist($arUsuario);
                    }
                    $em->persist($arTarea);
                    if ($arTarea->getCodigoCasoFk()) {
                        $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                        $arCaso->setEstadoTareaTerminada(1);
                        $em->persist($arCaso);
                    }
                }
            }
            if ($request->request->has('TareaVerificar')) {
                $codigoTarea = $request->request->get('TareaVerificar');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                if (!$arTarea->getEstadoVerificado()) {
                    $arTarea->setFechaVerificado(new \DateTime('now'));
                    $arTarea->setEstadoVerificado(true);
                }
                $em->persist($arTarea);
                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaRevisada(1);
                    $em->persist($arCaso);
                }

            }

            if ($request->request->has('TareaIncompresible')) {
                $codigoTarea = $request->request->get('TareaIncompresible');
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                $arTarea->setEstadoIncomprensible(true);
                $em->persist($arTarea);
            }

            $em->flush();
            return $this->redirect($this->generateUrl('listaTareaUsuario'));
        }

        $arrTareas = $paginator->paginate($arTarea, $request->query->get('page', 1), 20);


        return $this->render('Tarea/listarUsuario.html.twig', [
            'tareas' => $arrTareas,
            'sinTerminar' => $sinTerminar,
            'sinVerificar' => $sinVerificar,
            'form' => $form->createView(),
        ]);


    }


    /**
     * @Route("/tarea/comentario/registrar/{codigoTarea}/{codigoSolicitud}",requirements={"codigoTarea":"\d+","codigoSolicitud":"\d+"}, name="registrarComentario")
     */
    public function registrarComentario(Request $request, $codigoTarea = 0, $codigoSolicitud = 0)
    {

        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arComentario = new Comentario();
        $form = $this->createFormBuilder()
            ->add('comentario', TextareaType::class)
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($codigoTarea != 0) {
                $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
                $user = $em->getRepository('App:Usuario')->find($arTarea->getCodigoUsuarioAsignaFk());
                $idUser = $user->getCodigoUsuarioPk();
            }
            if ($codigoSolicitud != 0) {
                $arSolicitud = $em->getRepository("App:Solicitud")->find($codigoSolicitud);
                $idUser = $this->getUser()->getCodigoUsuarioPk();
            }
            $arComentario->setFechaRegistro(new \DateTime('now'));
            $arComentario->setComentario($form->get('comentario')->getData());
            $arComentario->setCodigoUsuarioFk($idUser);
            if ($codigoTarea != 0) {
                $arComentario->setTareaRel($arTarea);
            }
            if ($codigoSolicitud != 0) {
                $arComentario->setSolicitudRel($arSolicitud);
            }
            $em->persist($arComentario);


            $em->flush();
            echo "<script>window.opener.location.reload();window.close()</script>";
        }

        return $this->render('Tarea/comentario.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tarea/lista/historico", name="listaTareaHistorico")
     */
    public function listaHistorico(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $arTarea = $em->getRepository('App:Tarea')->findBy(array('estadoVerificado' => true), array('fechaRegistro' => 'DESC'));
        $arrTareas = $paginator->paginate($arTarea, $request->query->get('page', 1), 20);


        // en index pagina con datos generales de la app
        return $this->render('Tarea/listarHistorico.html.twig', [
            'tareas' => $arrTareas,
        ]);
    }

    /**
     * @Route("/tarea/detalle/{codigoTarea}", name="tareaDetalle")
     */
    public function detalleAction(Request $request, $codigoTarea, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
        $arDevoluciones = $em->getRepository("App:TareaDevolucion")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoTareaDevolucionPk' => 'DESC'));
        $arTareaTiempos = $em->getRepository("App:TareaTiempo")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoTareaTiempoPk' => 'DESC'));
        $arComentarios = $em->getRepository("App:Comentario")->findBy(array('codigoTareaFk' => $codigoTarea),array('codigoComentarioPk' => 'DESC'));
        $form = $this->formularioDetalles($arTarea);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get("BtnEjecucion")->isClicked()) {
                $arTarea->setEstadoEjecucion(1);
                $arTarea->setFechaEjecucion(new \DateTime('now'));
                $codigoTareaTiempo = $em->getRepository("App:TareaTiempo")->registroTiempoTareaInicio($arTarea,$this->getUser()->getCodigoUsuarioPk());
                $arTarea->setCodigoTareaTiempoFk($codigoTareaTiempo);
                $em->persist($arTarea);
            }
            if($form->get("BtnResuelto")->isClicked()) {
                $arTarea->setEstadoTerminado(1);
                $arTarea->setFechaSolucion(new \DateTime('now'));
                $codigoTareaTiempo = $em->getRepository("App:TareaTiempo")->registroTiempoTareaFin($arTarea);
                $em->persist($arTarea);
                $usuario = $em->getRepository("App:Usuario")->find($arTarea->getCodigoUsuarioRegistraFk());
                $correo = $usuario->getCorreo();
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    $message = (new \Swift_Message('Solucion de tarea - AppSoga'.' - '.$arTarea->getCodigoTareaPk()))
                        ->setFrom('sogainformacion@gmail.com')
                        ->setTo($correo)
                        ->setBody(
                            $this->renderView(
                                'Correo/Tarea/notificacionSolucion.html.twig',
                                array('arTarea' => $arTarea)
                            ),
                            'text/html'
                        );
                    $mailer->send($message);

                }
                $em->flush();
                return $this->redirect($this->generateUrl('listaTareaUsuario'));
            }
            if($form->get("BtnIncomprendido")->isClicked()) {
                $arTarea->setEstadoIncomprensible(1);
                $em->persist($arTarea);
            }
            if($form->get("BtnPausar")->isClicked()) {
                $arTarea->setEstadoPausa(1);
                $codigoTareaTiempo = $em->getRepository("App:TareaTiempo")->registroTiempoTareaFin($arTarea);
                $em->persist($arTarea);
            }
            if($form->get("BtnReanudar")->isClicked()) {
                $arTarea->setEstadoPausa(0);
                $codigoTareaTiempo = $em->getRepository("App:TareaTiempo")->registroTiempoTareaInicio($arTarea,$this->getUser()->getCodigoUsuarioPk());
                $arTarea->setCodigoTareaTiempoFk($codigoTareaTiempo);
                $em->persist($arTarea);
            }
            if($form->get("btnGuardar")->isClicked()){
                $arComentario = new Comentario();
                $arComentario->setTareaRel($arTarea);
                $arComentario->setFechaRegistro(new \DateTime('now'));
                $arComentario->setComentario($form->get("comentario")->getData());
                $arComentario->setCodigoUsuarioFk($this->getUser()->getCodigoUsuarioPk());
                $em->persist($arComentario);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('tareaDetalle', array('codigoTarea' => $codigoTarea)));
        }

        return $this->render('Tarea/detalle.html.twig', [
            'tarea' => $arTarea,
            'arDevoluciones' => $arDevoluciones,
            'arTareaTiempos' => $arTareaTiempos,
            'arComentarios' => $arComentarios,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/tarea/devolucion/{codigoTarea}", name="tareaDevolucion")
     */
    public function devolucionTarea(Request $request, $codigoTarea, \Swift_Mailer $mailer){
        $em = $this->getDoctrine()->getManager();
        $devolucion = new TareaDevolucion();
        $arTarea = $em->getRepository('App:Tarea')->find($codigoTarea);
        $form = $this->createFormBuilder()
            ->add('comentario', TextareaType::class,array('attr' => array('rows' => 5, 'style' => 'width: 95%;')))
            ->add('BtnGuardar', SubmitType::class, ['label' => 'Guardar'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get("BtnGuardar")->isClicked()){
                $devolucion->setFecha(new \DateTime('now'));
                $devolucion->setComentarios($form->get("comentario")->getData());
                $devolucion->setDevolucionRel($arTarea);
                $arTarea->setEstadoTerminado(0);
                $arTarea->setEstadoEjecucion(0);
                $arTarea->setFechaEjecucion(null);
                $arTarea->setFechaSolucion(null);
                $arTarea->setFechaVerificado(null);
                if ($arTarea->getCodigoCasoFk()) {
                    $arCaso = $em->getRepository(Caso::class)->find($arTarea->getCodigoCasoFk());
                    $arCaso->setEstadoTareaTerminada(0);
                    $arCaso->setEstadoTareaRevisada(0);
                    $em->persist($arCaso);
                }
                if($arTarea->getNumeroDevoluciones() != null){
                    $count = $arTarea->getNumeroDevoluciones() + 1;
                    $arTarea->setNumeroDevoluciones($count);
                }else{
                    $arTarea->setNumeroDevoluciones(1);
                }
                $em->persist($devolucion);
                $em->persist($arTarea);
                $em->flush();
                $usuario = $em->getRepository("App:Usuario")->find($arTarea->getCodigoUsuarioAsignaFk());
                $correo = $usuario->getCorreo();
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    $message = (new \Swift_Message('Devolucion de tarea - AppSoga'.' - '.$arTarea->getCodigoTareaPk()))
                        ->setFrom('sogainformacion@gmail.com')
                        ->setTo($correo)
                        ->setBody(
                            $this->renderView(
                                'Correo/Tarea/notificacionDevolucion.html.twig',
                                array('arTarea' => $arTarea,
                                    'devolucion' => $devolucion)
                            ),
                            'text/html'
                        );
                    $mailer->send($message);

                }
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }

        return $this->render('Tarea/devolucion.html.twig',array(
            "arTarea" => $arTarea,
            "form" => $form->createView()
        ));

    }

    private function formularioFiltro()
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $arrPropiedadesUsuario = array(
                'class' => 'App\Entity\Usuario',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.codigoUsuarioPk', 'DESC');},
                'choice_label' => 'codigoUsuarioPk',
                'required' => false,
                'empty_data' => "",
                'placeholder' => "TODOS",
                'label' => "Usuario",
                'data' => ""
            );
        if($session->get('filtroUsuario')){
            $arrPropiedadesUsuario["data"] = $em->getRepository("App:Usuario")->findOneBy(array('codigoUsuarioPk' => $session->get('filtroUsuario')));
        }
        $arrPropiedadesCasos = array(
            'class' => 'App\Entity\Tarea',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->andWhere("t.codigoCasoFk IS NOT NULL")
                    ->orderBy('t.codigoCasoFk', 'DESC');},
            'choice_label' => 'codigoCasoFk',
            'choice_value' => 'codigoCasoFk',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'label' => "Caso",
            'data' => ""
        );
        if($session->get('filtroCaso')){
            $arrPropiedadesCasos["data"] = $em->getRepository("App:Tarea")->findOneBy(array('codigoCasoFk' => $session->get('filtroCaso')));
        }
        $estado = "";
        if ($session->get('estado')) {
            $arTarea = $em->getRepository('App:Tarea')->findAll();
        };
        $formFiltro = $this::createFormBuilder()
            ->add('estado', ChoiceType::class, array('choices' => array('Todos' => '', 'SI' => 1, 'NO' => 0), 'label' => 'Resuelto:', 'data' => $session->get('filtroEstado', 2),'required'=>false))
            ->add('verificado',ChoiceType::class,array('choices' => array('Todos' => "","SI"=> 1, "NO" => 0), "label" => "Verificado:", "data" => $session->get("filtroVerificado"),'required'=>false))
            ->add('pausado', ChoiceType::class,array('choices' => array('Todos' => "","SI"=> 1, "NO" => 0), "label" => "Pausado:", "data" => $session->get("filtroPausado"),'required'=>false))
            ->add('incomprensibles', ChoiceType::class,array('choices' => array('Todos' => "","SI"=> 1, "NO" => 0), "label" => "Incomprensibles:", "data" => $session->get("filtroIncomprensible"),'required'=>false))
            ->add('ejecucion', ChoiceType::class,array('choices' => array('Todos' => "","SI"=> 1, "NO" => 0), "label" => "Ejecucion:", "data" => $session->get("filtroEjecucion"),'required'=>false))
            ->add('usuarioAsignaRel', EntityType::class,$arrPropiedadesUsuario)
            ->add('casoRel', EntityType::class,$arrPropiedadesCasos)
            ->add('BtnFiltrar', SubmitType::class, array('label' => 'Filtrar'))
            ->getForm();

        return $formFiltro;

    }

    private function filtrar($formFiltro)
    {
        $session = new Session();
        $session->set('filtroEstado', $formFiltro->get('estado')->getData());
        $session->set('filtroVerificado', $formFiltro->get('verificado')->getData());
        $session->set('filtroPausado', $formFiltro->get('pausado')->getData());
        $session->set('filtroIncomprensible', $formFiltro->get('incomprensibles')->getData());
        $session->set('filtroEjecucion', $formFiltro->get('ejecucion')->getData());
        $codigoUsuario = "";
        if($formFiltro->get('usuarioAsignaRel')->getData()){
            $codigoUsuario = $formFiltro->get('usuarioAsignaRel')->getData()->getCodigoUsuarioPk();
        }
        $codigoCaso = "";
        $session->set('filtroUsuario', $codigoUsuario);
        if($formFiltro->get('casoRel')->getData()){
            $codigoCaso = $formFiltro->get('casoRel')->getData()->getCodigoCasoFk();
        }
        $session->set('filtroCaso', $codigoCaso);

    }


    private function listar()
    {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $this->strDqlLista = $em->getRepository('App:Tarea')->listaDql(
            $session->get('filtroEstado'),
            $session->get("filtroVerificado"),
            $session->get('filtroPausado'),
            $session->get('filtroIncomprensible'),
            $session->get('filtroEjecucion'),
            $session->get('filtroUsuario'),
            $session->get('filtroCaso')


        );
    }

    /**
     * @Route("/tarea/lista/{intCodigoCasoFk}", requirements={"intCodigoCasoFk":"\d+"}, name="listaTareaCaso")
     */
    public function listaTareaCaso(Request $request, $intCodigoCasoFk = 0)
    {

        $em = $this->getDoctrine()->getManager();
        if ($intCodigoCasoFk != 0) {
            $arTareas = $em->getRepository('App:Tarea')->listaPorCaso($intCodigoCasoFk);
        }
        $sinTerminar = 0;
        $sinVerificar = 0;

        return $this->render('Tarea/listarPorCaso.html.twig', array(
            'tareas' => $arTareas,
            'codigoCaso' => $intCodigoCasoFk

        ));

    }

    private function formularioVer($arTarea)
    {
        $arrBotonEjecucion = array('label' => 'Ejecucion','disabled'=> true);
        $arrBotonResuelto = array('label' => 'Resuelto','disabled'=> true);
        $arrBotonVerificado = array('label' => 'Verificado', 'attr' => array('style' => 'display:none;'));
        if ($arTarea->getEstadoEjecucion() == 1) {
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
        }
        if ($arTarea->getEstadoTerminado() == 1) {
            $arrBotonResuelto['attr']['style'] = 'display:none;';
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonVerificado['attr']['style'] = '';

        }
        if ($arTarea->getEstadoVerificado() == 1) {
            $arrBotonVerificado['attr']['style'] = 'display:none;';
        }
        if ($arTarea->getEstadoIncomprensible() == 1) {
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonResuelto['attr']['style'] = 'display:none;';
            $arrBotonVerificado['attr']['style'] = 'display:none;';

        }
        $form = $this->createFormBuilder()
            ->add('BtnEjecucion', SubmitType::class, $arrBotonEjecucion)
            ->add('BtnResuelto', SubmitType::class, $arrBotonResuelto)
            ->add('BtnVerificado', SubmitType::class, $arrBotonVerificado)
            ->add('comentario', TextareaType::class, array('label' => 'Comentarios',"attr" => array("rows" => 3,"style" => "margin: 0px; width: 367px; height: 52px;")))
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar',))
            ->getForm();
        return $form;
    }

    private function formularioDetalles($arTarea)
    {
        $arrBotonEjecucion = array('label' => 'Ejecucion');
        $arrBotonIncomprendido = array('label' => 'Incomprensible');
        $arrBotonResuelto = array('label' => 'Resuelto', 'attr' => array('style' => 'display:none;'));
        $arrBotonPausar = array('label' => 'Pausar', 'attr' => array('style' => 'display:none;'));
        $arrBotonReanudar = array('label' => 'Reanudar', 'attr' => array('style' => 'display:none;'));
        if($arTarea->getEstadoEjecucion() == 1 && $arTarea->getEstadoPausa() == 1){
            $arrBotonReanudar['attr']['style'] = '';
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonIncomprendido['attr']['style'] = 'display:none;';
        }elseif($arTarea->getEstadoEjecucion() == 1 && $arTarea->getEstadoPausa() == 0){
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonIncomprendido['attr']['style'] = 'display:none;';
            $arrBotonPausar['attr']['style'] = '';
            $arrBotonResuelto['attr']['style'] = '';
        }
        if($arTarea->getEstadoIncomprensible() == 1){
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonIncomprendido['attr']['style'] = 'display:none;';
        }
        if($arTarea->getEstadoTerminado() == 1){
            $arrBotonEjecucion['attr']['style'] = 'display:none;';
            $arrBotonIncomprendido['attr']['style'] = 'display:none;';
            $arrBotonResuelto = array('label' => 'Resuelto', 'attr' => array('style' => 'display:none;'));
            $arrBotonPausar = array('label' => 'Pausar', 'attr' => array('style' => 'display:none;'));
            $arrBotonReanudar = array('label' => 'Reanudar', 'attr' => array('style' => 'display:none;'));
        }

        $form = $this->createFormBuilder()
            ->add('BtnEjecucion', SubmitType::class, $arrBotonEjecucion)
            ->add('BtnResuelto', SubmitType::class, $arrBotonResuelto)
            ->add('BtnPausar', SubmitType::class, $arrBotonPausar)
            ->add('BtnIncomprendido', SubmitType::class, $arrBotonIncomprendido)
            ->add('BtnReanudar', SubmitType::class, $arrBotonReanudar)
            ->add('comentario', TextareaType::class, array('label' => 'Comentarios', "attr" => array("rows" => 3,"style" => "margin: 0px; width: 367px; height: 52px;")))
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        return $form;
    }

}
