<?php


namespace App\Controller;


use App\Entity\Subgrupo;
//use App\Form\Type\GrupoType;
use App\Form\Type\SubGrupoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SubGrupoController extends  Controller
{
    /**
     * @Route("/admin/subGrupo/lista", name="subGrupo_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $form = $this-> createFormBuilder()
            ->add('clave', TextType::class,['required' => false, 'data' => $session->get('filtroClave')])
            ->add('nombre', TextType::class,['required' => false, 'data' => $session->get('filtroNombre')])
            ->add('Grupo', TextType::class,['required' => false, 'data' => $session->get('filtroGrupo')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroClave', $form->get('clave')->getData());
                $session->set('filtroNombre', $form->get('nombre')->getData());
                $session->set('filtroGrupo', $form->get('Grupo')->getData());

            }

            if($form->get('btnEliminar')->isClicked()){
                $arGrupo = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Grupo::class, $arGrupo);

            }
        }

        $arSubGrupos = $paginator->paginate($em->getRepository(Subgrupo::class)->lista(),$request->query->getInt('page', 1));
        return $this->render('subGrupo/lista.html.twig', [
            'arSubGrupos' => $arSubGrupos,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/subGrupo/nuevo/{id}", name="subGrupo_nuevo")
     */
    public function nuevo(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $booOcultarEmentos = true;
        $arSubGrupo = $em->getRepository(Subgrupo::class)->find($id);
        if(is_null($arSubGrupo)){
            $booOcultarEmentos= false;
            $arSubGrupo = new Subgrupo();
        }
        $form = $this->createForm(SubGrupoType::class, $arSubGrupo);
         $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
             if ($form->get('guardar')->isClicked()) {
                 $arSubGrupo = $form->getData();
                 $em->persist($arSubGrupo);
                 $em->flush();
                 return $this->redirect($this->generateUrl('subGrupo_detalle', array('id' => $arSubGrupo->getCodigoSubgrupoPk())));
             }
         }
        return $this->render('subGrupo/nuevo.html.twig', [
             'arSubGrupo' => $arSubGrupo,
             'form' => $form->createView(),
            'booOcultarEmentos' => $booOcultarEmentos
        ]);
    }

    /**
     * @Route("/admin/subGrupo/detalle/{id}", name="subGrupo_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arSubGrupos = $em->getRepository(Subgrupo::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('subGrupo_detalle', ['id' => $id]));
        }
        return $this->render('subGrupo/detalle.html.twig', [
            'form' => $form->createView(),
            'arSubGrupos' => $arSubGrupos,
        ]);
    }
}