<?php

namespace App\Form\Type;

use App\Entity\Cliente;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre_corto', EntityType::class, array(
                'class' => Cliente::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('nt')
                        ->orderBy('nt.nombre_corto', 'ASC');
                },
                'choice_label' => 'nombre corto',
                'required' => true,
            ))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));;
    }
}