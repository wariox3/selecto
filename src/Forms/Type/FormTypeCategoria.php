<?php
/**
 * Created by Alejandro Vera Carrasquilla.
 * User: Avera
 * Date: 24/11/17
 * Time: 03:30 PM
 */

namespace App\Forms\Type;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class FormTypeCategoria extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('nombre', TextType::class,array(
                'attr' => array(
                    'id' => '_nombre',
                    'name' => '_nombre'
                )
            ))

            ->add ('descripcion', TextType::class,array(
                'attr' => array(
                    'id' => '_descripcion',
                    'name' => '_descripcion'
                )
            ))
            //            Botón Guardar
            ->add ('btnGuardar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnGuardar',
                    'name' => '_btnGuardar'
                ), 'label' => 'GUARDAR'
            ))
        ;
    }
}