<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TerceroType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('numeroIdentificacion', TextType::class, array('required'=> true))
            ->add('digitoVerificacion', TextType::class, array('required' => true))
            ->add('primerNombre', TextType::class, array('required'=> true))
            ->add('segundoNombre', TextType::class, array('required'=> false))
            ->add('primerApellido', TextType::class, array('required'=> true))
            ->add('segundoApellido', TextType::class, array('required'=> false))
            ->add('direccion', TextType::class, array('required'=> true))
            ->add('telefono', TextType::class, array('required'=> true))
            ->add('email', TextType::class, array('required' => true))
            ->add('celular', TextType::class, array('required'=> true))
            ->add('cliente', CheckboxType::class, array('required' => false, 'label' => 'cliente'))
            ->add('proveedor', CheckboxType::class, array('required' => false, 'label' => 'proveedor'))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}