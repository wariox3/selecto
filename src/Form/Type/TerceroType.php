<?php


namespace App\Form\Type;
use App\Entity\Ciudad;
use App\Entity\FormaPago;
use App\Entity\Identificacion;
use App\Entity\Regimen;
use App\Entity\TipoPersona;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TerceroType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ciudadRel', EntityType::class, [
                'required' => true,
                'class' => Ciudad::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('formaPagoRel', EntityType::class, [
                'required' => true,
                'class' => FormaPago::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('fp')
                        ->orderBy('fp.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('tipoPersonaRel',EntityType::class,[
                'required' => true,
                'class' => TipoPersona::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->orderBy('tp.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Tipo persona:'
            ])
            ->add('regimenRel',EntityType::class,[
                'required' => true,
                'class' => Regimen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Regimen:'
            ])
            ->add('identificacionRel',EntityType::class,[
                'required' => true,
                'class' => Identificacion::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'Identificacion:'
            ])
            ->add('numeroIdentificacion', TextType::class, array('required' => true))
            ->add('primerNombre', TextType::class, array('required' => false))
            ->add('segundoNombre', TextType::class, array('required' => false))
            ->add('primerApellido', TextType::class, array('required' => false))
            ->add('segundoApellido', TextType::class, array('required' => false))
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('direccion', TextType::class, array('required' => true))
            ->add('plazoPago', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('email', TextType::class, array('required' => true))
            ->add('celular', TextType::class, array('required' => false))
            ->add('cliente', CheckboxType::class, array('required' => false, 'label' => 'Cliente'))
            ->add('proveedor', CheckboxType::class, array('required' => false, 'label' => 'Proveedor'))
            ->add('retencionIva', CheckboxType::class, ['required' => false])
            ->add('retencionFuente', CheckboxType::class, ['required' => false])
            ->add('retencionFuenteSinBase', CheckboxType::class, ['required' => false])
            ->add('barrio', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('codigoPostal', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('cupoCompra', NumberType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('bloqueoCartera', CheckboxType::class, ['required' => false, 'label' => 'Bloqueo cartera'])
            ->add('codigoCIUU',TextType::class,['required' => false,'label' => 'CIUU:'])
            ->add('digitoVerificacion', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('correoFacturaElectronica', TextType::class, array('required' => true))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}