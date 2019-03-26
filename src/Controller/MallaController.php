<?php

namespace App\Controller;


use App\Entity\Caso;
use App\Entity\Comentario;
use App\Entity\MallaDevolucion;
use App\Forms\Type\FormTypeMalla;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Malla;
use App\Entity\Usuario;
use Symfony\Component\Form\Extension\Core\Type\TexmallaType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class MallaController extends Controller
{
    var $strDqlLista = "";

    /**
     * @Route("/malla/lista", name="malla_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('estadoEjecucion', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMallaEstadoEjecucion'), 'required' => false])
            ->add('estadoTerminado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('estadoTerminado'), 'required' => false])
            ->add('estadoIncomprensible', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMallaEstadoIncomprensible'), 'required' => false])
            ->add('estadoPausa', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroMallaEstadoPausa'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroMallaEstadoEjecucion', $form->get('estadoEjecucion')->getData());
                $session->set('filtroMallaEstadoTerminado', $form->get('estadoTerminado')->getData());
                $session->set('filtroMallaEstadoIncomprensible', $form->get('estadoIncomprensible')->getData());
                $session->set('filtroMallaEstadoPausa', $form->get('estadoPausa')->getData());
            }
        }
        $arMallas = $paginator->paginate($em->getRepository(Malla::class)->listaCliente($this->getUser()->getCodigoClienteFk()), $request->query->getInt('page', 1), 500);
        return $this->render('Malla/lista.html.twig', [
            'arMallas' => $arMallas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/malla/detalle/{id}", name="malla_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arMalla = $em->getRepository(Malla::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('malla_detalle', ['id' => $id]));
        }
        return $this->render('Malla/detalle.html.twig', [
            'form' => $form->createView(),
            'arMalla' => $arMalla
        ]);
    }
}
