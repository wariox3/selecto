<?php

namespace App\Repository\General;

use App\Entity\General\GenDocumento;
use App\Entity\General\GenDocumentoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GenDocumentoEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenDocumentoEmpresa::class);
    }

}