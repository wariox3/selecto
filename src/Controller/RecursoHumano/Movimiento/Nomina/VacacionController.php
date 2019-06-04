<?php

namespace App\Controller\RecursoHumano\Movimiento\Nomina;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuNovedad;
use App\Entity\RecursoHumano\RhuVacacion;
use App\Form\Type\RecursoHumano\NovedadType;
use App\Form\Type\RecursoHumano\VacacionType;
use App\Utilidades\Estandares;
use App\Utilidades\Mensajes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class VacacionController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/vacacion/lista", name="recursoHumano_vacacion_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('cboEmpleadoRel', EntityType::class, $em->getRepository(RhuEmpleado::class)->llenarCombo($this->getUser()->getCodigoEmpresaFk()))
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuVacacionFechaDesde') ? date_create($session->get('filtroRhuVacacionFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuVacacionFechaHasta') ? date_create($session->get('filtroRhuVacacionFechaHasta')) : null])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuVacacionFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuVacacionFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arEmpleado = $form->get('cboEmpleadoRel')->getData();
                if ($arEmpleado) {
                    $session->set('filtroRhuVacacionEmpleado', $arEmpleado->getCodigoEmpleadoPk());
                } else {
                    $session->set('filtroRhuVacacionEmpleado', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuVacacion::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('recursoHumano_vacacion_lista'));
            }
        }
        $arVacaciones = $paginator->paginate($em->getRepository(RhuVacacion::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/Movimiento/Nomina/Vacaciones/lista.html.twig', [
            'arVacaciones' => $arVacaciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/vacacion/nuevo/{id}", name="recursoHumano_vacacion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arVacacion = new RhuVacacion();
        if ($id != 0) {
            $arVacacion = $em->getRepository(RhuVacacion::class)->find($id);
        } else {
            $arVacacion->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
            $arVacacion->setFecha(new \DateTime('now'));
            $arVacacion->setFechaDesdeDisfrute(new \DateTime('now'));
            $arVacacion->setFechaHastaDisfrute(new \DateTime('now'));
            $arVacacion->setFechaInicioLabor(new \DateTime('now'));
        }
        $form = $this->createForm(VacacionType::class, $arVacacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                if ($arVacacion->getEmpleadoRel()->getCodigoContratoFk()) {
                    $arVacacion = $form->getData();
                    $arContrato = $em->getRepository(RhuContrato::class)->find($arVacacion->getEmpleadoRel()->getCodigoContratoFk());
                    $arVacacion->setContratoRel($arContrato);
                    $arVacacion->setGrupoRel($arContrato->getGrupoRel());
                    $arVacacion->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                    $em->persist($arVacacion);
                    $em->flush();
                    return $this->redirect($this->generateUrl('recursoHumano_vacacion_detalle', ['id' => $arVacacion->getCodigoVacacionPk()]));
                } else {
                    Mensajes::error('El empleado no tiene contratos activos en el sistema');
                }
            }
        }
        return $this->render('recursoHumano/Movimiento/Nomina/Vacaciones/nuevo.html.twig', [
            'arVacacion' => $arVacacion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/vacacion/detalle/{id}", name="recursoHumano_vacacion_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arVacacion = $em->getRepository(RhuVacacion::class)->find($id);
        return $this->render('recursoHumano/Movimiento/Nomina/Vacaciones/detalle.html.twig', [
            'arVacacion' => $arVacacion
        ]);
    }
}