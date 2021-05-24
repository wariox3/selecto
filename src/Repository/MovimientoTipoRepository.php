<?php

namespace App\Repository;

use App\Entity\MovimientoTipo;
use App\Entity\MovimientoTipoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MovimientoTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoTipo::class);
    }

    /**
     * @param $codigoMovimientoTipo
     * @param $codigoEmpresa
     * @return int
     * @throws \Doctrine\ORM\ORMException
     */
    public function generarConsecutivo($codigoMovimientoTipo, $codigoEmpresa)
    {
        $em = $this->getEntityManager();
        $consecutivo = 1;
        $arDocumentoEmpresa = $em->getRepository(MovimientoTipoEmpresa::class)->findOneBy(['codigoMovimientoTipoFk' => $codigoMovimientoTipo, 'codigoEmpresaFk' => $codigoEmpresa]);
        if($arDocumentoEmpresa) {
            $consecutivo = $arDocumentoEmpresa->getConsecutivo();
            $arDocumentoEmpresa->setConsecutivo($arDocumentoEmpresa->getConsecutivo() + 1);
            $em->persist($arDocumentoEmpresa);
        } else {
            $arMovimientoTipo = $em->getRepository(MovimientoTipo::class)->find($codigoMovimientoTipo);
            $arDocumentoEmpresa = new MovimientoTipoEmpresa();
            $arDocumentoEmpresa->setMovimientoTipoRel($arMovimientoTipo);
            $arDocumentoEmpresa->setCodigoEmpresaFk($codigoEmpresa);
            $arDocumentoEmpresa->setConsecutivo(2);
            $em->persist($arDocumentoEmpresa);
        }
        return $consecutivo;
    }
}