<?php

namespace App\Controller\Inventario\Utilidad;

use App\Entity\Inventario\InvContrato;
use App\Entity\Inventario\InvDocumento;
use App\Entity\Inventario\InvItem;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Entity\Inventario\InvTercero;
use App\Form\Type\Inventario\MovimientoType;
use App\Formatos\Compra;
use App\Formatos\Entrada;
use App\Formatos\Factura1;
use App\Formatos\Salida;
use App\Utilidades\Mensajes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class GenerarFacturaController extends Controller
{
    /**
     * @Route("/utilidad/generarfactura", name="utilidad_generar_factura")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('cboTerceroRel', EntityType::class, $em->getRepository(InvTercero::class)->llenarCombo())
            ->add('btnGenerarTodo', SubmitType::class, ['label' => 'Generar todo', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $arTercero = $form->get('cboTerceroRel')->getData();
                if ($arTercero) {
                    $session->set('filtroContratoTercero', $arTercero->getCodigoTerceroPk());
                } else {
                    $session->set('filtroContratoTercero', null);
                }
            }
            if ($form->get('btnGenerarTodo')->isClicked()) {
                $em->getRepository(InvContrato::class)->generarFactura($this->getUser()->getCodigoEmpresaFk());
            }
        }
        $arContratos = $paginator->paginate($em->getRepository(InvContrato::class)->listaGenerarFactura($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 100);
        return $this->render('Inventario/Utilidad/generarFactura.html.twig', [
            'arContratos' => $arContratos,
            'form' => $form->createView()
        ]);
    }

}


