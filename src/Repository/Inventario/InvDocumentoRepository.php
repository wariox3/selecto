<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvDocumento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class InvDocumentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvDocumento::class);
    }

    /**
     * @param $codigoDocumento
     * @param $codigoEmpresa
     * @return int
     * @throws \Doctrine\ORM\ORMException
     */
    public function generarConsecutivo($codigoDocumento, $codigoEmpresa)
    {
        $em = $this->getEntityManager();
        $consecutivo = 1;
        $arDocumentoEmpresa = $em->getRepository(GenDocumentoEmpresa::class)->findOneBy(['codigoDocumentoFk' => $codigoDocumento, 'codigoEmpresaFk' => $codigoEmpresa]);
        if($arDocumentoEmpresa) {
            $consecutivo = $arDocumentoEmpresa->getConsecutivo();
            $arDocumentoEmpresa->setConsecutivo($arDocumentoEmpresa->getConsecutivo() + 1);
            $em->persist($arDocumentoEmpresa);
        } else {
            $arDocumento = $em->getRepository(GenDocumento::class)->find($codigoDocumento);
            $arDocumentoEmpresa = new GenDocumentoEmpresa();
            $arDocumentoEmpresa->setDocumentoRel($arDocumento);
            $arDocumentoEmpresa->setCodigoEmpresaFk($codigoEmpresa);
            $arDocumentoEmpresa->setConsecutivo(2);
            $em->persist($arDocumentoEmpresa);
        }
        return $consecutivo;
    }
}