<?php


namespace App\Controller\RecursoHumano\Movimiento\Nomina;


use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuLiquidacion;
use App\Entity\RecursoHumano\RhuPago;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LiquidacionController extends Controller
{
    /**
     * @Route("/recursoHumano/movimiento/nomina/liquidacion/lista", name="recursoHumano_liquidacion_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $this->request = $request;
        $em = $this->getDoctrine()->getManager();
        $form=  $this->createFormBuilder()
            ->add('EmpleadoRel', EntityType::class, $em->getRepository(RhuEmpleado::class)->llenarCombo($this->getUser()->getCodigoEmpresaFk()))
            ->add('codigo', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuLiquidacionCodigo')])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaDesde') ? date_create($session->get('filtroInvInformeAsesorVentasFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaHasta') ? date_create($session->get('filtroInvInformeAsesorVentasFechaHasta')) : null])
            ->add('estadoAutorizado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('estadoAprobado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('estadoAnulado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $arEmpleado = $form->get('EmpleadoRel')->getData();
                $session->set('filtroRhuLiquidacionCodigo', $form->get('codigo')->getData());
                $session->set('filtroRhuLiquidacionFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuLiquidacionFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuLiquidacionEstadoAutorizado', $form->get('estadoAutorizado')->getData());
                $session->set('filtroRhuLiquidacionEstadoAprobado', $form->get('estadoAprobado')->getData());
                $session->set('filtroRhuLiquidacionEstadAnulado', $form->get('estadoAnulado')->getData());
                if ($arEmpleado) {
                    $session->set('filtroRhuLiquidacionEmpleado', $arEmpleado->getCodigoEmpleadoPk());
                } else {
                    $session->set('filtroRhuLiquidacionEmpleado', null);
                }
            }
        }
        $paginator = $this->get('knp_paginator');
        $arLiquidaciones = $paginator->paginate($em->getRepository(RhuLiquidacion::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/Movimiento/Nomina/Liquidacion/lista.html.twig', [
            'arLiquidaciones' => $arLiquidaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recursoHumano/movimiento/nomina/liquidacion/nuevo/{id}", name="recursoHumano_liquidacion_nuevo")
     */
    public function nuevo()
    {
        
    }

    /**
     * @Route("/recursoHumano/movimiento/nomina/liquidacion/detalle/{id}", name="recursoHumano_liquidacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arLiquidacion = $em->getRepository(RhuLiquidacion::class)->find($id);
        return $this->render('recursoHumano/Movimiento/Nomina/Liquidacion/detalle.html.twig',[
            'arLiquidacion' => $arLiquidacion
        ]);
    }
}