<?php

namespace App\Repository\Compra;

use App\Entity\Compra\ComCuentaPagarTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class ComCuentaPagarTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComCuentaPagarTipo::class);
    }

}