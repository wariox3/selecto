<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvDocumento;
use App\Entity\Inventario\InvDocumentoEmpresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class InvDocumentoEmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvDocumentoEmpresa::class);
    }

}