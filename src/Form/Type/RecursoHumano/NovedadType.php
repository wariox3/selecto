<?php

namespace App\Form\Type\RecursoHumano;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuConcepto;
use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuNovedad;
use App\Entity\RecursoHumano\RhuNovedadTipo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NovedadType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RhuNovedad::class,
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
            ])
            ->add('novedadTipoRel',EntityType::class,[
                'class' => RhuNovedadTipo::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('nt')
                        ->orderBy('nt.nombre','ASC');
                },'choice_label' => 'nombre',
                'required' => true,
            ])
            ->add('vrIbcPropuesto', NumberType::class, ['required' => true])
            ->add('vrPropuesto', NumberType::class, ['required' => true])
            ->add('prorroga',CheckboxType::class,['required' => false])
            ->add('transcripcion',CheckboxType::class,['required' => false])
            ->add('comentarios',TextareaType::class,['required' => false,'attr' => ['placeholder' => 'Opcional']])
            ->add('fechaDesde', DateType::class, ['required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('fechaHasta', DateType::class, ['required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('guardar',SubmitType::class,['label' => 'guardar','attr' => ['class' => 'btn btn-sm btn-primary']]);
    }
}