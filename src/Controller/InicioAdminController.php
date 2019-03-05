<?php

namespace App\Controller;

use App\Entity\Llamada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class InicioAdminController extends Controller
{


    /**
     * @Route("/admin", name="inicio_admin")
     */

    public function inicioAction(Request $request)
    {
        // en index pagina con datos generales de la app
        return $this->render('Inicio/inicioAdmin.html.twig', [

        ]);
    }

}