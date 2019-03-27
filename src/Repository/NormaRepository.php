<?php

namespace App\Repository;

use App\Entity\Norma;

use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class NormaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Norma::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Norma::class, 'n')
            ->select('n.codigoNormaPk')
            ->addSelect('n.codigoNormaTipoFk')
            ->addSelect('n.numero')
            ->addSelect('n.nombre')
            ->addSelect('n.descripcion')
            ->addSelect('n.codigoGrupoFk')
            ->addSelect('n.codigoSubgrupoFk')
            ->addSelect('n.codigoEntidadFk')
            ->addSelect('n.codigoJurisdiccionFk')
            ->addSelect('n.codigoMatrizFk')
            ->addSelect('n.fecha')
            ->addSelect('nt.nombre as normaTipoNombre')
            ->addSelect('n.estadoDerogado')
            ->addSelect('e.nombre as entidadNombre')
            ->addSelect('j.nombre as jurisdiccionNombre')
            ->addSelect('m.nombre as matrizNombre')
        ->leftJoin('n.normaTipoRel', 'nt')
        ->leftJoin('n.entidadRel', 'e')
        ->leftJoin('n.jurisdiccionRel', 'j')
        ->leftJoin('n.matrizRel', 'm');

        if ($session->get('filtroNormaCodigo') != '') {
            $queryBuilder->andWhere("n.codigoNormaPk = '{$session->get('filtroNormaCodigo')}'");
        }
        if ($session->get('filtroNormaNombre') != '') {
            $queryBuilder->andWhere("n.nombre LIKE '%{$session->get('filtroNormaNombre')}%'");
        }
        if ($session->get('filtroNormaDescripcion') != '') {
            $queryBuilder->andWhere("n.descripcion LIKE '%{$session->get('filtroNormaDescripcion')}%'");
        }
        switch ($session->get('filtroNormaEstadoDerogado')) {
            case '0':
                $queryBuilder->andWhere("n.estadoDerogado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("n.estadoDerogado = 1");
                break;
        }
        $queryBuilder->orderBy('n.codigoNormaPk', 'DESC');
        return $queryBuilder;
    }

    public function listaMatriz($codigoMatriz)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Norma::class, 'n')
            ->select('n.codigoNormaPk')
            ->addSelect('n.codigoNormaTipoFk')
            ->addSelect('n.numero')
            ->addSelect('n.nombre')
            ->addSelect('n.descripcion')
            ->addSelect('n.codigoGrupoFk')
            ->addSelect('n.codigoSubgrupoFk')
            ->addSelect('n.codigoEntidadFk')
            ->addSelect('n.codigoJurisdiccionFk')
            ->addSelect('nt.nombre as normaTipoNombre')
            ->addSelect('n.estadoDerogado')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->addSelect('e.nombre as entidadNombre')
            ->addSelect('j.nombre as jurisdiccionNombre')
            ->leftJoin('n.grupoRel' , 'g')
            ->leftJoin('n.normaTipoRel', 'nt')
            ->leftJoin('n.subgrupoRel', 'sg')
            ->leftJoin('n.entidadRel', 'e')
            ->leftJoin('n.jurisdiccionRel', 'j')
        ->where('n.codigoMatrizFk = ' . $codigoMatriz);

        if ($session->get('filtroNormaCodigo') != '') {
            $queryBuilder->andWhere("n.codigoNormaPk = '{$session->get('filtroNormaCodigo')}'");
        }
        if ($session->get('filtroNormaNombre') != '') {
            $queryBuilder->andWhere("n.nombre LIKE '%{$session->get('filtroNormaNombre')}%'");
        }
        if ($session->get('filtroNormaDescripcion') != '') {
            $queryBuilder->andWhere("n.descripcion LIKE '%{$session->get('filtroNormaDescripcion')}%'");
        }
        switch ($session->get('estadoDerogado')) {
            case '0':
                $queryBuilder->andWhere("n.estadoDerogado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("n.estadoDerogado = 1");
                break;
        }
        return $queryBuilder;
    }


}