<?php


namespace App\Controller;


use App\Entity\Clasificacion;
//use App\Form\Type\clasificacionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ClasificacionController  extends  Controller
{
    /**
     * @Route("/admin/clasificacion/lista", name="clasificacion_lista")
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
            ->add('subGrupo', TextType::class,['required' => false, 'data' => $session->get('filtroSubGrupo')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroClave', $form->get('clave')->getData());
                $session->set('filtroNombre', $form->get('nombre')->getData());
                $session->set('filtroGrupo', $form->get('Grupo')->getData());
                $session->set('filtroSubGrupo', $form->get('subGrupo')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arGrupo = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Grupo::class, $arGrupo);

            }
        }

        $arclasificaciones = $paginator->paginate($em->getRepository(Clasificacion::class)->lista(),$request->query->getInt('page', 1));
        return $this->render('clasificacion/lista.html.twig', [
            'arclasificaciones' => $arclasificaciones,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/clasificacion/nuevo/{id}", name="clasificacion_nuevo")
     */
    public function nuevo(Request $request, $id){
       /* $em = $this->getDoctrine()->getManager();
        $arclasificacion = new clasificacion();
        if($id != 0){
            $arclasificacion = $em->getRepository(clasificacion::class)->find($id);
        }
        $form = $this->createForm(clasificacionType::class, $arclasificacion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($form->get('guardar')->isClicked()) {
                $arclasificacion = $form->getData();
                $em->persist($arclasificacion);
                $em->flush();
                return $this->redirect($this->generateUrl('clasificacion_detalle', array('id' => $arclasificacion->getCodigoclasificacionPk())));
            }
        }
        return $this->render('clasificacion/nuevo.html.twig', [
            'arclasificacion' => $arclasificacion,
            'form' => $form->createView()
        ]);*/
    }

    /**
     * @Route("/admin/clasificacion/detalle/{id}", name="clasificacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
       /* $em = $this->getDoctrine()->getManager();
        $arclasificacions = $em->getRepository(clasificacion::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('clasificacion_detalle', ['id' => $id]));
        }
        return $this->render('clasificacion/detalle.html.twig', [
            'form' => $form->createView(),
            'arclasificacions' => $arclasificacions,
        ]);*/
    }
}