<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class InvItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvItem::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvItem::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.descripcion')
            ->addSelect('i.referencia')
            ->addSelect('i.cantidadExistencia')
            ->addSelect('i.porcentajeIva')
            ->addSelect('i.servicio')
            ->orderBy('i.codigoItemPk', 'ASC')
            ->where('i.codigoEmpresaFk = '. $empresa);
        if ($session->get('filtroItemCodigo') != '') {
            $queryBuilder->andWhere("i.codigoItemPk = {$session->get('filtroItemCodigo')}");
        }
        if ($session->get('filtroItemDescripcion') != '') {
            $queryBuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
        }
        return $queryBuilder;
    }

    public function existencia($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvItem::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.referencia')
            ->addSelect('i.descripcion')
            ->addSelect('i.cantidadExistencia')
            ->orderBy('i.codigoItemPk', 'ASC')
        ->where('i.codigoEmpresaFk = ' .$empresa);
        if ($session->get('filtroItemReferencia') != '') {
            $queryBuilder->andWhere("i.referencia like '%{$session->get('filtroItemReferencia')}%'");
        }
        if ($session->get('filtroItemDescripcion') != '') {
            $queryBuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
        }
        return $queryBuilder;
    }
}