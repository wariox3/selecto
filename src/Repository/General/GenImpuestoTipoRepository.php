<?php

namespace App\Repository\General;

use App\Entity\General\GenCiudad;
use App\Entity\General\GenImpuesto;
use App\Entity\General\GenImpuestoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class GenImpuestoTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenImpuestoTipo::class);
    }


}