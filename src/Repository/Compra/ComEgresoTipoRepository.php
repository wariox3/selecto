<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgresoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ComEgresoTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComEgresoTipo::class);
    }


}