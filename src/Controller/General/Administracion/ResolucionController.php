<?php


namespace App\Controller\General\Administracion;


use App\Entity\General\GenResolucion;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResolucionController extends  AbstractController
{
    /**
     * @Route("/general/administracion/resolucion/lista", name="resolucion_lista")
     */
    public function lista(Request $request, PaginatorInterface $paginator )
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->setMethod('GET')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $raw['filtros'] = $this->getFiltros($form);
            }
            if ($form->get('btnEliminar')->isClicked()) {
                //$arrSeleccionados = $request->request->get('ChkSeleccionar');
                $arrSeleccionados = $request->query->get('ChkSeleccionar');
                $em->getRepository(GenResolucion::class)->eliminar($arrSeleccionados);
                return $this->redirect($this->generateUrl(''));
            }
        }
        $arResoluciones = $paginator->paginate($em->getRepository(GenResolucion::class)->lista(), $request->query->getInt('page', 1), 30);

        return $this->render('General/Administracion/Resolucion/lista.html.twig', [
            'arResoluciones' => $arResoluciones,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/general/administracion/resolucion/nuevo/{id}", name="resolucion_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arResolucion = new GenResolucion();
        if ($id != 0) {
            $arResolucion = $em->getRepository(GenResolucion::class)->find($id);
            if (!$arResolucion) {
                return $this->redirect($this->generateUrl('recursohumano_administracion_nomina_embargojuzgado_lista'));
            }
        }
        $form = $this->createForm(ResolucionType::class, $arResolucion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arResolucion = $form->getData();
                $em->persist($arResolucion);
                $em->flush();
                return $this->redirect($this->generateUrl('recursohumano_administracion_nomina_embargojuzgado_detalle', array('id' => $arResolucion->getCodigoEmbargoJusgadoPK())));
            }
        }
        return $this->render('recursohumano/administracion/nomina/juzgado/nuevo.html.twig', [
            'arEmbargoJusgado' => $arResolucion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/general/administracion/resolucion/detalle/{id}", name="resolucion_detalle")
     */
    public function detalle(Request $request, PaginatorInterface $paginator,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $arResolucion = $em->getRepository(GenResolucion::class)->find($id);
        return $this->render('General/Administracion/Resolucion/detalle.html.twig', [
            'arResolucion' => $arResolucion,
        ]);

    }

    public function getFiltros($form)
    {
        $filtro = [
        ];
        
        return $filtro;
    }
}