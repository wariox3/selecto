<?php

namespace App\Repository;

use App\Entity\Vigencia;
use App\Utilidades\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class VigenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vigencia::class);
    }


    public function listaNorma($id)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Vigencia::class, 'v')
            ->select('v.codigoVigenciaPk')
            ->addSelect('v.vigencia')
            ->where('v.codigoNormaFk = ' . $id)
            ->orderBy('v.codigoVigenciaPk', 'DESC');

            if ($session->get('filtroVigencia') != '') {
                 $queryBuilder->andWhere("v.vigencia LIKE '%{$session->get('filtroVigencia')}%'");
             }


        return $queryBuilder;
    }


}