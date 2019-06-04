<?php


namespace App\Controller\RecursoHumano\Movimiento\Nomina;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuPago;
use App\Entity\RecursoHumano\RhuPagoDetalle;
use App\Entity\RecursoHumano\RhuPagoTipo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PagosController extends  controller
{
    /**
     * @Route("/recursoHumano/movimiento/nomina/pago/lista", name="recursoHumano_pagos_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('EmpleadoRel', EntityType::class, $em->getRepository(RhuEmpleado::class)->llenarCombo($this->getUser()->getCodigoEmpresaFk()))
            ->add('codigo', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuProgramacionCodigoProgramacion')])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaDesde') ? date_create($session->get('filtroInvInformeAsesorVentasFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaHasta') ? date_create($session->get('filtroInvInformeAsesorVentasFechaHasta')) : null])
            ->add('TipoRel', EntityType::class, $em->getRepository(RhuPagoTipo::class)->llenarCombo())
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuPagoCodigo', $form->get('codigo')->getData());
                $session->set('filtroRhuPagoFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuPagoFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arEmpleado = $form->get('EmpleadoRel')->getData();
                $TipoRel = $form->get('TipoRel')->getData();
                if ($arEmpleado) {
                    $session->set('filtroRhuPagoEmpleado', $arEmpleado->getCodigoEmpleadoPk());
                } else {
                    $session->set('filtroRhuPagoEmpleado', null);
                }
                if ($TipoRel) {
                    $session->set('filtroRhuPagoTipo', $TipoRel->getCodigoPagoTipoPk());
                } else {
                    $session->set('filtroRhuPagoTipo', null);
                }
            }
        }
        $arPagos = $paginator->paginate($em->getRepository(RhuPago::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/pago/lista.html.twig', [
            'arPagos' => $arPagos,
            'form' => $form->createView()
        ]);
    }


    /**
    * @Route("/recursoHumano/movimiento/nomina/pago/detalle/{id}", name="recursoHumano_pagos_detalle")
    */
    public function detalle(Request $request, $id)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arPago = $em->find(RhuPago::class, $id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('btnImprimir')->isClicked()){
                $objFormato = new Pago();
                $objFormato->Generar($em, $id);
            }
        }
        $arPagoDetalles = $paginator->paginate($em->getRepository(RhuPagoDetalle::class)->lista($id), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/pago/detalle.html.twig', [
            'arPago' => $arPago,
            'arPagoDetalles' => $arPagoDetalles,
            'form' => $form->createView()
        ]);
    }
}