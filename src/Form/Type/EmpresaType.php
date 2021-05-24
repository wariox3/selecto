<?php


namespace App\Form\Type;


use App\Entity\Ciudad;
use App\Entity\Regimen;
use App\Entity\Resolucion;
use App\Entity\TipoPersona;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EmpresaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ciudadRel', EntityType::class, [
                'class' => Ciudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Ciudad:'
                , 'required' => true])
            ->add('tipoPersonaRel', EntityType::class, [
                'class' => TipoPersona::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->orderBy('tp.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Tipo persona:'
                , 'required' => true])
            ->add('RegimenRel', EntityType::class, [
                'class' => Regimen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Regimen:'
                , 'required' => true])
            ->add('resolucionRel', EntityType::class, [
                'class' => Resolucion::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.numero', 'DESC')
                        ->where("r.codigoEmpresaFk = ". $options['data']->getCodigoEmpresaPk());
                },
                'choice_label' => 'numero',
                'label' => 'Resolucion:'
                , 'required' => true])
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('nit', TextType::class, array('required' => true))
            ->add('digitoVerificacion', NumberType::class, array('required' => true))
            ->add('direccion', TextType::class, array('required' => true))
            ->add('correo', TextType::class, array('required' => true))
            ->add('correoFacturaElectronica', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('suscriptor', TextType::class, array('required' => true))
            ->add('informacionPago', TextareaType::class, array('required' => false))
            ->add('matriculaMercantil', TextType::class, array('required' => true))
            ->add('formatoFactura', ChoiceType::class, array('choices' => array('FACTURA VENTA' => '0', 'CUENTA COBRO' => '1', 'FACTURA ELECTRONICA DE VENTA' => 2)))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}