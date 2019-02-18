<?php
/**
 * Created by PhpStorm.
 * User: jako
 * Date: 5/03/18
 * Time: 03:21 PM
 */

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Error;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class ErrorController extends Controller
{
    private $strDqlLista;

    /**
     * @Route("/error/lista", name="erroresLista")
     */
    public function lista(Request $request, Request $requestForm)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $this->listarErrores($em);

        if ($session->get("filtro_cliente")) {
            $cliente = $em->getRepository("App:Cliente")->find($session->get('filtro_cliente'));
        }
        $formFiltro = $this::createFormBuilder()
            ->add('clienteRel', EntityType::class, [
                'placeholder' => 'Seleccione un cliente',
                'required' => false,
                'class' => 'App:Cliente',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                              ->orderBy('c.nombreComercial', 'ASC');
                },
                'choice_label' => 'nombreComercial',
                'data' => $cliente?? null,
            ])
            ->add('estadoAtendido', CheckboxType::class, [
                'required' => false,
                'data' => $session->get('filtro-estado-atendido'),
            ])
            ->add('estadoSolucionado', CheckboxType::class, [
                'required' => false,
                'data' => $session->get('filtro-estado-solucionado')
            ])
            ->add('btnFiltrar', SubmitType::class, [
                'label' => 'Filtrar',
                'attr' => [
                    'class' => 'btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5'
                ]
            ])
            ->getForm();

        $formFiltro->handleRequest($request);
        $cliente = null;
        if ($formFiltro->isSubmitted() && $formFiltro->isValid()) {
            $this->filtrar($formFiltro);
            $this->listarErrores($em);
        }
        $query = $em->createQuery($this->strDqlLista);
        $errores = $query->getResult();

        return $this->render("Error/listar.html.twig", [
            'errores' => $errores,
            'form' => $formFiltro->createView(),
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