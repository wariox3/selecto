<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class InformeExistenciaController extends Controller
{

    /**
     * @Route("/Informe/informeExistenciaLista", name="informe_existencia_lista")
     */
    public function listaExistencia(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('txtDescripcion', TextType::class, array('required' => false,'data' => $session->get('filtroItemDescripcion')))
            ->add('txtReferencia', TextType::class, array('required' => false, 'data' => $session->get('filtroItemReferencia')))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemDescripcion', $form->get('txtDescripcion')->getData());
                $session->set('filtroItemReferencia', $form->get('txtReferencia')->getData());

            }
        }
        $arItems = $paginator->paginate($em->getRepository(Item::class)->existencia(), $request->query->getInt('page', 1), 50);
        return $this->render('Informe/InformeExistenciaLista.html.twig', [
            'arItems' => $arItems,
            'form' => $form->createView()
        ]);
    }
}


