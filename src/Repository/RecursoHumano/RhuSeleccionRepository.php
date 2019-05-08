<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuSeleccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RhuSeleccionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuSeleccion::class);
    }
    public function camposPredeterminados(){
        $qb = $this-> _em->createQueryBuilder()
            ->from('App:RecursoHumano\RhuSeleccion','s')
            ->select('s');
        $query = $this->_em->createQuery($qb->getDQL());
        return $query->execute();
    }

}