<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuCredito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuCreditoPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuCredito::class);
    }

}