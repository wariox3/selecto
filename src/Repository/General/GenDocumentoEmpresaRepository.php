<?php

namespace App\Repository\General;

use App\Entity\General\GenDocumento;
use App\Entity\General\GenDocumentoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GenDocumentoEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenDocumentoEmpresa::class);
    }

}