<?php


namespace App\Form\Type\RecursoHumano;


use App\Entity\General\GenCiudad;
use App\Entity\General\GenEstadoCivil;
use App\Entity\General\GenIdentificacion;
use App\Entity\General\GenSexo;
use App\Entity\RecursoHumano\RhuBanco;
use App\Entity\RecursoHumano\RhuCargo;
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

class RhuEmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ciudadRel', EntityType::class, [
            'required' => true,
            'class' => GenCiudad::class,
            'query_builder' => function (EntityRepository $er) use ($options) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            ])
            ->add('ciudadExpedicionRel', EntityType::class, [
                'required' => true,
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('identificacionRel', EntityType::class, [
                'required' => true,
                'class' => GenIdentificacion::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('bancoRel', EntityType::class, [
                'class' => RhuBanco::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Banco:',
                'required' => true
            ])
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('nombre1', TextType::class, array('required' => true))
            ->add('nombre2', TextType::class, array('required' => false))
            ->add('apellido1', TextType::class, array('required' => true))
            ->add('apellido2', TextType::class, array('required' => false))
            ->add('sexoRel', EntityType::class, [
                'required' => true,
                'class' => GenSexo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Sexo:'
            ])
            ->add('estadoCivilRel', EntityType::class, [
                'required' => true,
                'class' => GenEstadoCivil::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('ec')
                        ->orderBy('ec.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Estado civil:'
            ])
            ->add('estatura', NumberType::class, ['required' => false, 'label' => 'Estatura:'])
            ->add('peso', NumberType::class, ['required' => false, 'label' => 'Peso:'])
            ->add('correo', EmailType::class, ['required' => false, 'label' => 'Correo:'])
            ->add('rhRel', EntityType::class, [
                'required' => true,
                'class' => RhuRh::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('ac')
                        ->orderBy('ac.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Rh:'
            ])
            ->add('fechaNacimiento', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('ciudadNacimientoRel', EntityType::class, [
                'required' => true,
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('cargoRel', EntityType::class, [
                'required' => true,
                'class' => RhuCargo::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])

            ->add('telefono', NumberType::class, ['required' => false, 'label' => 'Telefono:'])
            ->add('numeroIdentificacion', NumberType::class, ['required' => true, 'label' => 'numero identificacion:'])
            ->add('celular', NumberType::class, ['required' => false, 'label' => 'Celular:'])
            ->add('direccion', TextType::class, ['required' => false, 'label' => 'Direccion:'])
            ->add('tallaCamisa', TextType::class, ['required' => false, 'label' => ''])
            ->add('tallaPantalon', TextType::class, ['required' => false, 'label' => ''])
            ->add('tallaCalzado', TextType::class, ['required' => false, 'label' => ''])
            ->add('codigoCuentaTipoFk', ChoiceType::class, array('choices' => array('AHORRO' => 'S', 'CORRIENTE' => 'D', 'DAVIPLATA' => 'DP')))
            ->add('fechaExpedicionIdentificacion', DateType::class, array('widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('barrio', TextType::class, ['required' => false, 'label' => 'Barrio:'])
            ->add('cuenta', TextType::class, ['required' => false, 'label' => 'Cuenta:'])
            ->add('discapacidad', CheckboxType::class, ['required' => false, 'label' => 'Discapacidad'])
            ->add('carro', CheckboxType::class, ['required' => false, 'label' => 'Carro'])
            ->add('moto', CheckboxType::class, ['required' => false, 'label' => 'Moto'])
            ->add('padreFamilia', CheckboxType::class, ['required' => false, 'label' => 'Padre familia'])
            ->add('cabezaHogar', CheckboxType::class, ['required' => false, 'label' => 'Cabeza hogar'])
            ->add('guardar', SubmitType::class, ['attr' => ['class' => 'btn btn-sm btn-primary']]);
    }
}