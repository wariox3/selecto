<?php

namespace App\Controller;



use App\Entity\LlamadaCategoria;
use App\Forms\Type\FormTypeUsuario;
use App\Forms\Type\FormTypeCliente;
use App\Forms\Type\FormTypeCategoria;
use App\Forms\Type\FormTypeModulo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Usuario;
use App\Entity\Cliente;
use App\Entity\Modulo;
use Symfony\Component\HttpFoundation\Request;






class AdminController extends Controller
{

    /** usuarios */

    /**
     * @Route("/admin/usuario/nuevo/{codigoUsuarioPk}", requirements={"codigoUsuarioPk":"\d+"}, name="registrarUsuario")
     */

    public function nuevoUsuario(Request $request, $codigoUsuarioPk = null)
    {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $user = $this->getUser(); // trae el usuario actual
        if($codigoUsuarioPk != null){ // valida si viene un parametro (idLlamada) para editar

            $arUsuario = $this->getDoctrine()->getManager()->getRepository('App:Usuario')->find($codigoUsuarioPk);//consulta la Usuario a editar

            if(!$arUsuario){

                throw $this->createNotFoundException("No Existe ese Usuario");

            } else {
                /** acá instancias form tipo Usuario */
                $form = $this->createForm(FormTypeUsuario::class, $arUsuario); //create form
                $form->handleRequest($request);

                /** fin instancia form */

                if ($form->isSubmitted() && $form->isValid()) { // se valida el submit del form
                    $arUsuario->setCodigoRol(1);
                    $em->flush();
                    return $this->redirect($this->generateUrl('listaUsuario'));
                }

                return $this->render('Admin/editarUsuario.html.twig', [
                    'usuarios' => $arUsuario,
                    'form' => $form->createView()
                ]);
            }
        } else { // si no viene un parametro se instancia el form vacio para crear Usuario

            $arUsuario = new Usuario(); //instance class
            $form = $this->createForm(FormTypeUsuario::class, $arUsuario);
             //create form
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($arUsuario);
                $em->flush();
                return $this->redirect($this->generateUrl('listaUsuario'));
            }

            return $this->render('Admin/crearUsuario.html.twig',
                array(
                    'form' => $form->createView(),

            ));
        }

    }

    /**
     * @Route("/admin/usuario/lista", name="listaUsuario")
     */

    public function listaUsuario(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $arUsuarios = $em->getRepository('App:Usuario')->findAll(); // consulta todas las llamdas por fecha descendente
        // en index pagina con datos generales de la app
        return $this->render('Admin/listaUsuario.html.twig', [
            'usuarios' => $arUsuarios,
        ]);
    }
    /** end usuarios */


    /** clientes */

    /**
     * @Route("/admin/cliente/nuevo/{codigoClientePk}", requirements={"codigoClientePk":"\d+"}, name="registrarCliente")
     */

    public function nuevoCliente(Request $request, $codigoClientePk = null)
    {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        if($codigoClientePk != null){ // valida si viene un parametro (idCliente) para editar

            $arCliente = $this->getDoctrine()->getManager()->getRepository('App:Cliente')->find($codigoClientePk);//consulta la Usuario a editar

            if(!$arCliente){

                throw $this->createNotFoundException("No Existe ese Cliente");

            } else {
                /** acá instancias form tipo Cliente */
                $form = $this->createForm(FormTypeCliente::class, $arCliente); //create form
                $form->handleRequest($request);

                /** fin instancia form */

                if ($form->isSubmitted() && $form->isValid()) { // se valida el submit del form

                    $em->flush();
                    $url = $this->generateUrl('listaCliente');
                    return $this->redirect($url);
                }

                return $this->render('Admin/editarUsuario.html.twig', [
                    'clientes' => $arCliente,
                    'form' => $form->createView()
                ]);
            }
        } else { // si no viene un parametro se instancia el form vacio para crear Usuario

            $arCliente= new Cliente(); //instance class
            $form = $this->createForm(FormTypeCliente::class, $arCliente);
            //create form
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($arCliente);
                $em->flush();
                return $this->redirect($this->generateUrl('listaCliente'));
            }

            return $this->render('Admin/crearCliente.html.twig',
                array(
                    'form' => $form->createView(),

                ));
        }

    }




    /**
     * @Route("/admin/cliente/lista", name="listaCliente")
     */

    public function listaCliente(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $arClientes = $em->getRepository('App:Cliente')->findAll(); // consulta todas las llamdas por fecha descendente
        // en index pagina con datos generales de la app
        return $this->render('Admin/listaCliente.html.twig', [
            'clientes' => $arClientes,
        ]);
    }

   /** end clientes */


   /** categorias */

    /**
     * @Route("/admin/categoria/nuevo/{codigoCategoriaPk}", requirements={"codigoCategoriaPk":"\d+"}, name="registrarCategoria")
     */

    public function nuevoCategoria(Request $request, $codigoCategoriaPk = null)
    {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        if($codigoCategoriaPk != null){ // valida si viene un parametro (idLlamada) para editar

            $arCategoria= $this->getDoctrine()->getManager()->getRepository('App:LlamadaCategoria')->find($codigoCategoriaPk);//consulta la Usuario a editar

            if(!$arCategoria){

                throw $this->createNotFoundException("No Existe esa Categoria");

            } else {
                /** acá instancias form tipo Usuario */
                $form = $this->createForm(FormTypeCategoria::class, $arCategoria); //create form
                $form->handleRequest($request);

                /** fin instancia form */

                if ($form->isSubmitted() && $form->isValid()) { // se valida el submit del form
                    $em->flush();
                    return $this->redirect($this->generateUrl('listaCategoria'));
                }

                return $this->render('Admin/editarUsuario.html.twig', [
                    'categorias' => $arCategoria,
                    'form' => $form->createView()
                ]);
            }
        } else { // si no viene un parametro se instancia el form vacio para crear Usuario

            $arCategoria = new LlamadaCategoria(); //instance class
            $form = $this->createForm(FormTypeCategoria::class, $arCategoria);
            //create form
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($arCategoria);
                $em->flush();
                return $this->redirect($this->generateUrl('listaCategoria'));
            }

            return $this->render('Admin/crearCategoria.html.twig',
                array(
                    'form' => $form->createView(),

                ));
        }

    }



    /**
     * @Route("/admin/categoria/lista", name="listaCategoria")
     */
    public function listaCategoria(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $arCategorias = $em->getRepository('App:LlamadaCategoria')->findAll(); // consulta todas las llamdas por fecha descendente
        // en index pagina con datos generales de la app
        return $this->render('Admin/listaCategoria.html.twig', [
            'categorias' => $arCategorias,
        ]);
    }
   /** end categorias */




   /** modulo */


    /**
     * @Route("/admin/modulo/nuevo/{codigoModulo}", requirements={"codigoModulo":"\d+"}, name="registrarModulo")
     */
    public function nuevo(Request $request, $codigoModulo = null) {
        $em = $this->getDoctrine()->getManager(); // instancia el entity manager
        $user = $this->getUser(); // trae el usuario actual
        $arModulo= new Modulo(); //instance class
        if($codigoModulo) {
            $arModulo= $em->getRepository('App:Modulo')->find($codigoModulo);
        }
        $form = $this->createForm(FormTypeModulo::class, $arModulo); //create form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($arModulo);
            $em->flush();
            return $this->redirect($this->generateUrl('listaModulo'));
        }

        return $this->render('Admin/crearModulo.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }



    /**
     * @Route("/admin/modulo/lista", name="listaModulo")
     */
    public function listaModulo(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $arModulos = $em->getRepository('App:Modulo')->findAll(); // consulta todas las llamdas por fecha descendente
        // en index pagina con datos generales de la app
        return $this->render('Admin/listaModulo.html.twig', [
            'modulos' => $arModulos,
        ]);
    }

   /** end modulo*/

}
