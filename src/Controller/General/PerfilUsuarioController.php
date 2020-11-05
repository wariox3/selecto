<?php

namespace App\Controller\General;

use App\Entity\Empresa;
use App\Entity\Usuario;
use App\Entity\UsuarioEmpresa;
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
            if ($request->request->get('OpCambiar')) {
                $codigo = $request->request->get('OpCambiar');
                $arUsuarioEmpresa = $em->getRepository(UsuarioEmpresa::class)->find($codigo);
                if($arUsuarioEmpresa) {
                    $arUsuario = $em->getRepository(Usuario::class)->find($arUsuarioEmpresa->getCodigoUsuarioFk());
                    $arUsuario->setEmpresaRel($em->getReference(Empresa::class, $arUsuarioEmpresa->getCodigoEmpresaFk()));
                    $em->persist($arUsuario);
                    $em->flush();
                    return $this->redirect($this->generateUrl('perfil_ususario'));
                }
            }
        }
        $arUsuarioEmpresas = $em->getRepository(UsuarioEmpresa::class)->findBy(['codigoUsuarioFk' => $this->getUser()->getUsername()]);
        return $this->render('general/perfilusuario/nuevo.html.twig', [
            'arUsuarioEmpresas' => $arUsuarioEmpresas,
            'arEmpresa' => $arEmpresa,
            'form' => $form->createView()
        ]);
    }
}