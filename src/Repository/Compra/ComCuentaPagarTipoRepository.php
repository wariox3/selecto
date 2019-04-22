<?php

namespace App\Repository\Compra;

use App\Entity\Compra\ComCuentaPagarTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ComCuentaPagarTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComCuentaPagarTipo::class);
    }

}