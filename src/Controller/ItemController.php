<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $em=$this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arItems = $paginator->paginate($em->getRepository(Item::class)->lista(), $request->query->getInt('page',1),30);




        return $this->render('item/lista.html.twig', [
            'arItems' =>$arItems,
        ]);



    }


}
