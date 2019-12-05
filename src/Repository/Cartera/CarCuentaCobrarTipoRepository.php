<?php

namespace App\Repository\Cartera;

use App\Entity\Cartera\CarCuentaCobrarTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class CarCuentaCobrarTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarCuentaCobrarTipo::class);
    }
}