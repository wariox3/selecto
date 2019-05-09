<?php


namespace App\Form\Type\RecursoHumano;

use App\Entity\General\GenCiudad;
use App\Entity\General\GenEstadoCivil;
use App\Entity\General\GenIdentificacion;
use App\Entity\General\GenSexo;
use App\Entity\RecursoHumano\RhuBanco;
use App\Entity\RecursoHumano\RhuCargo;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuRh;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RhuContratoType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('cargoDescripcion',TextType::class,['required' => false])
            ->add('fechaDesde', DateType::class, ['required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('fechaHasta', DateType::class, ['required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('salarioIntegral',CheckboxType::class,['required' => false, 'label' => 'Salario integral'])
            ->add('auxilioTransporte',CheckboxType::class,['required' => false, 'label' => 'Auxilio transporte'])
            ->add('tiempo', ChoiceType::class, ['choices' => ['TIEMPO COMPLETO' => '', 'MEDIO TIEMPO' => '1', 'SABATINO' => '0'], 'required' => false])
            ->add('tipoSalario', ChoiceType::class, ['choices' => ['VARIABLE' => '0', 'FIJO' => '1'], 'required' => false])
            ->add('vrSalario',NumberType::class,['required' => true])
            ->add('ciudadLaboraRel', EntityType::class, [
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ])
            ->add('ciudadContratoRel', EntityType::class, [
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ])
            ->add('cargoRel', EntityType::class, [
                'class' => RhuCargo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ])
            ->add('grupoRel', EntityType::class, [
                'class' => RhuGrupo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary']]);


    }
}