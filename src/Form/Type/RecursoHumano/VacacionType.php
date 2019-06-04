<?php

namespace App\Form\Type\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuVacacion;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VacacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('empleadoRel', EntityType::class, [
                'required' => true,
                'class' => RhuEmpleado::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nombreCorto', 'ASC')
                        ->where("e.codigoEmpresaFk = '". $options['data']->getCodigoEmpresaFk() ."'");
                },
                'choice_label' => 'nombreCorto',
            ])
            ->add('fechaDesdeDisfrute', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('fechaHastaDisfrute', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('fechaInicioLabor', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('diasDisfrutados',TextType::class,['required' => true])
            ->add('diasPagados',TextType::class,['required' => true])
            ->add('comentarios',TextareaType::class,['required' => false])
            ->add('vrSalarioPromedioPropuesto',TextType::class,['required' => true])
            ->add('vrDisfrutePropuesto',TextType::class,['required' => true])
            ->add('vrSalarioPromedioPropuestoPagado',TextType::class,['required' => true])
            ->add('vrSaludPropuesto',TextType::class,['required' => true])
            ->add('vrPensionPropuesto',TextType::class,['required' => true])
            ->add('guardar',SubmitType::class,['attr' => ['class' => 'btn btn-sm btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RhuVacacion::class,
        ]);
    }
}
