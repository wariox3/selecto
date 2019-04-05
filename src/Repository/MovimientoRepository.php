<?php

namespace App\Repository;

use App\Entity\Movimiento;
use App\Entity\Tercero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class MovimientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movimiento::class);
    }

    public function lista()
    {
        $session = new Session();
        $querybuildermovimiento = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.fecha')
            ->addSelect('terceroRel.codigoTerceroPk as tercero')
            ->leftJoin("m.terceroRel", "terceroRel");

        $querybuildermovimiento->orderBy("m.codigoMovimientoPk", 'DESC');
        return $querybuildermovimiento;



//        $querybuildertercero->orderBy("i.codigoItemPk", 'DESC');

//        if ($session->get('filtroItemCodigo') !='')
//        {
//            $querybuilder->andWhere("i.codigoItemPk  ='{$session->get('filtroItemCodigo')}'");
//        }
//
//        if ($session->get('filtroItemDescripcion')!='')
//        {
//            $querybuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
//        }
//        r
    }
}