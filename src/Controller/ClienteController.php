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