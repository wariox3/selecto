<?php


namespace App\Controller\RecursoHumano\Administracion;


use App\Entity\General\GenCiudad;
use App\Entity\RecursoHumano\RhuConfiguracion;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Form\Type\RecursoHumano\ContratoType;
use App\Form\Type\RecursoHumano\EmpleadoType;
use App\Repository\RecursoHumano\RhuEmpleadoRepository;
use App\Utilidades\Mensajes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class EmpleadoController extends Controller
{
    /**
     * @Route("/recursoHumano/administracion/empleado/lista", name="recursoHumano_empleado_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoEmpleado', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuEmpleadoCodigo')])
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuEmpleadoNumeroIdentificacion')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuEmpleadoNombreCorto')])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuEmpleadoCodigo', $form->get('codigoEmpleado')->getData());
                $session->set('filtroRhuEmpleadoNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
                $session->set('filtroRhuEmpleadoNombreCorto', $form->get('nombreCorto')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuEmpleado::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('recursoHumano_empleado_lista'));
            }
        }
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $arEmpleados = $paginator->paginate($em->getRepository(RhuEmpleado::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/empleado/lista.html.twig', [
            'arEmpleados' => $arEmpleados,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recursoHumano/administracion/empleado/nuevo/{id}", name="recursoHumano_empleado_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $arEmpleado = new RhuEmpleado();
        if ($id != 0) {
            $arEmpleado = $em->getRepository(RhuEmpleado::class)->find($id);
        }
        $form = $this->createForm(EmpleadoType::class, $arEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('guardar')->isClicked()) {
                $arEmpleadoBuscar = $em->getRepository(RhuEmpleado::class)->findOneBy(
                    ['codigoIdentificacionFk' => $arEmpleado->getIdentificacionRel()->getCodigoIdentificacionPk(),
                        'numeroIdentificacion' => $arEmpleado->getNumeroIdentificacion()]);
                if (is_null($arEmpleadoBuscar) || $id != 0) {
                    $arEmpleado = $form->getData();
                    $arEmpleado->setCodigoEmpresaFk($empresa);
                    $arEmpleado->setNombreCorto("{$form->get('nombre1')->getData()} {$form->get('nombre2')->getData()} {$form->get('apellido1')->getData()} {$form->get('apellido2')->getData()}");
                    $em->persist($arEmpleado);
                    $em->flush();
                    return $this->redirect($this->generateUrl('recursoHumano_empleado_detalle', ['id' => $arEmpleado->getCodigoEmpleadoPk()]));
                } else {
                    Mensajes::error('Ya existe un empleado con la identificación ingresada.');
                }
            }
        }
        return $this->render('recursoHumano/empleado/nuevo.html.twig', [
            'arEmpleado' => $arEmpleado,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/recursoHumano/administracion/empleado/detalle/{id}", name="recursoHumano_empleado_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $arEmpleado = $em->getRepository(RhuEmpleado::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('recursoHumano_detalle', ['id' => $id]));
        }
        $empresa = $this->getUser()->getCodigoEmpresaFk();

        $arContratos = $paginator->paginate($em->getRepository(RhuEmpleado::class)->listarContratos($id, $empresa), $request->query->getInt('page', 1), 30);

        return $this->render('recursoHumano/empleado/detalle.html.twig', [
            'form' => $form->createView(),
            'arEmpleado' => $arEmpleado,
            'arContratos' => $arContratos
        ]);
    }

    /**
     * @Route("/recursoHumano/administracion/empleado/nuevo/{id}/{codigoEmpleado}", name="recursoHumano_empleado_contrato_nuevo")
     */
    public function nuevoContrato(Request $request, $id, $codigoEmpleado)
    {
        /**
         * @var $arContrato RhuContrato
         * @var $arEmpleado RhuEmpleado
         */
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $editarContrato = false;
        $arConfiguracion = $em->find(RhuConfiguracion::class, 1);
        $arContrato = new RhuContrato();
        $arrContratosEmpleado = $em->getRepository(RhuContrato::class)->findBy(['codigoEmpleadoFk' => $codigoEmpleado, 'estadoTerminado' => 0]);
        if ($id != 0) {
            $arContrato = $em->getRepository(RhuContrato::class)->find($id);
            $editarContrato = true;
        } else {
            $arContrato->setVrSalario($arConfiguracion->getVrSalarioMinimo());
            $arContrato->setFecha(new \DateTime('now'));
            $arContrato->setFechaDesde(new \DateTime('now'));
            $arContrato->setFechaHasta(new \DateTime('now'));
        }
        $form = $this->createForm(ContratoType::class, $arContrato);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arEmpleado = $em->getRepository(RhuEmpleado::class)->find($codigoEmpleado);
                $arContrato = $form->getData();
                $arContrato->setEmpleadoRel($arEmpleado);
                $arContrato->setFecha(new \DateTime('now'));
                $arContrato->setCodigoEmpresaFk($empresa);
                $arContrato->setContratoClaseRel($arContrato->getContratoTipoRel()->getContratoClaseRel());
                $arContrato->setIndefinido($arContrato->getContratoTipoRel()->getContratoClaseRel()->getIndefinido());
                $arContrato->setFactorHorasDia($arContrato->getTiempoRel()->getFactorHorasDia());
                if ($id == 0) {
                    if ($arContrato->getVrSalario() <= ($arConfiguracion->getVrSalarioMinimo() * 2)) {
                        $arContrato->setAuxilioTransporte(true);
                    }
                    $arContrato->setFechaUltimoPago($arContrato->getFechaDesde());
                    $arContrato->setFechaUltimoPagoCesantias($arContrato->getFechaDesde());
                    $arContrato->setFechaUltimoPagoPrimas($arContrato->getFechaDesde());
                    $arContrato->setFechaUltimoPagoVacaciones($arContrato->getFechaDesde());
                }
                if ($arrContratosEmpleado && $editarContrato == false) {
                    Mensajes::error("No se puede registrar ya que el empleado ya cuenta con un contrato vigente, por favor terminé el contrato anterior");
                } else {
                    $em->persist($arContrato);
                    $em->flush();

                    $arEmpleado->setCodigoContratoFk($arContrato->getCodigoContratoPk());
                    $arEmpleado->setEstadoContrato(true);
                    $em->persist($arEmpleado);
                    $em->flush();

                    echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                }
            }

        }
        return $this->render('recursoHumano/empleado/contratoNuevo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}