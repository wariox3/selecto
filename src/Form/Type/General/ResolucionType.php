<?php


namespace App\Form\Type\General;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ResolucionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', TextType::class, array('required' => true))
            ->add('prefijo', TextType::class, array('required' => false))
            ->add('numeroDesde', TextType::class, array('required' => true))
            ->add('numeroHasta', TextType::class, array('required' => true))
            ->add('claveTecnica', TextType::class, array('required' => true))
            ->add('pin', TextType::class, array('required' => true))
            ->add('ambiente', TextType::class, array('required' => true))
            ->add('setPruebas', TextType::class, array('required' => true))
            ->add('fecha', DateType::class, ['label' => 'Fecha: ',  'required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('fechaDesde', DateType::class, ['label' => 'Fecha desde: ',  'required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('fechaHasta', DateType::class, ['label' => 'Fecha hasta: ',  'required' => true, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('prueba', CheckboxType::class, array('required' => false))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));


    }
}