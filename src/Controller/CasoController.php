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
     * @Route("/caso/lista", name="caso_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('estadoAtendido', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoAtendido'), 'required' => false])
            ->add('estadoSolucionado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroCasoEstadoSolucionado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroCasoEstadoAtendido', $form->get('estadoAtendido')->getData());
                $session->set('filtroCasoEstadoSolucionado', $form->get('estadoSolucionado')->getData());
            }
            if($request->request->has('btnAtender')) {
                $codigoCaso = $request->request->get('btnAtender');
                $arCaso = $em->getRepository(Caso::class)->find($codigoCaso);
                if(!$arCaso->getEstadoAtendido()){
                    $arCaso->setEstadoAtendido(true);
                    $arCaso->setCodigoUsuarioAtiendeFk($this->getUser()->getCodigoUsuarioPk());
                    $arCaso->setFechaGestion(new \DateTime('now'));
                    $em->persist($arCaso);
                    $em->flush();
                }
            }

        }
        $arCasos = $paginator->paginate($em->getRepository(Caso::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Caso/lista.html.twig', [
            'arCasos' => $arCasos,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/caso/solucionar/{id}", name="caso_solucionar")
     */
    public function solucionar(Request $request, $id, \Swift_Mailer $mailer) {

        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('comentario',TextareaType::class, ['required' => true,'label' => 'Comentario:', 'data' => $arCaso->getSolucion()])
            ->add('btnSolucionar', SubmitType::class, ['label' => 'Solucionar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnSolucionar')->isClicked()) {
                if(!$arCaso->getEstadoAtendido()) {
                    $arCaso->setEstadoAtendido(1);
                    $arCaso->setFechaGestion(new DateTime('now'));
                    $arCaso->setCodigoUsuarioAtiendeFk($this->getUser()->getCodigoUsuarioPk());
                }

                $arCaso->setEstadoSolucionado(1);
                $arCaso->setFechaSolucion(new DateTime('now'));
                $arCaso->setSolucion($form->get('comentario')->getData());
                $arCaso->setCodigoUsuarioSolucionaFk($this->getUser()->getCodigoUsuarioPk());
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
                echo "<script language='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Caso/solucionar.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/caso/detalle/{id}", name="caso_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arCaso = $em->getRepository(Caso::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arrControles = $request->request->all();
            if ($form->get('btnAutorizar')->isClicked()) {
                $em->getRepository(InvPedido::class)->actualizarDetalles($id, $arrControles);
                $em->getRepository(InvPedido::class)->autorizar($arPedido);
            }
            if ($form->get('btnDesautorizar')->isClicked()) {
                $em->getRepository(InvPedido::class)->desautorizar($arPedido);
            }
            if ($form->get('btnImprimir')->isClicked()) {
                $objFormatopedido = new Pedido();
                $objFormatopedido->Generar($em, $id);
            }
            if ($form->get('btnAprobar')->isClicked()) {
                $em->getRepository(InvPedido::class)->aprobar($arPedido);
            }
            if ($form->get('btnAnular')->isClicked()) {
                $em->getRepository(InvPedido::class)->anular($arPedido);
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrDetallesSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(InvPedidoDetalle::class)->eliminar($arPedido, $arrDetallesSeleccionados);
                $em->getRepository(InvPedido::class)->liquidar($id);
            }
            if ($form->get('btnActualizarDetalle')->isClicked()) {
                $em->getRepository(InvPedido::class)->actualizarDetalles($id, $arrControles);
            }
            return $this->redirect($this->generateUrl('inventario_movimiento_comercial_pedido_detalle', ['id' => $id]));
        }
        return $this->render('Caso/detalle.html.twig', [
            'form' => $form->createView(),
            'arCaso' => $arCaso
        ]);
    }


}
