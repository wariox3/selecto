<?php


namespace App\Repository\General;


use App\Entity\General\GenIdentificacion;
use App\Entity\General\GenSexo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GenSexoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,GenSexo::class);
    }

}