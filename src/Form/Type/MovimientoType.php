<?php


namespace App\Form\Type;


use App\Entity\CentroCosto;
use App\Entity\FormaPago;
use App\Entity\Tercero;
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
                'class' => Tercero::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.nombreCorto', 'ASC')
                        ->where("t.codigoEmpresaFk = '". $options['data']->getEmpresaRel()->getCodigoEmpresaPk() ."'");
                },
                'choice_label' => 'nombreCorto',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('centroCostoRel', EntityType::class, [
                'required' => true,
                'class' => CentroCosto::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('cc')
                        ->orderBy('cc.nombre', 'ASC')
                        ->where("cc.codigoEmpresaFk = '". $options['data']->getEmpresaRel()->getCodigoEmpresaPk() ."'");
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('formaPagoRel', EntityType::class, [
                'required' => true,
                'class' => FormaPago::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('fp')
                        ->orderBy('fp.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('plazoPago', TextType::class, array('required' => true))
            ->add('documentoSoporte', TextType::class, array('required' => false))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }
}