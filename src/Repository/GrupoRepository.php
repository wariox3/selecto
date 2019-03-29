<?php

namespace App\Repository;

use App\Entity\Grupo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class GrupoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grupo::class);
    }

    public function lista(){
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Grupo::class, 'gr')
            ->select('gr.codigoGrupoPk')
            ->addSelect('gr.nombre');
        $queryBuilder->orderBy('gr.codigoGrupoPk', 'DESC');

        if ($session->get('filtroNombre') != ''){
            $queryBuilder->andWhere("gr.nombre = '{$session->get('filtroNombre')}'");
        }
        if ($session->get('filtroClave') != ''){
            $queryBuilder->andWhere("gr.codigoGrupoPk = '{$session->get('filtroClave')}'");
        }
        return $queryBuilder;

    }
    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Grupo::class,
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
        if ($session->get('filtroGrupo')) {
            $array['data'] = $this->getEntityManager()->getReference(Grupo::class, $session->get('filtroGrupo'));
        }
        return $array;
    }

}