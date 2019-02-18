<?php
/**
 * Created by PhpStorm.
 * User: Juan felipe Mesa Ocampo
 */

namespace App\Forms\Type;


namespace App\Forms\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class FormTypeImplementacion extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clienteRel', EntityType::class, array(
                'class' => 'App:Cliente',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombreComercial', 'ASC');
                },
                'choice_label' => 'nombreComercial',
                'required' => true))
            ->add('descripcion', TextareaType::class, array('required' => false))
            ->add('btnGuardar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnGuardar',
                    'name' => '_btnGuardar'
                ), 'label' => 'GUARDAR'
            ));
    }
}