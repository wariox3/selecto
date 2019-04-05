<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Movimiento;
use App\Form\Type\ItemType;
use App\Form\Type\MovimientoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MovimientoController extends Controller
{
    /**
     * @Route("/Movimiento/lista", name="movimiento_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');


        $form = $this->createFormBuilder()
            ->add('codigoMovimiento', TextType::class, ['required' => false, 'data' => $session->get('filtroCodigoMovimiento')])
            ->add('fecha', DateType::class, ['required' => false, 'data' => $session->get('filtroFechaMovimiento')])
//            ->add('terceroRel', EntityType::class,array('class' => 'Tercero',
//                'choice_label'=> 'Id Tercero','required' => false, 'data' => $session->get('filtroCodigoTercero')))
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn brtn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);

        $arMovimientos = $paginator->paginate($em->getRepository(Movimiento::class)->lista(), $request->query->getInt('page', 1), 30);
        //dd($arMovimientos);
        return $this->render('Movimiento/lista.html.twig', [
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Movimiento/nuevo/{id}", name="movimiento_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arMovimiento = new Movimiento();
        if ($id != 0) {
            $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        }
        $form = $this->createForm(MovimientoType::class, $arMovimiento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arMovimiento = $form->getData();
                $em->persist($arMovimiento);
                $em->flush();

                return $this->redirect($this->generateUrl('movimiento_detalle', array('id' => $arMovimiento->getCodigoMovimientoPk())));
            }
        }
        return $this->render('Movimiento/nuevo.html.twig', [
            'arMovimiento' => $arMovimiento,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Movimiento/detalle/{id}", name="movimiento_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arMovimiento = $em->getRepository(Movimiento::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('movimiento_detalle', ['id' => $id]));
        }
        return $this->render('Movimiento/detalle.html.twig', [
            'form' => $form->createView(),
            'arMovimiento' => $arMovimiento,
        ]);
    }
}


