<?php


namespace App\Form\Type\Inventario;


use App\Entity\General\GenCiudad;
use App\Entity\General\GenFormaPago;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('formaPagoRel', EntityType::class, [
                'required' => true,
                'class' => GenFormaPago::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('fp')
                        ->orderBy('fp.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('numeroIdentificacion', TextType::class, array('required' => true))
            ->add('codigoIdentificacionFk', ChoiceType::class, array('choices' => array('Cedula' => 'CC', 'Nit' => 'NI', 'Tarjeta de Extranjeria' => 'TE', 'Cedula de Extranjeria' => 'CE', 'Pasaporte' => 'PE', 'Tipo Documento Extranjero' => 'TDE', 'Permiso Especial de Permacencia' => 'PE',)))
            ->add('primerNombre', TextType::class, array('required' => false))
            ->add('segundoNombre', TextType::class, array('required' => false))
            ->add('primerApellido', TextType::class, array('required' => false))
            ->add('segundoApellido', TextType::class, array('required' => false))
            ->add('direccion', TextType::class, array('required' => true))
            ->add('plazoPago', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('email', TextType::class, array('required' => false))
            ->add('celular', TextType::class, array('required' => false))
            ->add('cliente', CheckboxType::class, array('required' => false, 'label' => 'Cliente'))
            ->add('proveedor', CheckboxType::class, array('required' => false, 'label' => 'Proveedor'))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}