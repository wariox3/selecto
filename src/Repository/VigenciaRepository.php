<?php

namespace App\Repository;

use App\Entity\Vigencia;
use App\Utilidades\Modelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class VigenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vigencia::class);
    }


    public function listaNorma($id)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Vigencia::class, 'v')
            ->select('v.codigoVigenciaPk')
            ->addSelect('v.vigencia')
            ->where('v.codigoNormaFk = ' . $id);
             if ($session->get('filtroVigencia') != '') {
                    $queryBuilder->andWhere("v.codigoVigenciaPk = {$session->get('filtroVigencia')}");
             }

        return $queryBuilder;
    }

    public function llenarCombo($id)
    {
        $codigoNormaFk= $id;
        $session = new Session();
        $array = [
            'class' => Vigencia::class,
            'query_builder' => function (EntityRepository $er) use ($codigoNormaFk) {
                return $er->createQueryBuilder('v')
                    ->where("v.codigoNormaFk =  {$codigoNormaFk}")
                    ->orderBy('v.vigencia', 'ASC');
            },
            'choice_label' => 'vigencia',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroVigencia')) {
            $array['data'] = $this->getEntityManager()->getReference(Vigencia::class, $session->get('filtroVigencia'));
        }
        return $array;
    }

}