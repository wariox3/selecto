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


class GenerarPruebaFEController extends Controller
{
    /**
     * @Route("/general/proceso/generarprueba", name="general_proceso_generarprueba")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoMovimiento', TextType::class, ['required' => false])
            ->add('btnGenerar', SubmitType::class, ['label' => 'Generar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGenerar')->isClicked()) {
                $codigoMovimiento = $form->get('codigoMovimiento')->getData();
                if($codigoMovimiento) {
                    $arMovimiento = $em->getRepository(InvMovimiento::class)->find($codigoMovimiento);
                    if($arMovimiento) {
                        $arMovimiento->setNumero($arMovimiento->getNumero() + 1);
                        $cue = $em->getRepository(InvMovimiento::class)->generarCue($arMovimiento);
                        $arMovimiento->setCue($cue);
                        $em->persist($arMovimiento);
                        $em->flush();
                    }
                }
            }
        }
        return $this->render('General/Proceso/Varios/generarPrueba.html.twig', [
            'form' => $form->createView()
        ]);
    }

}