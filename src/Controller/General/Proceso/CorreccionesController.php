<?php

namespace App\Controller\General\Proceso;

use App\Entity\General\GenRespuestaFacturaElectronica;
use App\Entity\General\GenTercero;
use App\Entity\Inventario\InvMovimiento;
use App\Form\Type\Inventario\TerceroType;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class CorreccionesController extends Controller
{
    /**
     * @Route("/general/proceso/correcciones", name="general_proceso_correcciones")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnGenerar', SubmitType::class, ['label' => 'CUFE CUDE', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGenerar')->isClicked()) {
                $this->getDoctrine()->getRepository(InvMovimiento::class)->corregirCue();
            }
        }
        return $this->render('General/Proceso/correcciones.html.twig', [
            'form' => $form->createView()
        ]);
    }

}