<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuContratoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuContratoTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuContratoTipo::class);
    }

}