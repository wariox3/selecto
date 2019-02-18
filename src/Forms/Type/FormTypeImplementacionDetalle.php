<?php

namespace App\Forms\Type;


namespace App\Forms\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FormTypeImplementacionDetalle extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('implementacionTemaRel', EntityType::class, array(
                'class' => 'App:ImplementacionTema',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('it')
                        ->orderBy('it.codigoImplementacionGrupoFK', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true))
            ->add("orden", IntegerType::class)
            ->add("fechaCapacitacion", DateType::class, array('required' => false))
            ->add('btnGuardar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnGuardar',
                    'name' => '_btnGuardar'
                ), 'label' => 'GUARDAR'
            ));
    }
}