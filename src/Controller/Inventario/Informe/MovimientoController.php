<?php

namespace App\Controller\Inventario\Informe;

use App\Entity\Inventario\InvMovimientoDetalle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MovimientoController extends Controller
{

    /**
     * @Route("/informe/informeMovimientoLista", name="informe_movimiento_lista_Detalle")
     */
    public function listaDetalle(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeMovimientoFechaDesde') ? date_create($session->get('filtroInformeMovimientoFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInformeMovimientoFechaHasta') ? date_create($session->get('filtroInformeMovimientoFechaHasta')) : null])
            ->add('txtNumeroMovimiento', IntegerType::class, array('required' => false, 'data' => $session->get('filtroMovimientoNumero')))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroInformeMovimientoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroInformeMovimientoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('filtroMovimientoNumero', $form->get('txtNumeroMovimiento')->getData());

            }
        }
        $arMovimientoDetalles = $paginator->paginate($em->getRepository(InvMovimientoDetalle::class)->informe(), $request->query->getInt('page', 1), 50);
        return $this->render('Inventario/Informe/informeMovimientoLista.html.twig', [
            'arMovimientoDetalles' => $arMovimientoDetalles,
            'form' => $form->createView()
        ]);
    }
}
