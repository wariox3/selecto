<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuPagoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RhuPagoTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuPagoTipo::class);
    }

    public function camposPredeterminados(){
        return $this->_em->createQueryBuilder()->from(RhuPagoTipo::class,'pt')
            ->select('pt.codigoPagoTipoPk AS ID')
            ->addSelect('pt.nombre')
            ->where('pt.codigoPagoTipoPk IS NOT NULL');
    }

    public function llenarCombo()
    {
        $array = [
            'class' => RhuPagoTipo::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy('g.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        return $array;
    }
}