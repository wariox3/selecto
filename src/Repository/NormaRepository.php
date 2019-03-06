<?php

namespace App\Repository;

use App\Entity\Norma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->addSelect('n.nombre')
            ->addSelect('n.descripcion')
            ->addSelect('n.codigoGrupoFk')
            ->addSelect('n.codigoSubgrupoFk')
            ->addSelect('n.codigoEntidadFk')
            ->addSelect('n.codigoJurisdiccionFk')
        ->addSelect('n.estadoDerogado');

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