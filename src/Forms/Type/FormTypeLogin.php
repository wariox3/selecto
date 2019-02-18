<?php

namespace App\Forms\Type;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormTypeLogin extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('usuario', TextType::class, array(
                'attr' => array(
                    'id' => '_username',
                    'name' => '_username'
                )
            ))
            ->add ('clave', TextType::class,array(
                'attr' => array(
                    'id' => '_password',
                    'name' => '_password'
                )
            ))
            ->add ('Entrar', SubmitType::class, array(
                'attr' => array(

                )
            ))
        ;
    }
}