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

    public function lista($codigoItemPk ="", $descripcion="")
    {
        $session =new Session();
        $querybuilder=$this->getEntityManager()->createQueryBuilder()->from(Item::class,'i' )
            ->select('i.codigoItemPk')
            ->addSelect('i.descripcion');
        return $querybuilder;


    }
}