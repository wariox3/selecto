<?php

namespace App\Controller\General\Proceso;

use App\Entity\General\GenRespuestaFacturaElectronica;
use App\Entity\General\GenTercero;
use App\Entity\Inventario\InvMovimiento;
use App\Form\Type\Inventario\TerceroType;
use App\Formatos\Factura;
use App\Utilidades\FacturaElectronica;
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
            ->add('btnEnviar', SubmitType::class, ['label' => 'Enviar', 'attr' => ['class' => 'btn btn-sm btn-default']])
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
            if ($form->get('btnEnviar')->isClicked()) {
                $arr = $request->request->get('ChkSeleccionar');
                $this->getDoctrine()->getRepository(InvMovimiento::class)->facturaElectronica($arr, $empresa);
            }
            if ($request->request->get('OpCorreo')) {
                $codigo = $request->request->get('OpCorreo');
                $this->getDoctrine()->getRepository(InvMovimiento::class)->correoElectronica($codigo, $empresa);
            }
        }
        $arMovimientos = $paginator->paginate($em->getRepository(InvMovimiento::class)->facturaElectronicaPendiente($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('General/Proceso/FacturaElectronica/lista.html.twig', [
            'arMovimientos' => $arMovimientos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/general/proceso/facturaelectronica/respuesta/ver/{entidad}/{codigo}", name="general_proceso_facturaelectronica_respuesta_ver")
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
        $arRespuestas = $paginator->paginate($em->getRepository(GenRespuestaFacturaElectronica::class)->lista($entidad, $codigo), $request->query->getInt('page', 1), 1000);
        return $this->render('General/Proceso/FacturaElectronica/verError.html.twig', [
            'arRespuestas'      =>  $arRespuestas,
            'form' => $form->createView()
        ]);
    }
}