<?php


namespace App\Form\Type;

use App\Entity\Impuesto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('impuestoRetencionRel', EntityType::class, [
                'class' => Impuesto::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where("i.codigoImpuestoTipoFk = 'R'")
                        ->orderBy('i.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Retencion:'
                , 'required' => true])
            ->add('impuestoIvaVentaRel', EntityType::class, [
                'class' => Impuesto::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where("i.codigoImpuestoTipoFk = 'I'")
                        ->orderBy('i.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Iva:'
                , 'required' => true])
            ->add('nombre', TextType::class, array('required' => true))
            ->add('codigo', TextType::class, array('required' => true))
            ->add('referencia', TextType::class, array('required' => false))
            ->add('vrPrecio', NumberType::class, array('required' => true))
            ->add('afectaInventario', CheckboxType::class, array('required' => false))
            ->add('producto', CheckboxType::class, array('required' => false))
            ->add('servicio', CheckboxType::class, array('required' => false))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}