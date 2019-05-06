<?php

namespace App\Controller\Inventario\Informe;

use App\Entity\Inventario\InvItem;
use App\General\General;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ExistenciaController extends Controller
{

    /**
     * @Route("Informe/ExistenciaLista", name="informe_existencia_lista")
     */
    public function listaExistencia(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('txtDescripcion', TextType::class, array('required' => false,'data' => $session->get('filtroItemDescripcion')))
            ->add('txtReferencia', TextType::class, array('required' => false, 'data' => $session->get('filtroItemReferencia')))
            ->add('btnExcel', SubmitType::class, array('label' => 'Excel'))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemDescripcion', $form->get('txtDescripcion')->getData());
                $session->set('filtroItemReferencia', $form->get('txtReferencia')->getData());

            }
            if ($form->get('btnExcel')->isClicked()) {
                General::get()->setExportar($em->createQuery($em->getRepository(InvItem::class)->existencia())->execute(), "Existencia");
            }
        }
        $arItems = $paginator->paginate($em->getRepository(InvItem::class)->existencia(), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Informe/informeExistenciaLista.html.twig', [
            'arItems' => $arItems,
            'form' => $form->createView()
        ]);
    }
}


