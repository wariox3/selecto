<?php

namespace App\Repository;

use App\Entity\RespuestaFacturaElectronica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RespuestaFacturaElectronicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RespuestaFacturaElectronica::class);
    }

    public function lista($modelo, $codigo)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RespuestaFacturaElectronica::class, 'r')
            ->select('r.codigoRespuestaFacturaElectronicaPk')
            ->addSelect('r.fecha')
            ->addSelect('r.statusCode')
            ->addSelect('r.errorMessage')
            ->addSelect('r.errorReason')
            ->where("r.codigoModeloFk = '" . $modelo . "'")
            ->andWhere('r.codigoDocumento = ' . $codigo)
            ->orderBy('r.fecha', 'DESC')
        ->setMaxResults(5);
        $i = 0;
        $arRespuestas = $queryBuilder->getQuery()->getResult();
        foreach ($arRespuestas as $arRespuesta) {
            $array = json_decode($arRespuesta['errorReason']);
            $arRespuestas[$i]['errorReason'] = $array;
            $i++;
        }
        return $arRespuestas;
    }

}