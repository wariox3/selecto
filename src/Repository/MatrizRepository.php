<?php

namespace App\Repository;

use App\Entity\Matriz;
use App\Utilidades\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
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

    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Matriz::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy('g.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroNorma')) {
            $array['data'] = $this->getEntityManager()->getReference(Matriz::class, $session->get('filtroMatriz'));
        }
        return $array;
    }
}