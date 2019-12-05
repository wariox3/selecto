<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class InvItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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
            ->addSelect('i.vrPrecio')
            ->addSelect('i.cantidadExistencia')
            ->addSelect('i.porcentajeIva')
            ->addSelect('i.servicio')
            ->addSelect('i.producto')
            ->addSelect('i.afectaInventario')
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
            ->where('i.servicio = false')
        ->andWhere('i.codigoEmpresaFk = ' . $empresa)
        ->andWhere('i.cantidadExistencia > 0');
        if ($session->get('filtroItemReferencia') != '') {
            $queryBuilder->andWhere("i.referencia like '%{$session->get('filtroItemReferencia')}%'");
        }
        if ($session->get('filtroItemDescripcion') != '') {
            $queryBuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
        }
        return $queryBuilder;
    }
}