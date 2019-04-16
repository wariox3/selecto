<?php

namespace App\Repository;

use App\Entity\CuentaCobrarTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class CuentaCobrarTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CuentaCobrarTipo::class);
    }

}