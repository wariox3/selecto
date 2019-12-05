<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmbargoPago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuEmbargoPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuEmbargoPago::class);
    }
}