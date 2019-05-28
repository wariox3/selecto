<?php

namespace App\Controller\RecursoHumano\Movimiento\Nomina;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Form\Type\RecursoHumano\AdicionalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdicionalController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/recursoHumano/movimiento/adicional/lista", name="recursoHumano_adicional_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('cboEmpleadoRel', EntityType::class, $em->getRepository(RhuEmpleado::class)->llenarCombo($this->getUser()->getCodigoEmpresaFk()))
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuAdicionalFechaDesde') ? date_create($session->get('filtroRhuAdicionalFechaDesde')) : null])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ', 'required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'data' => $session->get('filtroRhuAdicionalFechahasta') ? date_create($session->get('filtroRhuAdicionalFechahasta')) : null])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuAdicionalFechaDesde', $form->get('fechaDesde')->getData() ? $form->get('fechaDesde')->getData()->format('Y-m-d') : null);
                $session->set('filtroRhuAdicionalFechaHasta', $form->get('fechaHasta')->getData() ? $form->get('fechaHasta')->getData()->format('Y-m-d') : null);
                $arEmpleado = $form->get('cboEmpleadoRel')->getData();
                if ($arEmpleado) {
                    $session->set('filtroRhuAdicionalEmpleado', $arEmpleado->getCodigoEmpleadoPk());
                } else {
                    $session->set('filtroRhuAdicionalEmpleado', null);
                }
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arRhuEmpleado = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuAdicional::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('recursoHumano_adicional_lista'));
            }
        }
        $arAdicionales = $paginator->paginate($em->getRepository(RhuAdicional::class)->lista($this->getUser()->getCodigoEmpresaFk()), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/Movimiento/Nomina/Adicional/lista.html.twig', [
            'arAdicionales' => $arAdicionales,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/recursoHumano/movimiento/adicional/nuevo/{id}", name="recursoHumano_adicional_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arAdicional = new RhuAdicional();
        if ($id != 0) {
            $arAdicional = $em->getRepository(RhuAdicional::class)->find($id);
        } else {
            $arAdicional->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
        }
        $form = $this->createForm(AdicionalType::class, $arAdicional);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arAdicional = $form->getData();
                $arAdicional->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                $em->persist($arAdicional);
                $em->flush();
                return $this->redirect($this->generateUrl('recursoHumano_adicional_detalle', ['id' => $arAdicional->getCodigoAdicionalPk()]));

            }
        }
        return $this->render('recursoHumano/Movimiento/Nomina/Adicional/nuevo.html.twig', [
            'arAdicional' => $arAdicional,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/recursoHumano/movimiento/adicional/detalle/{id}", name="recursoHumano_adicional_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arAdicional = $em->getRepository(RhuAdicional::class)->find($id);
        return $this->render('recursoHumano/Movimiento/Nomina/Adicional/detalle.html.twig', [
            'arAdicional' => $arAdicional
        ]);

    }
}