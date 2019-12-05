<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuRh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuRhRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuRh::class);
    }

}