<?php

namespace App\Controller;

use App\Entity\Caso;
use App\Entity\Cliente;
use App\Entity\Configuracion;
use App\Forms\Type\FormTypeCaso;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Llamada;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\SwiftmailerBundle;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CasoController extends Controller {

    var $strDqlLista = '';

    /**
     * @Route("/caso/nuevo/{codigoCaso}", requirements={"codigoCaso":"\d+"}, name="registrarCaso")
     */
    public function nuevo(Request $request, $codigoCaso = null) {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arCaso = new Caso(); //instance class
		if($codigoCaso) {
            $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
        } else {
            $arCaso->setEstadoAtendido(false);
            $arCaso->setEstadoSolucionado(false);
        }
        $form = $this->createForm(FormTypeCaso::class, $arCaso); //create form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(!$codigoCaso) {
                $arCaso->setFechaRegistro(new \DateTime('now'));
            }
            $em->persist($arCaso);
            $em->flush();
            return $this->redirect($this->generateUrl('listadoCasosSinSolucionar'));
        }
        return $this->render('Caso/nuevo.html.twig',
            array(
                'form' => $form->createView(),
	            ));
    }

    /**
     * @Route("/caso/solucion/registrar/{codigoCaso}",requirements={"codigoCaso":"\d+"}, name="registrarSolucion")
     */
    public function registrarSolucion(Request $request, $codigoCaso = null,  \Swift_Mailer $mailer )
    {
        /**
         * @var $arCaso Caso
         */
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
        $user = $this->getUser()->getCodigoUsuarioPk();

        $form = $this->createFormBuilder()
        ->add ('solucion', TextareaType::class,array(
            'attr' => array(
                'id' => '_solucion',
                'name' => '_solucion',
                'class' => 'form-control',

            ),
	        'required' => false
        ))
        ->add ('requisitoInformacion', TextareaType::class,array(
	        'attr' => array(
		        'id' => '_requisitoInformacion',
		        'name' => '_requisitoInformacion',
		        'class' => 'form-control'
	        ),
	        'required' => false
        ))
        ->add ('btnGuardar', SubmitType::class, array(
            'attr' => array(
                'id' => '_btnGuardar',
                'name' => '_btnGuardar'
            ), 'label' => 'GUARDAR'
        ))

        ->add ('btnEnviar', SubmitType::class, array(
	        'attr' => array(
		        'id' => '_btnEnviar',
		        'name' => '_btnEnviar'
	        ), 'label' => 'Enviar solicitud'
        ))

        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	if($form->get('btnEnviar')->isClicked()){
		        if(filter_var($arCaso->getCorreo(), FILTER_VALIDATE_EMAIL)) {
                    $arrConfiguracion = $em->getRepository(Configuracion::class)->envioCorreo();
			        $message = ( new \Swift_Message( 'Solicitud ampliación de información de caso' . ' - ' . $arCaso->getCodigoCasoPk() ) )
				        ->setFrom( $arrConfiguracion['correoEmpresa'] )
				        ->setTo( $arCaso->getCorreo() )
				        ->setBody(
					        $this->renderView(
					        // templates/emails/registration.html.twig
						        'Correo/Caso/solicitudInformacion.html.twig',
						        array( 'arCaso' => $arCaso,
							            'mensaje' => $form->get('requisitoInformacion')->getData())
					        ),
					        'text/html'
				        );
			        $mailer->send( $message );
		        }
		        $arCaso->setSolicitudInformacion($form->get('requisitoInformacion')->getData());
		        $arCaso->setEstadoSolicitudInformacion(true);
                $arCaso->setEstadoRespuestaSolicitudInformacion(false);
		        $arCaso->setFechaSolicitudInformacion(new \DateTime('now'));
		        $arCaso->setCodigoUsuarioAtiendeFk($user);
		        if($arCaso->getEstadoAtendido() != true ){
			        $arCaso->setEstadoAtendido(true);
			        $arCaso->setFechaGestion(new \ DateTime('now'));
		        }
		        $em->persist($arCaso);
		        $em->flush();
	        }
	        if($form->get('btnGuardar')->isClicked()){
                $arCaso->setCodigoUsuarioSolucionaFk($user);
                if($arCaso->getEstadoAtendido() != true ){
                    $arCaso->setEstadoAtendido(true);
                    $arCaso->setFechaGestion(new \ DateTime('now'));
                }
                $arCaso->setEstadoSolucionado(true);
                $arCaso->setSolucion($form->get('solucion')->getData());
                $em->persist($arCaso);
                $em->flush();
		        if(filter_var($arCaso->getCorreo(), FILTER_VALIDATE_EMAIL)){
		            $arrConfiguracion = $em->getRepository(Configuracion::class)->envioCorreo();
			        $message = (new \Swift_Message('Solución de caso'.' - '.$arCaso->getCodigoCasoPk()))
				        ->setFrom($arrConfiguracion['correoEmpresa'])
				        ->setTo($arCaso->getCorreo())
				        ->setBody(
					        $this->renderView(
						        'Correo/Caso/solucionado.html.twig',
						        array('arCaso' => $arCaso)
					        ),
					        'text/html'
				        );
			        $mailer->send($message);
		        }
	        }
            echo "<script>window.opener.location.reload();window.close()</script>";
        }
        return $this->render('Caso/solucion.html.twig', [
            'form' => $form->createView(),
            'arCaso' => $arCaso
        ]);
    }


    /**
     * @Route("/caso/lista/sin/solucionar", name="listadoCasosSinSolucionar")
     */

    public function listaSinSolucionar(Request $request, Request $requestFiltro) {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $this->listarSinSolucionar($em);
        $session = new Session();
        $propiedades = array(
            'class' => 'App:Cliente',
            'choice_label' => 'nombreComercial',
            'required' => false,
            'label' => 'Cliente:',
            'empty_data' => '',
            'placeholder' => 'Todos',
            'data' =>''
        );
        if($session->get('filtroCasosCliente')){
            $propiedades['data'] = $em->getReference('App:Cliente', $session->get('filtroCasosCliente'));
        }
        $formFiltro = $this::createFormBuilder ()
            ->add('clienteRel', EntityType::class,$propiedades)
            ->add('estadoEscalado', ChoiceType::class, array('choices' => array('TODOS' => '2', 'ESCALADOS' => '1', 'SIN ESCALAR' => '0'), 'label' => 'Escalado:', 'data' => $session->get('filtroCasoEstadoEscalado')))
            ->add('estadoTarea', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TAREA' => '1', 'SIN TAREA' => '0'), 'label' => 'Tarea:' ,'data' => $session->get('filtroCasoEstadoTarea')))
            ->add('estadoTareaTerminada', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TAREA TERMINADA' => '1', 'TAREA SIN TERMINAR' => '0'), 'label' => 'Tarea terminada:' ,'data' => $session->get('filtroCasoEstadoTareaTerminada')))
            ->add('estadoTareaRevisada', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TATERA REVISADA' => '1', 'TAREA SIN REVISAR' => '0'), 'label' => 'Tarea revisada:' ,'data' => $session->get('filtroCasoEstadoTareaRevisada')))
            ->add ('btnFiltrar', SubmitType::class, array (
                'label' => 'Filtrar',
                'attr' => array (
                    'class' => 'btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5'
                )
            ))
            ->getForm();
        $formFiltro->handleRequest($requestFiltro);
        if($formFiltro->isSubmitted() && $formFiltro->isValid()){
            $this->filtrar($formFiltro);
            $this->listarSinSolucionar($em);
        }
        $dql = $em->createQuery($this->strDqlLista);
        $arCaso = $dql->getResult();
        //Listado General Sin Filtro
        $user = $this->getUser();
        $form = $this::createFormBuilder()->getForm();//form para manejar los cambios de estado
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){ // actualiza el estado de las llamadas
            if($request->request->has('casoAtender')) {
                $codigoCaso = $request->request->get('casoAtender');
                $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
                if(!$arCaso->getEstadoAtendido()){
                    $arCaso->setEstadoAtendido(true);
                    $arCaso->setCodigoUsuarioAtiendeFk($user->getCodigoUsuarioPk());
                    $arCaso->setFechaGestion(new \DateTime('now'));
                    $em->persist($arCaso);
                }
            }
            if($request->request->has('casoSolucionar')) {
                $codigoCaso = $request->request->get('casoSolucionar');
                $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
                if(!$arCaso->getEstadoSolucionado()){
                    $arCaso->setEstadoSolucionado(true);
                    $arCaso->setCodigoUsuarioSolucionaFk($user->getCodigoUsuarioPk());
                    $arCaso->setFechaSolucion(new \DateTime('now'));
                    $em->persist($arCaso);
                }
            }
	        if($request->request->has('casoEscalar')) {
		        $codigoCaso = $request->request->get('casoEscalar');
		        $arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
		        if(!$arCaso->getEstadoEscalado()){
			        $arCaso->setEstadoEscalado(true);
			        $em->persist($arCaso);
		        }
	        }
            $em->flush();
            return $this->redirect($this->generateUrl('listadoCasosSinSolucionar'));
        }


        $arrCasos = $paginator->paginate($arCaso, $request->query->get('page', 1),50);

        return $this->render('Caso/listar.html.twig', [
            'casos' => $arrCasos,
            'form' => $form->createView(),
            'formFiltro' => $formFiltro->createView ()
        ]);
    }

    private function filtrar($formFiltro){
        $session = new Session();
        $filtro = $formFiltro->get('clienteRel')->getData();
        if($filtro){
            $session->set('filtroCasosCliente',$filtro->getCodigoClientePk());
        }else {
            $session->set ('filtroCasosCliente', null);
        }
        $session->set('filtroCasoEstadoEscalado', $formFiltro->get('estadoEscalado')->getData());
        $session->set('filtroCasoEstadoTarea', $formFiltro->get('estadoTarea')->getData());
        $session->set('filtroCasoEstadoTareaTerminada', $formFiltro->get('estadoTareaTerminada')->getData());
        $session->set('filtroCasoEstadoTareaRevisada', $formFiltro->get('estadoTareaRevisada')->getData());

    }

    private function listarSinSolucionar($em){
        $session = new Session();
        $this->strDqlLista = $em->getRepository('App:Caso')->filtroDQLSinSolucionar($session->get('filtroCasosCliente'), $session->get('filtroCasoEstadoEscalado'), $session->get('filtroCasoEstadoTarea'), $session->get('filtroCasoEstadoTareaTerminada'), $session->get('filtroCasoEstadoTareaRevisada'));
    }

	private function listarSolucionados($em){
		$session = new Session();
		$this->strDqlLista = $em->getRepository('App:Caso')->filtroDQLSolucionados ($session->get('filtroCasosCliente'));
	}

	/**
	 * @Route("/caso/lista/solucionado", name="listadoCasosSolucionados")
	 */
	public function listaSolucionados(Request $request, Request $requestFiltro) {
		$em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $this->listarSolucionados($em);
		$session = new Session();
		$propiedades = array(
			'class' => 'App:Cliente',
			'choice_label' => 'nombreComercial',
			'required' => false,
			'empty_data' => '',
			'placeholder' => 'Todos',
			'label' => 'Cliente:',
			'data' =>''
		);
		if($session->get('filtroCasosCliente')){
			$propiedades['data'] = $em->getReference('App:Cliente', $session->get('filtroCasosCliente'));
		}

		$formFiltro = $this::createFormBuilder ()
		                   ->add('clienteRel', EntityType::class,$propiedades)
                            ->add('estadoEscalado', ChoiceType::class, array('choices' => array('TODOS' => '2', 'ESCALADOS' => '1', 'SIN ESCALAR' => '0'), 'label' => 'Escalado:' ,'data' => $session->get('filtroCasoEstadoEscalado')))
                            ->add('estadoTarea', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TAREA' => '1', 'SIN TAREA' => '0'), 'label' => 'Estado:' ,'data' => $session->get('filtroCasoEstadoTarea')))
                            ->add('estadoTareaTerminada', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TAREA TERMINADA' => '1', 'TAREA SIN TERMINAR' => '0'), 'label' => 'Terminado:' ,'data' => $session->get('filtroCasoEstadoTareaTerminada')))
                            ->add('estadoTareaRevisada', ChoiceType::class, array('choices' => array('TODOS' => '2', 'TATERA REVISADA' => '1', 'TAREA SIN REVISAR' => '0'), 'label' => 'Revisado:' ,'data' => $session->get('filtroCasoEstadoTareaRevisada')))
		                   ->add ('btnFiltrar', SubmitType::class, array (
			                   'label' => 'Filtrar',
			                   'attr' => array (
				                   'class' => 'btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5'
			                   )
		                   ))
		                   ->getForm();


		$formFiltro->handleRequest($requestFiltro);
		if($formFiltro->isSubmitted() && $formFiltro->isValid()){
			$this->filtrar($formFiltro);
			$this->listarSolucionados($em);
		}
		$dql = $em->createQuery($this->strDqlLista);
		$arCaso = $dql->getResult();
		$user = $this->getUser();
		$form = $this::createFormBuilder()->getForm();//form para manejar los cambios de estado
		$form->handleRequest($request);
		if($form->isSubmitted()){ // actualiza el estado de las llamadas
			if($request->request->has('casoAtender')) {
				$codigoCaso = $request->request->get('casoAtender');
				$arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
				if(!$arCaso->getEstadoAtendido()){
					$arCaso->setEstadoAtendido(true);
					$arCaso->setCodigoUsuarioAtiendeFk($user->getCodigoUsuarioPk());
					$arCaso->setFechaGestion(new \DateTime('now'));
					$em->persist($arCaso);
				}
			}
			if($request->request->has('casoSolucionar')) {
				$codigoCaso = $request->request->get('casoSolucionar');
				$arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
				if(!$arCaso->getEstadoSolucionado()){
					$arCaso->setEstadoSolucionado(true);
					$arCaso->setCodigoUsuarioSolucionaFk($user->getCodigoUsuarioPk());
					$arCaso->setFechaSolucion(new \DateTime('now'));
					$em->persist($arCaso);
				}
			}
			$em->flush();
			return $this->redirect($this->generateUrl('listadoCasosSolucionados'));
		}

        $arrCasos = $paginator->paginate($arCaso, $request->query->get('page', 1),20);


        return $this->render('Caso/listar.html.twig', [
			'casos' => $arrCasos,
			'form' => $form->createView(),
			'formFiltro' => $formFiltro->createView ()
		]);
	}

	/**
	 * @Route("/caso/detalle/{codigoCaso}",requirements={"codigoCaso":"\d+"}, name="casoDetalle")
	 */
	public function listaUno(Request $request, $codigoCaso) {
		$em = $this->getDoctrine()->getManager();
        $arrArchivos = $em->getRepository('App:Archivo')->apiLista(1, $codigoCaso);
        $arrComentarios = $em->getRepository('App:Comentario')->apiLista($codigoCaso, 0);
        $arrTareas = $em->getRepository('App:Tarea')->apiListaCaso($codigoCaso);
		if($codigoCaso != null){
			$arCaso = $em->getRepository('App:Caso')->find($codigoCaso);
		}

		return $this->render('Caso/detalle.html.twig', [
			'caso' => $arCaso,
            'arrArchivos' => $arrArchivos,
            'arrComentarios'=> $arrComentarios,
            'arrTareas' => $arrTareas
		]);
	}
}
