<?php


namespace App\Form\Type\Inventario;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('impuestoRetencionRel', EntityType::class, [
                'class' => 'App\Entity\General\GenImpuesto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where("i.codigoImpuestoTipoFk = 'R'")
                        ->orderBy('i.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Retencion:'
                , 'required' => true])
            ->add('impuestoIvaVentaRel', EntityType::class, [
                'class' => 'App\Entity\General\GenImpuesto',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where("i.codigoImpuestoTipoFk = 'I'")
                        ->orderBy('i.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Iva:'
                , 'required' => true])
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('referencia', TextType::class, array('required' => true))
            ->add('vrPrecio', NumberType::class, array('required' => true))
            ->add('porcentajeIva', TextType::class, array('required' => true))
            ->add('afectaInventario', CheckboxType::class, array('required' => false))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}