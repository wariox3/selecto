<?php

namespace App\Repository;

use App\Entity\Subgrupo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class SubgrupoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subgrupo::class);
    }

    public function lista(){

        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Subgrupo::class, 'sg')
            ->select('sg.codigoSubgrupoPk')
            ->addSelect('sg.nombre')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('sg.grupoRel' , 'g');
        $queryBuilder->orderBy('sg.codigoSubgrupoPk', 'DESC');

        if ($session->get('filtroNombre') != ''){
            $queryBuilder->andWhere("sg.nombre = '{$session->get('filtroNombre')}'");
        }
        if ($session->get('filtroClave') != ''){
            $queryBuilder->andWhere("sg.codigoSubgrupoPk = '{$session->get('filtroClave')}'");
        }
        if ($session->get('filtroGrupo') != ''){
            $queryBuilder->andWhere("g.nombre = '{$session->get('filtroGrupo')}'");
        }
        return $queryBuilder;

    }


    public function  detalle($id){
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Subgrupo::class, 'sg')
            ->select('sg.codigoSubgrupoPk')
            ->addSelect('sg.nombre')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('sg.grupoRel' , 'g')
            ->where("sg.codigoSubgrupoPk = '{$id}'");
        $query =$queryBuilder->getQuery();
        //dd($queryBuilder->getQuery());
        return $query->getResult();
    }

    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Subgrupo::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('sg')
                    ->orderBy('sg.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroSubGrupo')) {
            $array['data'] = $this->getEntityManager()->getReference(Subgrupo::class, $session->get('filtroSubGrupo'));
        }
        return $array;
    }

}