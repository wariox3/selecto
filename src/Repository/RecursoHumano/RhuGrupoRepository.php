<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmpleado;
use App\Entity\RecursoHumano\RhuGrupo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuGrupoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuGrupo::class);
    }
    public function camposPredeterminados(){
        $qb = $this-> _em->createQueryBuilder()
            ->from(RhuGrupo::class,'gp')
            ->select('gp.codigoGrupoPk AS ID')
            ->addSelect('gp.nombre AS NOMBRE');
        $query = $this->_em->createQuery($qb->getDQL());
        return $query->execute();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function llenarCombo()
    {
        $array = [
            'class' => RhuGrupo::class,
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
        return $array;
    }
}