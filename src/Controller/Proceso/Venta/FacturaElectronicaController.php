<?php

namespace App\Controller\Proceso\Venta;

use App\Entity\RespuestaFacturaElectronica;
use App\Entity\Movimiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class FacturaElectronicaController extends Controller
{
    /**
     * @Route("/proceso/venta/facturaelectronica/lista", name="proceso_venta_facturaelectronica_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('btnEnviar', SubmitType::class, ['label' => 'Enviar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
            }
            if ($form->get('btnEnviar')->isClicked()) {
                $arr = $request->request->get('ChkSeleccionar');
                $this->getDoctrine()->getRepository(Movimiento::class)->facturaElectronica($arr, $empresa);
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(Movimiento::class)->facturaElectronicaPendiente($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('proceso/venta/facturaelectronica/lista.html.twig', [
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/proceso/venta/facturaelectronica/log/{entidad}/{codigo}", name="proceso_venta_facturaelectronica_log")
     */
    public function ver(Request $request, $entidad, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        $arRespuestas = $paginator->paginate($em->getRepository(RespuestaFacturaElectronica::class)->lista($entidad, $codigo), $request->query->getInt('page', 1), 1000);
        return $this->render('proceso/venta/facturaelectronica/verError.html.twig', [
            'arRespuestas'      =>  $arRespuestas,
            'form' => $form->createView()
        ]);
    }
}