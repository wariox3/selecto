<?php

namespace App\Controller;


use App\Entity\Norma;
use App\Form\Type\MatrizType;
use App\Form\Type\NormaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Matriz;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class MatrizController extends Controller
{

    /**
     * @Route("/admin/matriz/nuevo/{id}", name="matriz_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arMatriz = new Matriz();
        if ($id != 0) {
            $arMatriz = $em->getRepository(Matriz::class)->find($id);
        }
        $form = $this->createForm(MatrizType::class, $arMatriz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arMatriz = $form->getData();
                $em->persist($arMatriz);
                $em->flush();
                return $this->redirect($this->generateUrl('matriz_detalle', array('id' => $arMatriz->getCodigoMatrizPk())));
            }
        }
        return $this->render('Matriz/nuevo.html.twig', [
            'arMatriz' => $arMatriz,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/matriz/lista", name="matriz_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroMatrizNombre')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroMatrizNombre', $form->get('nombre')->getData());
            }
        }
        $arMatrices = $paginator->paginate($em->getRepository(Matriz::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Matriz/lista.html.twig', [
            'arMatrices' => $arMatrices,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/matriz/detalle/{id}", name="matriz_detalle")
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
        $arNormas = $paginator->paginate($em->getRepository(Norma::class)->listaMatriz($id), $request->query->getInt('page', 1), 500);
        return $this->render('Matriz/detalle.html.twig', [
            'form' => $form->createView(),
            'arMatriz' => $arMatriz,
            'arNormas' => $arNormas
        ]);
    }

    /**
     * @Route("/admin/matriz/norma/nuevo/{id}/{codigoMatriz}", name="matriz_norma_nuevo")
     */
    public function nuevoMatriz(Request $request, $id, $codigoMatriz)
    {
        $em = $this->getDoctrine()->getManager();
        $arMatriz = $em->getRepository(Matriz::class)->find($codigoMatriz);
        $arNorma = new Norma();
        if ($id != 0) {
            $arNorma = $em->getRepository(Norma::class)->find($id);
        } else {
            $arNorma->setFecha(new \DateTime('now'));
            $arNorma->setMatrizRel($arMatriz);
            $arNorma->setGrupoRel($arMatriz->getGrupoRel());
        }
        $form = $this->createForm(NormaType::class, $arNorma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $nombre = $arNorma->getNormaTipoRel()->getNombre() . " " . $arNorma->getNumero() . " de " . $arNorma->getFecha()->format('Y-m-d');
                $arNorma->setNombre($nombre);
                $arNorma = $form->getData();
                $em->persist($arNorma);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Matriz/nuevoNorma.html.twig', [
            'arNorma' => $arNorma,
            'form' => $form->createView()
        ]);
    }

}
