<?php

namespace App\Repository;

use App\Entity\Malla;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class MallaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Malla::class);
    }

    public function listaCliente($codigoCliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Malla::class, 'm')
            ->select('m.codigoMallaPk')
            ->addSelect('m.codigoClienteFk')
            ->addSelect('m.codigoCentroFk')
            ->addSelect('m.codigoNormaFk')
            ->addSelect('ct.nombre as centroNombre')
            ->addSelect('n.nombre as normaNombre')
            ->addSelect('n.descripcion as normaDescripcion')
            ->leftJoin('m.clienteRel', 'c')
            ->leftJoin('m.centroRel', 'ct')
            ->leftJoin('m.normaRel', 'n');

/*        switch ($session->get('filtroTareaEstadoEjecucion')) {
            case '0':
                $queryBuilder->andWhere("t.estadoEjecucion = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoEjecucion = 1");
                break;
        }
        switch ($session->get('filtroTareaEstadoTerminado')) {
            case '0':
                $queryBuilder->andWhere("t.estadoTerminado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoTerminado = 1");
                break;
        }
        switch ($session->get('filtroTareaEstadoIncomprensible')) {
            case '0':
                $queryBuilder->andWhere("t.estadoIncomprensible = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoIncomprensible = 1");
                break;
        }
        switch ($session->get('filtroTareaEstadoPausa')) {
            case '0':
                $queryBuilder->andWhere("t.estadoPausa = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.estadoPausa = 1");
                break;
        }*/
        return $queryBuilder;
    }

}