<?php

namespace App\Controller;

use App\Entity\Caso;
use App\Entity\Cliente;
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

class TableroCasoController extends Controller {

    /**
     * @Route("/tablero/caso", name="tablero_caso")
     */
    public function lista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arrSinAtender = $em->getRepository(Caso::class)->tableroSinAtender();
        $arrSinSolucionar = $em->getRepository(Caso::class)->tableroSinSolucionar();
        $arrCaso = array(
            'arrSinAtender' => $arrSinAtender,
            'arrSinSolucionar' => $arrSinSolucionar,);
        return $this->render('Tablero/caso.html.twig', [
            'arrCaso' => $arrCaso
        ]);
    }

}
