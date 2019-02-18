<?php
/**
 * Created by PhpStorm.
 * User: Juan felipe Mesa Ocampo
 */

namespace App\Forms\Type;


namespace App\Forms\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FormTypeSolicitud extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaEntrega', DateType::class)
            ->add('vrInversion', NumberType::class)
//            Botón Guardar
            ->add('btnGuardar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnGuardar',
                    'name' => '_btnGuardar'
                ), 'label' => 'GUARDAR'
            ));
    }
}