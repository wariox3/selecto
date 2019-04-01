<?php

namespace App\Repository;

use App\Entity\Clasificacion;
use App\Entity\Grupo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ClasificacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clasificacion::class);
    }

    public function lista()
    {

        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Clasificacion::class, 'cl')
            ->select('cl.codigoClasificacionPk')
            ->addSelect('cl.nombre')
            ->addSelect('g.nombre as grupoNombre')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->leftJoin('cl.grupoRel', 'g')
            ->leftJoin('cl.subgrupoRel', 'sg');
        $queryBuilder->orderBy('cl.codigoClasificacionPk', 'DESC');

        if ($session->get('filtroNombre') != '') {
            $queryBuilder->andWhere("cl.nombre = '{$session->get('filtroNombre')}'");
        }
        if ($session->get('filtroClave') != '') {
            $queryBuilder->andWhere("cl.codigoClasificacionPk = '{$session->get('filtroClave')}'");
        }
        if ($session->get('filtroGrupo') != '') {
            $queryBuilder->andWhere("g.nombre = '{$session->get('filtroGrupo')}'");
        }
        if ($session->get('filtroSubGrupo') != ''){
            $queryBuilder->andWhere("sg.nombre = '{$session->get('filtroSubGrupo')}'");
        }

        return $queryBuilder;

    }


    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Clasificacion::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cl')
                    ->orderBy('cl.nombre', 'ASC');
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroClasificacion')) {
            $array['data'] = $this->getEntityManager()->getReference(Clasificacion::class, $session->get('filtroClasificacion'));
        }
        return $array;
    }
}