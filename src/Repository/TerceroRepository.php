<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\Tercero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class TerceroRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tercero::class);
    }

    public function lista()
    {
        $session =new Session();
        $querybuilder=$this->getEntityManager()->createQueryBuilder()->from(Tercero::class,'t' )
            ->select('t.codigoTerceroPk')
            ->addSelect('t.nombreCorto')
        ->addSelect('t.cliente')
        ->addSelect('t.proveedor');
        $querybuilder->orderBy("t.codigoTerceroPk", 'DESC');

        if ($session->get('filtroTerceroCodigo') !='')
        {
            $querybuilder->andWhere("t.codigoTerceroPk  ='{$session->get('filtroTerceroCodigo')}'");
        }

        if ($session->get('filtroTerceroNombreCorto')!='')
        {
            $querybuilder->andWhere("t.nombreCorto like '%{$session->get('filtroTerceroNombreCorto')}%'");
        }

        if ($session->get('filtroTerceroCliente')!='')
        {
            $querybuilder->andWhere("t.cliente like '%{$session->get('filtroTerceroCliente')}%'");
        }

        if ($session->get('filtroTerceroProveedor')!='')
        {
            $querybuilder->andWhere("t.proveedor like '%{$session->get('filtroTerceroProveedor')}%'");
        }
        return $querybuilder;

    }
}