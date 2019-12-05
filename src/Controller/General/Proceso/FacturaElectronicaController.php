<?php

namespace App\Controller\General\Proceso;

use App\Entity\General\GenTercero;
use App\Entity\Inventario\InvMovimiento;
use App\Form\Type\Inventario\TerceroType;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class FacturaElectronicaController extends Controller
{
    /**
     * @Route("/general/proceso/facturaelectronica/lista", name="general_proceso_facturaelectronica_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
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
                $this->get("UtilidadesModelo")->eliminar(GenTercero::class, $arItems);
                return $this->redirect($this->generateUrl('tercero_lista'));
            }
        }
        $arTerceros = $paginator->paginate($em->getRepository(GenTercero::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        $arMovimientos = $paginator->paginate($em->getRepository(InvMovimiento::class)->lista($documento, $empresa), $request->query->getInt('page', 1), 30);
        return $this->render('Inventario/Administracion/Tercero/lista.html.twig', [
            'arTerceros' => $arTerceros,
            'form' => $form->createView()
        ]);
    }
}