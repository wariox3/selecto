<?php

namespace App\Repository;

use App\Entity\Accion;
use App\Entity\Articulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AccionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Accion::class);
    }

    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Accion::class,
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
        if ($session->get('filtroAccion')) {
            $array['data'] = $this->getEntityManager()->getReference(Accion::class, $session->get('filtroAccion'));
        }
        return $array;
    }

}