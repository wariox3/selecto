<?php

namespace App\Repository\General;

use App\Entity\General\GenDocumento;
use App\Entity\General\GenDocumentoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GenDocumentoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenDocumento::class);
    }

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