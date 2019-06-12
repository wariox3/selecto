<?php


namespace App\Form\Type\Compra;


use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgresoTipo;
use App\Entity\General\GenCuenta;
use App\Entity\General\GenTercero;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class EgresoType extends AbstractType
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
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('cuentaRel', EntityType::class, [
                'required' => true,
                'class' => GenCuenta::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.cuenta', 'ASC')
                        ->where("c.codigoEmpresaFk = '". $options['data']->getCodigoEmpresaFk() ."'");
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('fechaPago', DateType::class, array('required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}