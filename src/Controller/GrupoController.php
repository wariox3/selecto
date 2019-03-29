<?php


namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Grupo;
use App\Form\Type\GrupoType;
use App\Utilidades\Modelo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class GrupoController extends Controller
{
    /**
     * @Route("/admin/grupo/lista", name="grupo_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $form = $this-> createFormBuilder()
             ->add('clave', TextType::class,['required' => false, 'data' => $session->get('filtroClave')])
            ->add('nombre', TextType::class,['required' => false, 'data' => $session->get('filtroNombre')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroClave', $form->get('clave')->getData());
                $session->set('filtroNombre', $form->get('nombre')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arGrupo = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Grupo::class, $arGrupo);

            }
        }

        $arGrupos = $paginator->paginate($em->getRepository(Grupo::class)->lista(),$request->query->getInt('page', 1));
        return $this->render('Grupo/lista.html.twig', [
            'arGrupos' => $arGrupos,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/grupo/nuevo/{id}", name="grupo_nuevo")
     */
    public function nuevo(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arGrupo = new Grupo();
        if($id != 0){
            $arGrupo = $em->getRepository(Grupo::class)->find($id);
        }
        $form = $this->createForm(GrupoType::class, $arGrupo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($form->get('guardar')->isClicked()) {
                $arGrupo = $form->getData();
                $em->persist($arGrupo);
                $em->flush();
                return $this->redirect($this->generateUrl('grupo_detalle', array('id' => $arGrupo->getCodigoGrupoPk())));
            }
        }
        return $this->render('Grupo/nuevo.html.twig', [
            'arGrupo' => $arGrupo,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/grupo/detalle/{id}", name="grupo_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arGrupo = $em->getRepository(Grupo::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('grupo_detalle', ['id' => $id]));
        }
        return $this->render('Grupo/detalle.html.twig', [
            'form' => $form->createView(),
            'arGrupo' => $arGrupo,
        ]);
    }
}