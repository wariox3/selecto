<?php


namespace App\Form\Type\Inventario;


use App\Entity\General\GenFormaPago;
use App\Entity\General\GenTercero;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovimientoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('terceroRel', EntityType::class, [
                'required' => true,
                'class' => GenTercero::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.nombreCorto', 'ASC')
                        ->where("t.codigoEmpresaFk = '". $options['data']->getCodigoEmpresaFk() ."'");
                },
                'choice_label' => 'nombreCorto',
            ])
            ->add('formaPagoRel', EntityType::class, [
                'required' => true,
                'class' => GenFormaPago::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('fp')
                        ->orderBy('fp.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('plazoPago', TextType::class, array('required' => true))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}