<?php


namespace App\Controller\RecursoHumano\Administracion;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuContratoMotivo;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuLiquidacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContratoController extends Controller
{
    /**
     * @Route("/recursoHumano/administracion/contrato/lista", name="recursoHumano_contrato_lista")
     */
    public function lista(Request $request){
        $session = new Session();
        $em= $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoContato', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuCodigoEmpleado')])
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('Grupo', EntityType::class, $em->getRepository(RhuGrupo::class)->llenarCombo())
            ->add('estado', ChoiceType::class, ['choices' => ['TODOS' => '', 'Activos' => '1', 'Inactivos' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if ($form->get('btnFiltrar')->isClicked()) {
               $session->set('filtroRhuContratoCodigoContato', $form->get('codigoContato')->getData());
               $session->set('filtroRhuContratoNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
               $session->set('filtroRhuContratoNombreCorto', $form->get('nombreCorto')->getData());
                $session->set('filtroRhuContratoEstado',   $form->get('estado')->getData());
                $arGrupo = $form->get('Grupo')->getData();

                if($arGrupo) {
                    $session->set('filtroRhuContratoGrupo', $arGrupo->getCodigoGrupoPk());
                } else {
                    $session->set('filtroRhuContratoGrupo', null);
                }

            }
            if($form->get('btnEliminar')->isClicked()){
                $arRhuContrato= $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuContrato::class, $arRhuContrato);
                return $this->redirect($this->generateUrl('RecursoHumano_empleado_lista'));
            }
        }
        $empresa = $this->getUser()->getCodigoEmpresaFk();

        $arRhuContratos = $paginator->paginate($em->getRepository(RhuContrato::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/contrato/lista.html.twig', [
            'arRhuContratos' => $arRhuContratos,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/RecursoHumano/administracion/contrato/detalle/{id}", name="recursoHumano_contrato_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arContrato = $em->getRepository(RhuContrato::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('RecursoHumano_contrato_detalle', ['id' => $id]));
        }
        return $this->render('recursoHumano/contrato/detalle.html.twig', [
            'form' => $form->createView(),
            'arContrato'=>$arContrato
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Route("recursoHumano/administracion/contrato/terminar/{id}", name="recursohumano_administracion_contrato_terminar")
     */
    public function terminar(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arContrato = $em->getRepository(RhuContrato::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('fechaTerminacion', DateType::class, array('label' => 'Terminacion', 'data' => new \DateTime('now')))
            ->add('terminacionContratoRel', EntityType::class, array(
                'class' => RhuContratoMotivo::class,
                'choice_label' => 'motivo',
            ))
            ->add('comentarioTerminacion', TextareaType::class, array('required' => false))
            ->add('btnGuardar', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dateFechaHasta = $form->get('fechaTerminacion')->getData();
            $codigoMotivoContrato = $form->get('terminacionContratoRel')->getData();
            $comentarioTerminacion = $form->get('comentarioTerminacion')->getData();
            if ($form->get('btnGuardar')->isClicked()) {
                /**
                 * @var $arContrato RhuContrato
                 */
                $arContrato->setFechaHasta($dateFechaHasta);
                $arContrato->setIndefinido(0);
                $arContrato->setEstadoTerminado(1);
                $arContrato->setContratoMotivoRel($codigoMotivoContrato);
                $arContrato->setComentarioTerminacion($comentarioTerminacion);
                $em->persist($arContrato);
                /**
                 * @var $arEmpleado RhuEmpleado
                 */
                $arEmpleado = $em->getRepository(RhuEmpleado::class)->find($arContrato->getCodigoEmpleadoFk());
                $arEmpleado->setCodigoClasificacionRiesgoFk(NULL);
                $arEmpleado->setCodigoCargoFk(NULL);
                $arEmpleado->setEstadoContrato(0);
                $arEmpleado->setCodigoContratoFk(NULL);
                $arEmpleado->setCodigoContratoUltimoFk($id);

                //Generar liquidacion
//                if ($arContrato->getContratoTipoRel()->getCodigoContratoClaseFk() != 'APR' && $arContrato->getContratoTipoRel()->getCodigoContratoClaseFk() != 'PRA') {
//                    $arLiquidacion = new RhuLiquidacion();
//                    $arLiquidacion->setFecha(new \DateTime('now'));
//                    $arLiquidacion->setEmpleadoRel($arContrato->getEmpleadoRel());
//                    $arLiquidacion->setContratoRel($arContrato);
//                    $arLiquidacion->setMotivoTerminacionRel($codigoMotivoContrato);
//                    if ($arContrato->getFechaUltimoPagoCesantias() > $arContrato->getFechaDesde()) {
//                        $arLiquidacion->setFechaDesde($arContrato->getFechaUltimoPagoCesantias());
//                    } else {
//                        $arLiquidacion->setFechaDesde($arContrato->getFechaDesde());
//                    }
//                    $arLiquidacion->setFechaHasta($arContrato->getFechaHasta());
//                    $arLiquidacion->setLiquidarCesantias(1);
//                    $arLiquidacion->setLiquidarPrima(1);
//                    $arLiquidacion->setLiquidarVacaciones(1);
//                    if ($arContrato->getSalarioIntegral() == 1) {
//                        $arLiquidacion->setLiquidarCesantias(0);
//                        $arLiquidacion->setLiquidarPrima(0);
//                    }
//                    //Para clientes que manejan porcentajes en la liquidacion
//                    $arLiquidacion->setPorcentajeIbp(100);
//                    $arConfiguracion = $em->getRepository(RhuConfiguracion::class)->find(1);
//                    if ($arConfiguracion->getGeneraPorcentajeLiquidacion()) {
//                        if ($arContrato->getCodigoSalarioTipoFk() == 2) {
//                            if ($arLiquidacion->getCodigoContratoMotivoFk() != 'SJC' && $arLiquidacion->getCodigoContratoMotivoFk() != 'CJC') {
//                                $intDiasLaborados = $em->getRepository(RhuLiquidacion::class)->diasPrestaciones($arContrato->getFechaDesde(), $arContrato->getFechaHasta());
//                                $arParametrosPrestacion = $em->getRepository(RhuParametroPrestacion::class)->findBy(array('tipo' => 'LIQ'));
//                                foreach ($arParametrosPrestacion as $arParametroPrestacion) {
//                                    if ($intDiasLaborados >= $arParametroPrestacion->getDiaDesde() && $intDiasLaborados <= $arParametroPrestacion->getDiaHasta()) {
//                                        if ($arParametroPrestacion->getOrigen() == 'SAL') {
//                                            $arLiquidacion->setLiquidarSalario(1);
//                                        } else {
//                                            $arLiquidacion->setPorcentajeIbp($arParametroPrestacion->getPorcentaje());
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                    $em->persist($arLiquidacion);
//                }

                $em->persist($arEmpleado);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('recursoHumano/contrato/terminar.html.twig', [
            'arContrato' => $arContrato,
            'form' => $form->createView()
        ]);
    }
}