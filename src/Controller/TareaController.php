<?php

namespace App\Controller;


use App\Entity\Caso;
use App\Entity\Comentario;
use App\Entity\TareaDevolucion;
use App\Forms\Type\FormTypeTarea;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Tarea;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TareaController extends Controller
{
    var $strDqlLista = "";

    /**
     * @Route("/tarea/lista", name="tarea_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('estadoEjecucion', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoEjecucion'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('estadoTerminado'), 'required' => false])
            ->add('estadoIncomprensible', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoIncomprensible'), 'required' => false])
            ->add('estadoPausa', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTareaEstadoPausa'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroTareaEstadoEjecucion', $form->get('estadoEjecucion')->getData());
                $session->set('filtroTareaEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroTareaEstadoIncomprensible', $form->get('estadoIncomprensible')->getData());
                $session->set('filtroTareaEstadoPausa', $form->get('estadoPausa')->getData());
            }
        }
        $arTareas = $paginator->paginate($em->getRepository(Tarea::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Tarea/lista.html.twig', [
            'arTareas' => $arTareas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tarea/detalle/{id}", name="tarea_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arTarea = $em->getRepository(Tarea::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('tarea_detalle', ['id' => $id]));
        }
        return $this->render('Tarea/detalle.html.twig', [
            'form' => $form->createView(),
            'arTarea' => $arTarea
        ]);
    }
}
