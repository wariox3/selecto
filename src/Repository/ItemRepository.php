<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class ItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Item::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.descripcion')
            ->addSelect('i.referencia')
            ->addSelect('i.cantidadExistencia')
            ->addSelect('i.porcentajeIva');
        $queryBuilder->orderBy("i.codigoItemPk", 'DESC');

        if ($session->get('filtroItemCodigo') != '') {
            $queryBuilder->andWhere("i.codigoItemPk  ='{$session->get('filtroItemCodigo')}'");
        }

        if ($session->get('filtroItemDescripcion') != '') {
            $queryBuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
        }
        return $queryBuilder;
    }
}