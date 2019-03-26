<?php

namespace App\Repository;

use App\Entity\Cliente;
use App\Utilidades\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function lista(){

        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Cliente::class, 'c')
            ->select('c.codigoClientePk')
            ->addSelect('c.nombreCorto');
        if ($session->get('filtroClienteNombreCorto') != ''){
            $queryBuilder->andWhere("c.nombreCorto LIKE '%{$session->get('filtroClienteNombreCorto')}' ");
        }

        return $queryBuilder;

    }


}