<?php

namespace App\Controller\Cartera\Informe;

use App\Entity\Cartera\CarCuentaCobrar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CuentasCobrarController extends Controller
{

    /**
     * @Route("/cartera/informe/cuentascobrar", name="informe_cuentas_cobrar")
     */
    public function informe(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeCuentasCobrarFechaDesde') ? date_create($session->get('filtroInformeCuentasCobrarFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeCuentasCobrarFechaHasta') ? date_create($session->get('filtroInformeCuentasCobrarFechaHasta')) : null])
            ->add('txtCuentaCobrar', TextType::class, array('required' => false, 'data' => $session->get('filtroInformeCuentasCobrarNombreCorto')))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroInformeCuentasCobrarFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroInformeCuentasCobrarFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('filtroInformeCuentasCobrarNombreCorto', $form->get('txtCuentaCobrar')->getData());

            }
        }
        $arCuentasCobrar = $paginator->paginate($em->getRepository(CarCuentaCobrar::class)->informe(), $request->query->getInt('page', 1), 50);
        return $this->render('Cartera/Informe/informeCuentasCobrar.html.twig', [
            'arCuentasCobrar' => $arCuentasCobrar,
            'form' => $form->createView()
        ]);
    }
}


