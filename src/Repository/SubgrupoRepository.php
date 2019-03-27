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
        if ($session->get('subGrupoRel')) {
            $array['data'] = $this->getEntityManager()->getReference(Subgrupo::class, $session->get('subGrupoRel'));
        }
        return $array;
    }

}