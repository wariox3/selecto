<?php

namespace App\Controller;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Compra\ComCuentaPagar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class InformeCuentasPagarController extends Controller
{

    /**
     * @Route("/informeCuentasPagar", name="informe_cuentas_pagar")
     */
    public function informe(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeCuentasPagarFechaDesde') ? date_create($session->get('filtroInformeCuentasPagarFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeCuentasPagarFechaHasta') ? date_create($session->get('filtroInformeCuentasPagarFechaHasta')) : null])
            ->add('txtCuentaPagar', IntegerType::class, array('required' => false, 'data' => $session->get('filtroInformeCuentasPagarCodigo')))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroInformeCuentasPagarFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroInformeCuentasPagarFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('filtroInformeCuentasPagarCodigo', $form->get('txtCuentaPagar')->getData());

            }
        }
        $arCuentasPagar = $paginator->paginate($em->getRepository(ComCuentaPagar::class)->informe(), $request->query->getInt('page', 1), 50);
        return $this->render('Informe/InformeCuentasPagar.html.twig', [
            'arCuentasPagar' => $arCuentasPagar,
            'form' => $form->createView()
        ]);
    }
}


