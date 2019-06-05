<?php


namespace App\Controller\RecursoHumano\Movimiento\Nomina;


use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuLiquidacion;
use App\Entity\RecursoHumano\RhuPago;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
            ->add('codigo', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuProgramacionCodigoProgramacion')])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaDesde') ? date_create($session->get('filtroInvInformeAsesorVentasFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroInvInformeAsesorVentasFechaHasta') ? date_create($session->get('filtroInvInformeAsesorVentasFechaHasta')) : null])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->getForm();
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
    public function detalle()
    {
        
    }
}