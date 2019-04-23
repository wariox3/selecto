<?php

namespace App\Controller\Inventario\Administracion;

use App\Entity\Inventario\InvItem;
use App\Form\Type\ItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends Controller
{
    /**
     * @Route("/item/lista", name="item_lista")
     */
    public function lista(Request $request)
    {

        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoItem', TextType::class, ['required' => false, 'data' => $session->get('filtroItemCodigo')])
            ->add('descripcion', TextType::class, ['required' => false, 'data' => $session->get('filtroItemDescripcion')])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemCodigo', $form->get('codigoItem')->getData());
                $session->set('filtroItemDescripcion', $form->get('descripcion')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(InvItem::class, $arItems);
                return $this->redirect($this->generateUrl('item_lista'));
            }
        }
        $arItems = $paginator->paginate($em->getRepository(InvItem::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('Inventario/Administracion/Item/lista.html.twig', [
            'arItems' => $arItems,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/item/nuevo/{id}", name="item_nuevo")
     */
    public function nuevo(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $arItem = new InvItem();
        if ($id != 0) {
            $arItem = $em->getRepository(InvItem::class)->find($id);
        }
        $form = $this->createForm(ItemType::class, $arItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arItem = $form->getData();
                $arItem->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFK());
                $em->persist($arItem);
                $em->flush();
                return $this->redirect($this->generateUrl('item_detalle', array('id' => $arItem->getCodigoItemPk())));
            }
        }
        return $this->render('Inventario/Administracion/Item/nuevo.html.twig', [
            'arItem' => $arItem,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/item/detalle/{id}", name="item_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arItem = $em->getRepository(InvItem::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('item_detalle', ['id' => $id]));
        }
        return $this->render('Inventario/Administracion/Item/detalle.html.twig', [
            'form' => $form->createView(),
            'arItem' => $arItem,
        ]);
    }
}