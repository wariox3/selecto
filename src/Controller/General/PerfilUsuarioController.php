<?php

namespace App\Controller\General;

use App\Entity\Empresa;
use App\Form\Type\Empresa\EmpresaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PerfilUsuarioController extends AbstractController
{
    /**
     * @Route("/perfil/usuario", name="perfil_ususario")
     */
    public function nuevo(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arEmpresa = $em->getRepository(Empresa::class)->find($this->getUser()->getCodigoEmpresaFk());
        $form = $this->createForm(EmpresaType::class, $arEmpresa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                $arEmpresa = $form->getData();
                $em->persist($arEmpresa);
                $em->flush();
                return $this->redirect($this->generateUrl('perfil_ususario'));
            }
        }
        return $this->render('General/PerfilUsuario/nuevo.html.twig', [
            '$arEmpresa' => $arEmpresa,
            'form' => $form->createView()
        ]);
    }
}