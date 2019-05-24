<?php


namespace App\Form\Type\Compra;


use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgresoTipo;
use App\Entity\General\GenCuenta;
use App\Entity\Inventario\InvTercero;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CompraType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            ->add('cuentaRel', EntityType::class, [
                'required' => true,
                'class' => GenCuenta::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.cuenta', 'ASC');
                },
                'choice_label' => 'cuenta',
            ])
            ->add('egresoTipoRel', EntityType::class, [
                'required' => true,
                'class' => ComEgresoTipo::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('rt')
                        ->orderBy('rt.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('fechaPago', DateType::class, array('required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}