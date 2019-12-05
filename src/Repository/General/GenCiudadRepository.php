<?php

namespace App\Repository\General;

use App\Entity\General\GenCiudad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class GenCiudadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenCiudad::class);
    }

    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => GenCiudad::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cui')
                    ->orderBy('cui.nombre', 'ASC');
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