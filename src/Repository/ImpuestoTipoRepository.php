<?php

namespace App\Repository;

use App\Entity\Ciudad;
use App\Entity\Impuesto;
use App\Entity\ImpuestoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class ImpuestoTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenImpuestoTipo::class);
    }


}