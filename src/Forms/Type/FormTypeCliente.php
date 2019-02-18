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


class FormTypeCliente extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('nit', TextType::class,array(
                'attr' => array(
                    'id' => '_nit',
                    'name' => '_nit'
                )
            ))

            ->add ('razonSocial', TextType::class,array(
                'attr' => array(
                    'id' => '_razonSocial',
                    'name' => '_razonSocial'
                )
            ))
            ->add ('nombreComercial', TextType::class,array(
                'attr' => array(
                    'id' => '_nombreComercial',
                    'name' => '_nombreComercial'
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