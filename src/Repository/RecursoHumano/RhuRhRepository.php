<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuRh;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuRhRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuRh::class);
    }

}