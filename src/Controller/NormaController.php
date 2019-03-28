<?php

namespace App\Controller;


use App\Entity\Accion;
use App\Entity\Grupo;
use App\Entity\Matriz;
use App\Entity\Obligacion;
use App\Entity\Subgrupo;
use App\Entity\Vigencia;
use App\Entity\Norma;
use App\Form\Type\ObligacionType;
use App\Form\Type\NormaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;

class NormaController extends Controller
{

    /**
     * @Route("/admin/norma/nuevo/{id}", name="norma_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arNorma = new Norma();
        if ($id != 0) {
            $arNorma = $em->getRepository(Norma::class)->find($id);
        } else {
            $arNorma->setFecha(new \DateTime('now'));
        }
        $form = $this->createForm(NormaType::class, $arNorma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $nombre = $arNorma->getNormaTipoRel()->getNombre() . " " . $arNorma->getNumero() . " de " . $arNorma->getFecha()->format('Y-m-d');
                $arNorma->setNombre($nombre);
                $arNorma = $form->getData();
                $em->persist($arNorma);
                $em->flush();
                return $this->redirect($this->generateUrl('norma_detalle', array('id' => $arNorma->getCodigoNormaPk())));
            }
        }
        return $this->render('Norma/nuevo.html.twig', [
            'arNorma' => $arNorma,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/norma/lista", name="norma_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigo', NumberType::class, ['required' => false, 'data' => $session->get('filtroNormaCodigo')])
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaNombre')])
            ->add('descripcion', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaDescripcion')])
            ->add('estadoDerogado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])

            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroNormaEstadoDerogado', $form->get('estadoDerogado')->getData());
                $session->set('filtroNormaCodigo', $form->get('codigo')->getData());
                $session->set('filtroNormaNombre', $form->get('nombre')->getData());
                $session->set('filtroNormaDescripcion', $form->get('descripcion')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $this->get('UtilidadesModelo')->eliminar(Norma::class, $arrSeleccionados);
                return $this->redirect($this->generateUrl('norma_lista'));
            }
        }
        $arNormas = $paginator->paginate($em->getRepository(Norma::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('Norma/lista.html.twig', [
            'arNormas' => $arNormas,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/norma/detalle/{id}", name="norma_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $session = new Session();

        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arNorma = $em->getRepository(Norma::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('matrisRel', EntityType::class, $em->getRepository(Matriz::class)->llenarCombo(), ['data'  => $session->get('filtroMatriz')])
            ->add('grupoRel', EntityType::class, $em->getRepository(Grupo::class)->llenarCombo(), ['data'  => $session->get('filtroGrupo')])
            ->add('subGrupoRel', EntityType::class, $em->getRepository(Subgrupo::class)->llenarCombo(), ['data'  => $session->get('filtroSubGrupo')])
            ->add('accionRel', EntityType::class, $em->getRepository(Accion::class)->llenarCombo(), ['data'  => $session->get('filtroAccion')])
            ->add('vigencia', TextType::class, ['required' => false, 'data' => $session->get('filtroVigencia')])
            ->add('Obligacion', TextType::class, ['required' => false, 'data' => $session->get('filtroObligacion')])
            ->add('ObligacionVerificable', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroObligacionVerificable'), 'required' => false])
            ->add('ObligacionDerogado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroObligacionDerogado'), 'required' => false])
            ->add('btnFiltrarObligacion', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnFiltrarVigencia', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminarObligacion', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminarVigencia', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrarObligacion')->isClicked()) {
                $arGrupo = $form->get('grupoRel')->getData();
                $arMatris = $form->get('matrisRel')->getData();
                $arSubgrupo = $form->get('subGrupoRel')->getData();
                $arAccion = $form->get('accionRel')->getData();

                if($arGrupo) {
                    $session->set('filtroGrupo', $arGrupo->getCodigoGrupoPk());
                } else {
                    $session->set('filtroGrupo', null);
                }
                if($arMatris) {
                    $session->set('filtroMatriz', $arMatris->getCodigoMatrizPk());
                } else {
                    $session->set('filtroMatriz', null);
                }
                if($arSubgrupo) {
                    $session->set('filtroSubGrupo', $arSubgrupo->getCodigoSubGrupoPk());
                } else {
                    $session->set('filtroSubGrupo', null);
                }
                if($arAccion) {
                    $session->set('filtroAccion', $arAccion->getCodigoAccionPk());
                } else {
                    $session->set('filtroAccion', null);
                }
                $session->set('filtroObligacion', $form->get('Obligacion')->getData());
                $session->set('filtroObligacionVerificable', $form->get('ObligacionVerificable')->getData());
                $session->set('filtroObligacionDerogado', $form->get('ObligacionDerogado')->getData());
            }
            if ($form->get('btnFiltrarVigencia')->isClicked()) {
                $session->set('filtroVigencia', $form->get('vigencia')->getData());
            }
            if ($form->get('btnEliminarObligacion')->isClicked()) {
                $arrVigenciasSeleccionados = $request->request->get('ChkSeleccionarObligaciones');
                $this->get("UtilidadesModelo")->eliminar(Obligacion::class, $arrVigenciasSeleccionados);

            }
            if ($form->get('btnEliminarVigencia')->isClicked()) {
                $arrVigenciasSeleccionados = $request->request->get('ChkSeleccionarVigencias');
                $this->get("UtilidadesModelo")->eliminar(Vigencia::class, $arrVigenciasSeleccionados);

            }
            return $this->redirect($this->generateUrl('norma_detalle', ['id' => $id]));
        }
        $arObligaciones = $paginator->paginate($em->getRepository(Obligacion::class)->listaNorma($id), $request->query->getInt('Obligacion', 1), 30,
            array(
                'pageParameterName' => 'Obligacion',
                'sortFieldParameterName' => 'sortObligacion',
                'sortDirectionParameterName' => 'directionObligacion',
            )
        );
        $arVigencias = $paginator->paginate($em->getRepository(Vigencia::class)->listaNorma($id), $request->query->getInt('Vigencia', 1), 30,
            array(
                'pageParameterName' => 'Vigencia',
                'sortFieldParameterName' => 'sortVigencia',
                'sortDirectionParameterName' => 'directionVigencia',
            ));

        return $this->render('Norma/detalle.html.twig', [
            'form' => $form->createView(),
            'arNorma' => $arNorma,
            'arObligaciones' => $arObligaciones,
            'arVigencias' => $arVigencias
        ]);
    }

    /**
     * @Route("/admin/norma/obligacion/nuevo/{id}/{codigoNorma}", name="norma_obligacion_nuevo")
     */
    public function nuevoObligacion(Request $request, $id, $codigoNorma)
    {
        $em = $this->getDoctrine()->getManager();
        $arNorma = $em->getRepository(Norma::class)->find($codigoNorma);
        $arObligacion = new Obligacion();
        if ($id != 0) {
            $arObligacion = $em->getRepository(Obligacion::class)->find($id);
        } else {
            $arObligacion->setNormaRel($arNorma);
        }
        $form = $this->createForm(ObligacionType::class, $arObligacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arObligacion = $form->getData();
                $em->persist($arObligacion);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Norma/nuevoObligacion.html.twig', [
            'arObligacion' => $arObligacion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/norma/vigencia/nuevo/{id}/{codigoNorma}", name="norma_vigencia_nuevo")
     */
    public function nuevoVigencia(Request $request, $id, $codigoNorma)
    {
        $em = $this->getDoctrine()->getManager();
        $arNorma = $em->getRepository(Norma::class)->find($codigoNorma);
        $arVigencia = new Vigencia();
        if ($id != 0) {
            $arVigencia = $em->getRepository(Vigencia::class)->find($id);
        } else {
            $arVigencia->setNormaRel($arNorma);
        }
        $form = $this->createForm(VigenciaType::class, $arVigencia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arObligacion = $form->getData();
                $em->persist($arObligacion);
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('Norma/nuevoVigencia.html.twig', [
            'arVigencia' => $arVigencia,
            'form' => $form->createView()
        ]);
    }

}
