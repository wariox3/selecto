<?php


namespace App\Form\Type\Empresa;


use App\Entity\General\GenCiudad;
use App\Entity\General\GenRegimen;
use App\Entity\General\GenResolucion;
use App\Entity\General\GenTipoPersona;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'class' => GenCiudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Ciudad:'
                , 'required' => true])
            ->add('tipoPersonaRel', EntityType::class, [
                'class' => GenTipoPersona::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('tp')
                        ->orderBy('tp.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Tipo persona:'
                , 'required' => true])
            ->add('RegimenRel', EntityType::class, [
                'class' => GenRegimen::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.nombre', 'DESC');
                },
                'choice_label' => 'nombre',
                'label' => 'Regimen:'
                , 'required' => true])
            ->add('resolucionRel', EntityType::class, [
                'class' => GenResolucion::class,
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
            ->add('telefono', TextType::class, array('required' => true))
            ->add('formatoFactura', TextType::class, array('required' => true))
            ->add('informacionCuentaPago', TextType::class, array('required' => true))
            ->add('matriculaMercantil', TextType::class, array('required' => true))

            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}