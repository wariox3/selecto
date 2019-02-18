<?php

namespace App\Controller;

use App\Entity\Caso;
use App\Entity\Cliente;
use App\Entity\Tarea;
use App\Entity\Usuario;
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

class TableroUsuarioController extends Controller {

    /**
     * @Route("/tablero/usuario", name="tablero_usuario")
     */
    public function lista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arrTareas = array();
        $arUsuarios = $em->getRepository(Usuario::class)->findBy(array('control' => 1));
        foreach ($arUsuarios as $arUsuario) {
            $arTareas = $em->getRepository(Tarea::class)->findBy(
                array('codigoUsuarioAsignaFk' => $arUsuario->getCodigoUsuarioPk(), 'estadoTerminado' => false),
                array('fechaRegistro' => 'ASC') , 5);
            foreach ($arTareas as $arTarea) {
                $arrTareas[] = array(
                    'usuario' => $arUsuario->getCodigoUsuarioPk(),
                    'id' => $arTarea->getCodigoTareaPk(),
                    'fechaRegistro' => $arTarea->getFechaRegistro(),
                    'caso' => $arTarea->getCodigoCasoFk(),
                    'descripcion' => $arTarea->getDescripcion());
            }

        }
        return $this->render('Tablero/usuario.html.twig', [
            'arUsuarios' => $arUsuarios,
            'arrTareas' => $arrTareas
        ]);
    }

}
