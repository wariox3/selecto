<?php

namespace App\Controller;

use App\Entity\Caso;
use App\Entity\Cliente;
use App\Entity\Tarea;
use App\Forms\Type\FormTypeCaso;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Llamada;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\SwiftmailerBundle;

class TableroLlamadaController extends Controller {

    /**
     * @Route("/tablero/llamada", name="tablero_llamada")
     */
    public function lista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arrSinAtender = $em->getRepository(Llamada::class)->tableroSinAtender();
        $arrSinSolucionar = $em->getRepository(Llamada::class)->tableroSinSolucionar();
        $arrLlamada = array(
            'arrSinAtender' => $arrSinAtender,
            'arrSinSolucionar' => $arrSinSolucionar);
        return $this->render('Tablero/llamada.html.twig', [
            'arrLlamada' => $arrLlamada
        ]);
    }

}
