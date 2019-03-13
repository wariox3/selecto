<?php

namespace App\Form\Type;

use App\Entity\Accion;
use App\Entity\Grupo;
use App\Entity\Matriz;
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

class ObligacionType extends AbstractType {

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
            ->add('grupoRel',EntityType::class,[
                'required' => true,
                'class' => Grupo::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.codigoGrupoPk', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('subgrupoRel',EntityType::class,[
                'required' => true,
                'class' => Subgrupo::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.codigoGrupoFk', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('matrizRel',EntityType::class,[
                'required' => true,
                'class' => Matriz::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.codigoMatrizPk', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
//           ->add('subgrupoRel',EntityType::class,[
//                'required' => true,
//                'class' => Subgrupo::class,
//                'query_builder' => function (EntityRepository $er) use ($options) {
//                    return $er->createQueryBuilder('s')
//                        ->orderBy('s.codigoGrupoFk', 'ASC')
//                        ->where("s.codigoGrupoFk='" . $options['data']->getNormaRel()->getCodigoGrupoFk() . "'");
//                },
//                'choice_label' => 'nombre',
//            ])
            ->add('obligacion', TextareaType::class, array('required' => true))
            ->add('verificable', CheckboxType::class, ['required' => false,'label' => 'Verificable'])
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
