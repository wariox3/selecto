<?php
/**
 * Created by Juan David Marulanda V.
 * User: @ju4nr3v0l
 * appSoga developers Team.
 */

namespace App\Forms\Type;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class FormTypeTarea extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add('tareaTipoRel', EntityType::class, array(
                'class' => 'App:TareaTipo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false
            ))
            ->add('codigoUsuarioAsignaFk', EntityType::class, array(
                'class' => 'App:Usuario',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombres', 'ASC');
                },
                'choice_label' => function ($er) {
                    $nombreCompleto = $er->getNombres() . " " . $er->getApellidos();
                    return $nombreCompleto;
                },
                'required' => false
            ))
            ->add('descripcion', TextareaType::class, array(
                'attr' => array(
                    'id' => '_descripcion',
                    'name' => '_descripcion',
                    'class' => 'form-control',
                    'required' => 'false'
                )
            ))
            ->add('comentario', TextareaType::class, array(
                'attr' => array(
                    'id' => '_comentario',
                    'name' => '_comentario',
                    'class' => 'form-control',
                    'required' => false
                )
            ))
            ->add('caso', TextType::class, array(
                'attr' => array(),
                'label' => 'Caso (Código del caso registrado en REOS)',
                'required' => false
            ))

	        ->add('prioridadRel', EntityType::class, array(
		        'class' => 'App:Prioridad',
		        'query_builder' => function (EntityRepository $er) {
			        return $er->createQueryBuilder('p')
			                  ->orderBy('p.nombre', 'ASC');},
		        'choice_label' => 'nombre',
		        'required' => true))
//            Botón Guardar
            ->add('btnGuardar', SubmitType::class, array(
                'attr' => array(
                    'id' => '_btnGuardar',
                    'name' => '_btnGuardar'
                ), 'label' => 'GUARDAR'
            ));
    }

    public function getBlockPrefix()
    {
        return 'form';
    }

}