<?php


namespace App\Form\Type;


use App\Entity\Grupo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SubGrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigoSubgrupoPk', TextType::class, array('required' => true))
            ->add('nombre', TextType::class, array('required' => true))
            ->add('grupoRel',EntityType::class,[
                'required' => true,
                'class' => Grupo::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.codigoGrupoPk', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }
}