<?php

namespace App\Controller;
use App\Entity\Cliente;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\ClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;


class ClienteController extends  AbstractController
{

    /**
    * @Route("/admin/cliente/nuevo/{id}", name="cliente_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
     $em = $this->getDoctrine()->getManager();
        $arCliente = new Cliente();
        if ($id != 0 ){
            $arCliente = $em->getRepository(Cliente::class)->find($id);
        }
        $form = $this->createForm(ClienteType::class, $arCliente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $nombre = $arCliente->getNombreCorto();

                $arCliente->setNombreCorto($nombre);
                $arCliente = $form->getData();
                $em->persist($arCliente);
                $em->flush();
                return $this->redirect($this->generateUrl('cliente_lista'));
            }
        }
        return $this->render('Cliente/nuevo.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/cliente/lista", name="cliente_lista")
     */
    public function lista(Request $request,PaginatorInterface $paginator)
    {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $arClientes= $paginator->paginate($em->getRepository(Cliente::class)->lista(),$request->query->getInt('page', 1), 500);

        $form = $this->createFormBuilder()
            ->add( 'nombreCorto', TextType::class,['required' => false, 'data' => $session->get('filtroNombreCorto')])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);

        return $this->render('Cliente/lista.html.twig', [
            'arClientes' => $arClientes,
            'form'=>$form->createView()
        ]);
    }
}