<?php

namespace App\Controller\RecursoHumano\Movimiento\Nomina;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuNovedad;
use App\Form\Type\RecursoHumano\NovedadType;
use App\Utilidades\Estandares;
use App\Utilidades\Mensajes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class NovedadController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/novedad/lista", name="recursoHumano_novedad_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('cboEmpleadoRel', EntityType::class, $em->getRepository(RhuEmpleado::class)->llenarCombo($this->getUser()->getCodigoEmpresaFk()))
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuNovedadFechaDesde') ? date_create($session->get('filtroRhuNovedadFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuNovedadFechahasta') ? date_create($session->get('filtroRhuNovedadFechahasta')) : null])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuNovedadFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuNovedadFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arEmpleado = $form->get('cboEmpleadoRel')->getData();
                if ($arEmpleado) {
                    $session->set('filtroRhuNovedadEmpleado', $arEmpleado->getCodigoEmpleadoPk());
                } else {
                    $session->set('filtroRhuNovedadEmpleado', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuNovedad::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('recursoHumano_novedad_lista'));
            }
        }
        $arNovedades = $paginator->paginate($em->getRepository(RhuNovedad::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/Movimiento/Nomina/Novedad/lista.html.twig', [
            'arNovedades' => $arNovedades,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/novedad/nuevo/{id}", name="recursoHumano_novedad_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arNovedad = new RhuNovedad();
        if ($id != 0) {
            $arNovedad = $em->getRepository(RhuNovedad::class)->find($id);
        } else {
            $arNovedad->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
            $arNovedad->setFechaDesde(new \DateTime('now'));
            $arNovedad->setFechaHasta(new \DateTime('now'));
        }
        $form = $this->createForm(NovedadType::class, $arNovedad);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arNovedad = $form->getData();
                if ($arNovedad->getEmpleadoRel()->getCodigoContratoFk()) {
                    $arContrato = $em->getRepository(RhuContrato::class)->find($arNovedad->getEmpleadoRel()->getCodigoContratoFk());
                } elseif ($arNovedad->getEmpleadoRel()->getCodigoContratoUltimoFk()) {
                    $arContrato = $em->getRepository(RhuContrato::class)->find($arNovedad->getEmpleadoRel()->getCodigoContratoUltimoFk());
                } else {
                    $arContrato = null;
                }
                $arNovedad->setContratoRel($arContrato);
                $arNovedad->setFecha(new \DateTime('now'));
                $arNovedad->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arNovedad);
                $em->flush();
                return $this->redirect($this->generateUrl('recursoHumano_novedad_detalle', ['id' => $arNovedad->getCodigoNovedadPk()]));
            }
        }
        return $this->render('recursoHumano/Movimiento/Nomina/Novedad/nuevo.html.twig', ['arNovedad' => $arNovedad,
            'form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("recursohumano/movimiento/nomina/novedad/detalle/{id}", name="recursoHumano_novedad_detalle")
     */
    public
    function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arNovedad = $em->getRepository(RhuNovedad::class)->find($id);
        return $this->render('recursoHumano/Movimiento/Nomina/Novedad/detalle.html.twig', [
            'arNovedad' => $arNovedad
        ]);
    }
}