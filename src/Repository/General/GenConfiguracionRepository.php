<?php

namespace App\Repository\General;

use App\Entity\General\GenBanco;
use App\Entity\General\GenConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class GenConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenConfiguracion::class);
    }

    public function formato($codigoEmpresa) {
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(GenConfiguracion::class, 'c')
            ->select('c.codigoConfiguracionPk')
            ->addSelect('c.formatoFactura')
            ->where("c.codigoConfiguracionPk = {$codigoEmpresa}");
        $arConfiguracion = $queryBuilder->getQuery()->getResult();
        return $arConfiguracion[0];
    }

    public function generarFacturaMasiva($codigoEmpresa) {
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(GenConfiguracion::class, 'c')
            ->select('c.codigoConfiguracionPk')
            ->addSelect('c.codigoItemInteresMora')
            ->addSelect('c.generaInteresMora')
            ->addSelect('c.porcentajeInteresMora')
            ->where("c.codigoConfiguracionPk = {$codigoEmpresa}");
        $arConfiguracion = $queryBuilder->getQuery()->getResult();
        return $arConfiguracion[0];
    }
}