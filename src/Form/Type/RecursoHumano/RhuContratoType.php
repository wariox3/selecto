<?php


namespace App\Form\Type\RecursoHumano;

use App\Entity\General\GenCiudad;
use App\Entity\General\GenEstadoCivil;
use App\Entity\General\GenIdentificacion;
use App\Entity\General\GenSexo;
use App\Entity\RecursoHumano\RhuBanco;
use App\Entity\RecursoHumano\RhuCargo;
use App\Entity\RecursoHumano\RhuCentroTrabajo;
use App\Entity\RecursoHumano\RhuClasificacionRiesgo;
use App\Entity\RecursoHumano\RhuContratoTipo;
use App\Entity\RecursoHumano\RhuEntidad;
use App\Entity\RecursoHumano\RhuGrupo;
use App\Entity\RecursoHumano\RhuPension;
use App\Entity\RecursoHumano\RhuRh;
use App\Entity\RecursoHumano\RhuSalud;
use App\Entity\RecursoHumano\RhuSucursal;
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
            ->add('contratoTipoRel', EntityType::class, [
                'class' => RhuContratoTipo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('clasificacionRiesgoRel', EntityType::class, [
                'class' => RhuClasificacionRiesgo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('cargoDescripcion',TextType::class,['required' => false])
            ->add('comentarioContrato',TextType::class,['required' => false])
            ->add('fechaDesde', DateType::class, ['required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('fechaHasta', DateType::class, ['required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date',]])
            ->add('vrSalario',NumberType::class,['required' => true])
            ->add('vrSalario',NumberType::class,['required' => true])
            ->add('vrAdicional',NumberType::class,['required' => true])
            ->add('vrAdicionalPrestacional',NumberType::class,['required' => true])
            ->add('salarioIntegral',CheckboxType::class,['required' => false, 'label' => 'Salario integral'])
            ->add('auxilioTransporte',CheckboxType::class,['required' => false, 'label' => 'Auxilio transporte'])
            ->add('tiempo', ChoiceType::class, ['choices' => ['TIEMPO COMPLETO' => 'TIEMPO COMPLETO', 'MEDIO TIEMPO' => 'MEDIO TIEMPO', 'SABATINO' => 'SABATINO'], 'required' => false])
            ->add('tipoSalario', ChoiceType::class, ['choices' => ['VARIABLE' => 'VARIABLE', 'FIJO' => 'FIJO'], 'required' => false])
            //->add('tipoSalud', ChoiceType::class, ['choices' => ['EMPLEADO' => 'EMPLEADO', 'EMPLEADOR' => 'FIJO'], 'required' => false])
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
            ->add('sucursalRel', EntityType::class, [
                'class' => RhuSucursal::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.estadoActivo = 1')
                        ->orderBy('s.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])

            ->add('entidadCajaRel', EntityType::class, [
                'class' => RhuEntidad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('entidadSaludRel', EntityType::class, [
                'class' => RhuEntidad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.eps = 1')
                        ->orderBy('s.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('entidadPensionRel', EntityType::class, [
                'class' => RhuEntidad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('r.pen = 1')
                        ->orderBy('s.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('saludRel', EntityType::class, [
                'class' => RhuSalud::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ])
            ->add('entidadCesantiaRel', EntityType::class, [
                'class' => RhuEntidad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.ces = 1')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ])
            ->add('pensionRel', EntityType::class, [
                'class' => RhuPension::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary']]);


    }
}