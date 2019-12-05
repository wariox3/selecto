<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuContratoTipo;
use App\Entity\RecursoHumano\RhuEntidad;
use App\Entity\RecursoHumano\RhuEntidadTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuEntidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuEntidad::class);
    }
}