<?php

namespace App\Form\Type\RecursoHumano;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuConcepto;
use App\Entity\RecursoHumano\RhuEmpleado;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdicionalType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RhuAdicional::class,
        ]);
    }

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
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('conceptoRel',EntityType::class,[
                'class' => RhuConcepto::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('er')
                        ->where('er.adicional = 1')
                        ->orderBy('er.nombre','ASC');
                },'choice_label' => 'nombre',
                'required' => true,
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('vrValor', NumberType::class, ['required' => true])
            ->add('permanente',CheckboxType::class,['required' => false])
            ->add('aplicaDiaLaborado',CheckboxType::class,['required' => false])
            ->add('aplicaNomina',CheckboxType::class,['required' => false])
            ->add('aplicaPrima',CheckboxType::class,['required' => false])
            ->add('aplicaCesantia',CheckboxType::class,['required' => false])
            ->add('detalle',TextType::class,['required' => false,'attr' => ['placeholder' => 'Opcional']])
            ->add('estadoInactivoPeriodo',CheckboxType::class,['required' => false])
            ->add('fecha', DateType::class, ['required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('guardar',SubmitType::class,['label' => 'guardar','attr' => ['class' => 'btn btn-sm btn-primary']]);
    }
}