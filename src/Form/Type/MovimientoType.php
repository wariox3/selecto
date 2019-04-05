<?php


namespace App\Form\Type;


use App\Entity\Tercero;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovimientoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigoMovimientoPk',TextType::class, array('required' => true))
            ->add('fecha', DateType::class)
            ->add('terceroRel',EntityType::class,[
                'required' => true,
                'class' => Tercero::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.codigoTerceroPk', 'ASC');
                },
                'choice_label' => 'codigoTerceroPk',
            ])
            ->add('guardar', SubmitType::class, array('label' => 'Guardar' ));
    }
}