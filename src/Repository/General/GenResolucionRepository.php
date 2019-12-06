<?php

namespace App\Repository\General;

use App\Entity\General\GenBanco;
use App\Entity\General\GenResolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class GenResolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenResolucion::class);
    }

}