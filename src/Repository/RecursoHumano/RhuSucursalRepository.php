<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuSucursal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuSucursalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuSucursal::class);
    }
}