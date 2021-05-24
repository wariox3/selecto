<?php

namespace App\Repository;

use App\Entity\MovimientoTipo;
use App\Entity\MovimientoTipoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MovimientoTipoEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoTipoEmpresa::class);
    }

}