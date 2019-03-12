<?php

namespace App\Form\Type;

use App\Entity\Accion;
use App\Entity\Entidad;
use App\Entity\Grupo;
use App\Entity\Jurisdiccion;
use App\Entity\NormaTipo;
use App\Entity\Subgrupo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticuloType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('accionRel', EntityType::class, array(
                'class' => Accion::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('obligacion', TextareaType::class, array('required' => true))
            ->add('verificable', CheckboxType::class, ['required' => false,'label' => 'Verificable'])
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
