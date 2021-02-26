<?php

namespace App\Controller\General;

use App\Entity\Empresa;
use App\Entity\Usuario;
use App\Entity\UsuarioEmpresa;
use App\Form\Type\Empresa\EmpresaType;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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


    /**
     * @Route("/perfil/usuario/clave/{hash}", name="perfil_usuario_nuevo_clave")
     */
    public function cambiarClave(Request $request, $hash)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->verificarUsuario($hash);
        $respuesta = '';
        if ($id != 0) {
            $arUsuario = $em->getRepository(Usuario::class)->find($id);
        }
        $form = $this->createFormBuilder()
            ->add('txtNuevaClave', PasswordType::class, ['required' => true])
            ->add('txtConfirmacionClave', PasswordType::class, ['required' => true])
            ->add('btnActualizar', SubmitType::class, ['label' => 'Actualizar', 'attr' => ['class' => 'btn btn-sm btn-primary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('btnActualizar')->isClicked()) {
                $arUsuario = $em->getRepository(Usuario::class)->find($id);
                $claveNueva = $form->get('txtNuevaClave')->getData();
                $claveConfirmacion = $form->get('txtConfirmacionClave')->getData();
                if ($claveNueva == $claveConfirmacion) {
                    $arUsuario->setClave($claveNueva);
                    $em->persist($arUsuario);
                } else {
                    $respuesta = "Las claves ingresadas no coindicen";
                }
            }
            if ($respuesta != '') {
                Mensajes::error($respuesta);
            } else {
                $em->flush();
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        $arUsuario = $em->getRepository(Usuario::class)->find($id);
        return $this->render('general/perfilusuario/cambioClave.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function verificarUsuario($hash)
    {
        $em = $this->getDoctrine()->getManager();
        $id = 0;
        if ($hash != '0') {
            $arUsuarios = $em->getRepository(Usuario::class)->findAll();
            if (count($arUsuarios) > 0) {
                $hash = str_replace('&', '/', $hash);
                foreach ($arUsuarios as $arUsuario) {
                    if (password_verify($arUsuario->getUsername(), $hash)) {
                        $id = $arUsuario->getUsername();
                    }
                }
            }
        }
        return $id;
    }

}