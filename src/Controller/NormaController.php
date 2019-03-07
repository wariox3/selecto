<?php

namespace App\Controller;


use App\Form\Type\NormaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Norma;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class NormaController extends Controller
{

    /**
     * @Route("/admin/norma/nuevo/{id}/{codigoMatriz}", name="norma_nuevo")
     */
    public function nuevo(Request $request, $id, $codigoMatriz)
    {
        $em = $this->getDoctrine()->getManager();
        $arNorma = new Norma();
        if ($id != 0) {
            $arNorma = $em->getRepository(Norma::class)->find($id);
        } else {
            $arNorma->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(NormaType::class, $arNorma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $nombre = $arNorma->getNormaTipoRel()->getNombre() . " " . $arNorma->getNumero() . " de " . $arNorma->getFecha()->format('Y-m-d');
                $arNorma->setNombre($nombre);
                $arNorma->setGrupoRel($arNorma->getSubgrupoRel()->getGrupoRel());
                $arNorma = $form->getData();
                $em->persist($arNorma);
                $em->flush();
                return $this->redirect($this->generateUrl('norma_detalle', array('id' => $arNorma->getCodigoNormaPk())));
            }
        }
        return $this->render('Norma/nuevo.html.twig', [
            'arNorma' => $arNorma,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/norma/lista", name="norma_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigo', NumberType::class, ['required' => false, 'data' => $session->get('filtroNormaCodigo')])
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaNombre')])
            ->add('descripcion', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaDescripcion')])
            ->add('estadoDerogado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroNormaEstadoDerogado', $form->get('estadoDerogado')->getData());
                $session->set('filtroNormaCodigo', $form->get('codigo')->getData());
                $session->set('filtroNormaNombre', $form->get('nombre')->getData());
                $session->set('filtroNormaDescripcion', $form->get('descripcion')->getData());
            }
        }
        $arNormas = $paginator->paginate($em->getRepository(Norma::class)->lista(), $request->query->getInt('page', 1), 500);
        return $this->render('Norma/lista.html.twig', [
            'arNormas' => $arNormas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/norma/detalle/{id}", name="norma_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arNorma = $em->getRepository(Norma::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('norma_detalle', ['id' => $id]));
        }
        return $this->render('Norma/detalle.html.twig', [
            'form' => $form->createView(),
            'arNorma' => $arNorma
        ]);
    }

}
