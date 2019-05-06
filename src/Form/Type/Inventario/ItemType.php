<?php


namespace App\Form\Type\Inventario;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('codigoItemPk', TextareaType::class, array('required' => true))
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('referencia', TextType::class, array('required' => true))
            ->add('porcentajeIva', TextType::class, array('required' => true))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}