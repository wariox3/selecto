<?php

namespace App\Controller;


use App\Entity\Caso;
use App\Entity\Comentario;
use App\Entity\MatrizDevolucion;
use App\Forms\Type\FormTypeMatriz;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Matriz;
use App\Entity\Usuario;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MatrizController extends Controller
{

    /**
     * @Route("/matriz/lista", name="matriz_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('estadoEjecucion', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMatrizEstadoEjecucion'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('estadoTerminado'), 'required' => false])
            ->add('estadoIncomprensible', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMatrizEstadoIncomprensible'), 'required' => false])
            ->add('estadoPausa', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMatrizEstadoPausa'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroMatrizEstadoEjecucion', $form->get('estadoEjecucion')->getData());
                $session->set('filtroMatrizEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroMatrizEstadoIncomprensible', $form->get('estadoIncomprensible')->getData());
                $session->set('filtroMatrizEstadoPausa', $form->get('estadoPausa')->getData());
            }
        }
        $arMatrices = $paginator->paginate($em->getRepository(Matriz::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Matriz/lista.html.twig', [
            'arMatrices' => $arMatrices,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/matriz/detalle/{id}", name="matriz_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arMatriz = $em->getRepository(Matriz::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('matriz_detalle', ['id' => $id]));
        }
        return $this->render('Matriz/detalle.html.twig', [
            'form' => $form->createView(),
            'arMatriz' => $arMatriz
        ]);
    }
}
