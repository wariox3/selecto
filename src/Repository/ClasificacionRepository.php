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