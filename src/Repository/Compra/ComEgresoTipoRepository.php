<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgresoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class ComEgresoTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComEgresoTipo::class);
    }


}