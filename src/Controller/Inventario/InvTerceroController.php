<?php

namespace App\Controller\Inventario;

use App\Entity\Inventario\InvTercero;
use App\Form\Type\TerceroType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class InvTerceroController extends Controller
{
    /**
     * @Route("/Tercero/lista", name="tercero_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoTercero', TextType::class, ['required' => false, 'data' => $session->get('filtroTerceroCodigo')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroTerceroNombreCorto')])
            ->add('cliente', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTerceroCliente'), 'required' => false])
            ->add('proveedor', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTerceroProveedor'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroTerceroCodigo', $form->get('codigoTercero')->getData());
                $session->set('filtroTerceroNombreCorto', $form->get('nombreCorto')->getData());
                $session->set('filtroTerceroCliente', $form->get('cliente')->getData());
                $session->set('filtroTerceroProveedor', $form->get('proveedor')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(InvTercero::class, $arItems);
                return $this->redirect($this->generateUrl('tercero_lista'));
            }
        }
        $arTerceros = $paginator->paginate($em->getRepository(InvTercero::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('Tercero/lista.html.twig', [
            'arTerceros' => $arTerceros,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Tercero/nuevo/{id}", name="tercero_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTercero = new InvTercero();
        if ($id != 0) {
            $arTercero = $em->getRepository(InvTercero::class)->find($id);
        }
        $form = $this->createForm(TerceroType::class, $arTercero);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($form->get('cliente'))
                $arTercero = $form->getData();
                $arTercero->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arTercero);
                $em->flush();
                return $this->redirect($this->generateUrl('tercero_detalle', array('id' => $arTercero->getCodigoTerceroPk())));
            }
        }
        return $this->render('Tercero/nuevo.html.twig', [
            'arTercero' => $arTercero,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Tercero/detalle/{id}", name="tercero_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTercero = $em->getRepository(InvTercero::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('tercero_detalle', ['id' => $id]));
        }
        return $this->render('Tercero/detalle.html.twig', [
            'form' => $form->createView(),
            'arTercero' => $arTercero,
        ]);
    }
}