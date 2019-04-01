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
        return $queryBuilder;

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