<?php
/**
 * Created by PhpStorm.
 * User: jako
 * Date: 5/03/18
 * Time: 03:21 PM
 */

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Configuracion;
use App\Entity\Error;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class ErrorController extends Controller
{
    private $strDqlLista;


    /**
     * @Route("/error/lista", name="error_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroErrorEstadoAtendido'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroErrorEstadoSolucionado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroErrorEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroErrorEstadoSolucionado', $form->get('estadoSolucionado')->getData());
            }
        }
        $arErrores = $paginator->paginate($em->getRepository(Error::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('Error/lista.html.twig', [
            'arErrores' => $arErrores,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/error/solucionar/{id}", name="error_solucionar")
     */
    public function solucionar(Request $request, $id, \Swift_Mailer $mailer) {

        $em = $this->getDoctrine()->getManager();
        $arError = $em->getRepository(Error::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('comentario',TextareaType::class, ['required' => false,'label' => 'Comentario:'])
            ->add('enviarCorreo', CheckboxType::class,['required' => false])
            ->add('btnSolucionar', SubmitType::class, ['label' => 'Solucionar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnSolucionar')->isClicked()) {
                $arError->setEstadoAtendido(1);
                $arError->setEstadoSolucionado(1);
                $em->persist($arError);
                $em->flush();
                if($form->get('enviarCorreo')->getData()) {
                    if(filter_var($arError->getEmail(), FILTER_VALIDATE_EMAIL)){
                        $arrConfiguracion = $em->getRepository(Configuracion::class)->envioCorreo();
                        $message = (new \Swift_Message('Error atendido, procesado y solucionado'.' - '.$arError->getCodigoErrorPk()))
                            ->setFrom($arrConfiguracion['correoEmpresa'])
                            ->setTo($arError->getEmail())
                            ->setBody(
                                $this->renderView(
                                    'Error/enviarCorreoSolucion.html.twig',
                                    array('arError' => $arError)
                                ),
                                'text/html'
                            );
                        $mailer->send($message);
                    }
                }
                echo "<script language='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Error/solucionar.html.twig', [
            'form' => $form->createView()
        ]);
    }





















    /**
     * @Route("/error/atender/{codigoError}", name="errorAtender")
     */
    public function errorAtender($codigoError = null)
    {
        /**
         * @var $arError Error
         */
        $em = $this->getDoctrine()->getManager();
        $arError = new Error();

        if ($codigoError != null) {
            $arError = $em->getRepository('App:Error')->find($codigoError);
            $arError->setEstadoAtendido(true);
            $em->persist($arError);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('erroresLista'));
    }

    /**
     * @Route("/error/solucion/registrar/{codigoError}",requirements={"codigoError":"\d+"}, name="registrarSolucionError")
     */
    public function registrarSolucion(Request $request, $codigoError = null, \Swift_Mailer $mailer)
    {
        /**
         * @var $arError Error
         */
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $user = $this->getUser()->getCodigoUsuarioPk();
	    $arError = $em->getRepository('App:Error')->find($codigoError);
        $form = $this->createFormBuilder()
            ->add("mensaje", TextareaType::class, array('label'=>'Mensaje','required'=>false))
	        ->add("ccJefe", CheckboxType::class, array('label'=>'Con copia jefe desarrollo','required'=>false))
	        ->add("enviar", SubmitType::class, array('label'=>'ENVIAR'))
		    ->getForm();
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

        	$mensaje = $form->get('mensaje')->getData();
	        if (filter_var($arError->getEmail(), FILTER_VALIDATE_EMAIL)) {
		        $message = (new \Swift_Message('Hemos solucionado un error encontrado en AppSoga' . ' - ' . $arError->getCodigoErrorPk()))
			        ->setFrom('sogainformacion@gmail.com')
			        ->setTo($arError->getEmail())
			        ->setBody(
				        $this->renderView(
				        // templates/emails/registration.html.twig
					        'Correo/Error/errorSolucionado.html.twig',
					        array('arError' => $arError,
						        'mensaje'=>$mensaje,
						        'user' => $user
					        )
				        ),
				        'text/html'
			        );
		        if($form->get('ccJefe')->getData() == true){
		        	$message->addCc('jefedesarrollo@appsoga.com');
		        }
		        $mailer->send($message);
	        }
	        echo "<script>window.opener.location.reload();window.close()</script>";

        }

	    return $this->render("Error/enviarCorreo.html.twig", array(
	    	'form' => $form->createView()
	    ));
	}

    private function filtrar($formFiltro)
    {
        $session = new Session();
        $dataCliente = $formFiltro->get('clienteRel')->getData();
        $dataEstadoAtendido = $formFiltro->get('estadoAtendido')->getData();
        $dataEstadoSolucionado = $formFiltro->get('estadoSolucionado')->getData();
        $codigoCliente = $dataCliente instanceof Cliente? $dataCliente->getCodigoClientePk() : null;
        $session->set('filtroCliente', $codigoCliente);
        $session->set('filtroEstadoAtendido', $dataEstadoAtendido);
        $session->set('filtroEstadoSolucionado', $dataEstadoSolucionado);
    }

    private function listarErrores($em)
    {
        $session = new Session();
        $this->strDqlLista = $em->getRepository('App:Error')->filtroErrores($session->get('filtroCliente'), $session->get("filtroEstadoAtendido"), $session->get('filtroEstadoSolucionado'));
    }

}