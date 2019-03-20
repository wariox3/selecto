<?php

namespace App\Controller;


use App\Entity\Obligacion;
use App\Entity\Vigencia;
use App\Entity\Norma;
use App\Form\Type\ObligacionType;
use App\Form\Type\NormaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use function PHPSTORM_META\type;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $arNormas = $paginator->paginate($em->getRepository(Norma::class)->lista(), $request->query->getInt('page', 1), 500);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroNormaEstadoDerogado', $form->get('estadoDerogado')->getData());
                $session->set('filtroNormaCodigo', $form->get('codigo')->getData());
                $session->set('filtroNormaNombre', $form->get('nombre')->getData());
                $session->set('filtroNormaDescripcion', $form->get('descripcion')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(Norma::class)->eliminar($arrSeleccionados);
                return $this->redirect($this->generateUrl('norma_lista'));
            }
        }
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
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();
        $arNorma = $em->getRepository(Norma::class)->find($id);
        $form = $this->createFormBuilder()
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('norma_detalle', ['id' => $id]));
        }
        $arObligaciones = $paginator->paginate($em->getRepository(Obligacion::class)->listaNorma($id), $request->query->getInt('page', 1), 500);
        $arVigencias = $paginator->paginate($em->getRepository(Vigencia::class)->listaNorma($id), $request->query->getInt('page', 1), 500);
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
