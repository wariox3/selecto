<?php

namespace App\Repository\General;

use App\Entity\General\GenCiudad;
use App\Entity\General\GenImpuesto;
use App\Entity\General\GenImpuestoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class GenImpuestoTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenImpuestoTipo::class);
    }


}