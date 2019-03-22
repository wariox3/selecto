<?php

namespace App\Repository;

use App\Entity\Vigencia;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class VigenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vigencia::class);
    }


    public function listaNorma($codigoNorma)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Vigencia::class, 'v')
            ->select('v.codigoVigenciaPk')
            ->addSelect('v.vigencia')
        ->where('v.codigoNormaFk = ' . $codigoNorma);
        return $queryBuilder;
    }

    public function Eliminar($arrVigenciasSeleccionados)
    {
        AyudaEliminar::eliminar(Vigencia::class, $arrVigenciasSeleccionados);
    }

}