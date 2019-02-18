<?php

namespace App\Controller;

use App\Entity\Caso;
use App\Entity\Cliente;
use App\Entity\Error;
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

class TableroErrorController extends Controller {

    /**
     * @Route("/tablero/error", name="tablero_error")
     */
    public function lista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arrSinAtender = $em->getRepository(Error::class)->tableroSinAtender();
        $arrError = array(
            'arrSinAtender' => $arrSinAtender);
        return $this->render('Tablero/error.html.twig', [
            'arrError' => $arrError
        ]);
    }

}
