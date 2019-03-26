<?php

namespace App\Repository;

use App\Entity\Matriz;
use App\Utilidades\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class MatrizRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Matriz::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Matriz::class, 'm')
            ->select('m.codigoMatrizPk')
        ->addSelect('m.nombre')
            ->addSelect('g.nombre as grupoNombre')
        ->leftJoin('m.grupoRel', 'g');
        if ($session->get('filtroMatrizNombre') != '') {
            $queryBuilder->andWhere("m.nombre LIKE '%{$session->get('filtroMatrizNombre')}%'");
        }
        return $queryBuilder;
    }

    public function eliminar($arrSeleccionados)
    {
        Modelo::eliminar(Matriz::class, $arrSeleccionados);
    }

}