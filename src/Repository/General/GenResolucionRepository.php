<?php

namespace App\Repository\General;

use App\Entity\General\GenBanco;
use App\Entity\General\GenResolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class GenResolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenResolucion::class);
    }

    public function lista()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(GenResolucion::class, 'r')
            ->select('r.codigoResolucionPk')
            ->addSelect('r.numero')
            ->addSelect('r.fecha')
            ->addSelect('r.fechaDesde')
            ->addSelect('r.fechaHasta')
            ->addSelect('r.prefijo')
            ->addSelect('r.numeroDesde')
            ->addSelect('r.numeroHasta')
            ->addSelect('r.llaveTecnica');

        $queryBuilder->addOrderBy('r.codigoResolucionPk', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }
}