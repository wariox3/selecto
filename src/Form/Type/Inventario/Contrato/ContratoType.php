<?php


namespace App\Form\Type\Inventario\Contrato;


use App\Entity\Inventario\InvTercero;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ContratoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();
        $builder
            ->add('terceroRel', EntityType::class, [
                'required' => true,
                'class' => InvTercero::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.nombreCorto', 'ASC');
                },
                'choice_label' => 'nombreCorto',
            ])
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}