<?php

namespace App\Controller;
use App\Entity\Cliente;


use App\Utilidades\Modelo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\ClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClienteController extends  Controller
{

    /**
    * @Route("/admin/cliente/nuevo/{id}", name="cliente_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
     $em = $this->getDoctrine()->getManager();
        $arCliente = new Cliente();
        if ($id != 0 ){
            $arCliente = $em->getRepository(Cliente::class)->find($id);
        }
        $form = $this->createForm(ClienteType::class, $arCliente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $em->persist($form->getData());
                $em->flush();
                return $this->redirect($this->generateUrl('cliente_detalle', array('id' => $arCliente->getCodigoClientePk())));
            }
        }
        return $this->render('Cliente/nuevo.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/lista", name="cliente_lista")
     */
    public function lista(Request $request )
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');

        $form = $this->createFormBuilder()
            ->add('nombreCorto', TextType::class,['required' => false, 'data' => $session->get('filtroClienteNombreCorto')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
               $session->set('filtroClienteNombreCorto', $form->get('nombreCorto')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Cliente::class, $arrSeleccionados);
                return $this->redirect($this->generateUrl('cliente_lista'));
            }
        }

        $arClientes= $paginator->paginate($em->getRepository(Cliente::class)->lista(),$request->query->getInt('page', 1), 30);
        return $this->render('Cliente/lista.html.twig', [
            'arClientes' => $arClientes,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/detalle/{id}", name="cliente_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arCliente = $em->getRepository(Cliente::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('cliente_detalle', ['id' => $id]));
        }
        return $this->render('Cliente/detalle.html.twig', [
            'form' => $form->createView(),
            'arCliente' => $arCliente,
        ]);

    }
}