<?php

namespace App\Repository;

use App\Entity\Matriz;
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
            ->select('m.codigoMatrizPk');

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