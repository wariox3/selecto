<?php


namespace App\Repository\General;


use App\Entity\General\GenEstadoCivil;
use App\Entity\General\GenSexo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GenEstadoCivilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,GenEstadoCivil::class);
    }

}