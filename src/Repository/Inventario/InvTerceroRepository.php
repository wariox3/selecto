<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvTercero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class InvTerceroRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvTercero::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvTercero::class, 't')
            ->select('t.codigoTerceroPk')
            ->addSelect('t.nombreCorto')
            ->addSelect('t.numeroIdentificacion')
            ->addSelect('t.telefono')
            ->addSelect('c.nombre AS ciudad')
            ->addSelect('t.direccion')
            ->addSelect('t.celular')
            ->addSelect('t.email')
            ->addSelect('t.digitoVerificacion')
            ->addSelect('t.cliente')
            ->addSelect('t.proveedor')
        ->leftJoin('t.ciudadRel', 'c');
        $queryBuilder->orderBy("t.codigoTerceroPk", 'DESC');
        if ($session->get('filtroTerceroCodigo') != '') {
            $queryBuilder->andWhere("t.codigoTerceroPk  ='{$session->get('filtroTerceroCodigo')}'");
        }
        if ($session->get('filtroTerceroNombreCorto') != '') {
            $queryBuilder->andWhere("t.nombreCorto like '%{$session->get('filtroTerceroNombreCorto')}%'");
        }
        switch ($session->get('filtroTerceroCliente')) {
            case '0':
                $queryBuilder->andWhere("t.cliente = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.cliente = 1");
                break;
        }
        switch ($session->get('filtroTerceroProveedor')) {
            case '0':
                $queryBuilder->andWhere("t.proveedor = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.proveedor = 1");
                break;
        }
        return $queryBuilder;
    }

    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => InvTercero::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.nombreCorto', 'ASC');
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroTercero')) {
            $array['data'] = $this->getEntityManager()->getReference(InvTercero::class, $session->get('filtroTercero'));
        }
        return $array;
    }
}