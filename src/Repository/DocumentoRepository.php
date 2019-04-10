<?php

namespace App\Repository;

use App\Entity\Documento;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class DocumentoRepository  extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Documento::class);
    }

//    public function lista($documento)
//    {
//        $session = new Session();
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
//            ->select('m.codigoMovimientoPk')
//            ->addSelect('m.fecha')
//            ->addSelect('t.nombreCorto AS tercero')
//            ->leftJoin("m.terceroRel", "t")
//        ->where("m.codigoDocumentoFk = '" . $documento . "'");
//        if ($session->get('filtroMovimientoFechaDesde') != null) {
//            $queryBuilder->andWhere("m.fecha >= '{$session->get('filtroMovimientoFechaDesde')} 00:00:00'");
//        }
//        if ($session->get('filtroMovimientoFechaHasta') != null) {
//            $queryBuilder->andWhere("m.fecha <= '{$session->get('filtroMovimientoFechaHasta')} 23:59:59'");
//        }
//        if ($session->get('filtroMovimientoTercero')) {
//            $queryBuilder->andWhere("m.codigoTerceroFk = '" . $session->get('filtroMovimientoTercero') . "''");
//        }
//        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
//        return $queryBuilder;
//    }
}