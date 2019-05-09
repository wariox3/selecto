<?php


namespace App\Controller\RecursoHumano;


use App\Entity\General\GenCiudad;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Form\Type\RecursoHumano\RhuContratoType;
use App\Form\Type\RecursoHumano\RhuEmpleadoType;
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
     * @Route("/inventario/administracion/RecursoHumano/lista", name="RecursoHumano_empleado_lista")
     */
    public function lista(Request $request){
        $session = new Session();
        $em= $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoEmpleado', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuCodigoEmpleado')])
            ->add('numeroIdentificacion', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNumeroIdentificacion')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroRhuNombreCorto')])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroRhuCodigoEmpleado', $form->get('codigoEmpleado')->getData());
                $session->set('filtroRhuNumeroIdentificacion', $form->get('numeroIdentificacion')->getData());
                $session->set('filtroRhuNombreCorto', $form->get('nombreCorto')->getData());
            }
            if($form->get('btnEliminar')->isClicked()){
                $arRhuEmpleado= $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(RhuEmpleado::class, $arRhuEmpleado);
                return $this->redirect($this->generateUrl('RecursoHumano_empleado_lista'));
            }
        }
        $arEmpleados = $paginator->paginate($em->getRepository(RhuEmpleado::class)->lista(), $request->query->getInt('page', 1), 30);
        return $this->render('recursoHumano/empleado/lista.html.twig', [
            'arEmpleados' => $arEmpleados,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inventario/administracion/RecursoHumano/nuevo/{id}", name="RecursoHumano_empleado_nuevo")
     */
    public function nuevo(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arRhuEmpleado = new RhuEmpleado();
        if ($id != 0){
            $arRhuEmpleado = $em->getRepository(RhuEmpleado::class)->find($id);
        }else{

        }
        $form = $this->createForm(RhuEmpleadoType::class, $arRhuEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('guardar')->isClicked()) {
                $arEmpleadoBuscar = $em->getRepository(RhuEmpleado::class)->findOneBy(
                        [   'codigoIdentificacionFk' => $arRhuEmpleado->getIdentificacionRel()->getCodigoIdentificacionPk(),
                            'numeroIdentificacion' => $arRhuEmpleado->getNumeroIdentificacion()]);
                if ((!is_null($arRhuEmpleado->getCodigoEmpleadoPk()) &&
                        $arRhuEmpleado->getCodigoEmpleadoPk() == $arEmpleadoBuscar->getCodigoEmpleadoPk()) ||
                        is_null($arEmpleadoBuscar)) {
                    $arRhuEmpleado = $form->getData();
                    $em->persist($arRhuEmpleado);
                    $em->flush();
                    return $this->redirect($this->generateUrl('RecursoHumano_empleado_detalle', ['id' => $arRhuEmpleado->getCodigoEmpleadoPk()]));
                }else {
                    Mensajes::error('Ya existe un empleado con la identificación ingresada.');
                }
            }
        }
        return $this->render('recursoHumano/empleado/nuevo.html.twig', [
            'arRhuEmpleado' => $arRhuEmpleado,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/inventario/administracion/RecursoHumano/detalle/{id}", name="RecursoHumano_empleado_detalle")
     */
    public function detalle(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $arEmpleado = $em->getRepository(RhuEmpleado::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('RecursoHumano_detalle', ['id' => $id]));
        }
        return $this->render('recursoHumano/empleado/detalle.html.twig', [
            'form' => $form->createView(),
            'arEmpleado' => $arEmpleado,
        ]);
    }

    /**
     * @Route("/inventario/administracion/RecursoHumano/nuevo/{id}/{codigoEmpleado}", name="RecursoHumano_empleado_contrato_nuevo")
     */
    public function nuevoContrato(Request $request, $id, $codigoEmpleado)
    {
        $em = $this->getDoctrine()->getManager();
        $ar = $em->getRepository(RhuEmpleado::class)->find($id);
        $form = $this->createForm(RhuContratoType::class);
        $form->handleRequest($request);

        return $this->render('recursoHumano/empleado/contratoNuevo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}