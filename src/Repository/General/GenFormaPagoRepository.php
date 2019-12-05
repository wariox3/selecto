<?php

namespace App\Repository\General;

use App\Entity\General\GenFormaPago;
use App\Entity\General\GenPais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class GenFormaPagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenFormaPago::class);
    }

}