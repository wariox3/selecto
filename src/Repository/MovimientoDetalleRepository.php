<?php

namespace App\Repository;

use App\Entity\Impuesto;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class MovimientoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoDetalle::class);
    }

    public function lista($id)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.codigoItemFk')
            ->addSelect(' md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.vrBaseIva')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->addSelect('md.codigoImpuestoRetencionFk')
            ->addSelect('md.codigoImpuestoIvaFk')
            ->addSelect('i.nombre as itemNombre')
            ->addSelect('i.referencia as referencia')
            ->leftJoin("md.itemRel", "i")
            ->where('md.codigoMovimientoFk = ' . $id);
        return $queryBuilder->getQuery()->getResult();
    }

    public function informe($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.codigoItemFk as itemCodigoPk')
            ->addSelect('i.referencia as itemReferencia')
            ->addSelect('i.cantidadExistencia as itemExistencia')
            ->addSelect('i.descripcion as itemDescripcion')
            ->addSelect('m.fecha as movimientofecha')
            ->addSelect('m.numero as movimientonumero')
            ->addSelect('d.nombre as documento')
            ->addSelect('t.nombreCorto as tercero')
            ->addSelect('md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->leftJoin('md.movimientoRel', 'm')
            ->leftJoin('m.movimientoTipoRel', 'd')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin("md.itemRel", "i")
            ->where('md.codigoEmpresaFk = ' . $empresa);
        if ($session->get('filtroInformeMovimientoFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('filtroInformeMovimientoFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroInformeMovimientoFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('filtroInformeMovimientoFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroMovimientoNumero') != '') {
            $queryBuilder->andWhere("m.numero = '{$session->get('filtroMovimientoNumero')}'");
        }
        if ($session->get('filtroItemReferencia') != '') {
            $queryBuilder->andWhere("i.referencia like '%{$session->get('filtroItemReferencia')}%'");
        }
        $queryBuilder->orderBy("m.fecha", 'DESC');
        return $queryBuilder;
    }

    /**
     * @param $arrControles
     * @param $form
     * @param $arMovimiento Movimiento
     * @param $arMovimientoDetalle MovimientoDetalle
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arMovimiento)
    {
        $em = $this->getEntityManager();
        $this->getEntityManager()->persist($arMovimiento);
        if ($this->getEntityManager()->getRepository(Movimiento::class)->contarDetalles($arMovimiento->getCodigoMovimientoPk()) > 0) {
            $arrCantidad = $arrControles['arrCantidad'];
            $arrPrecio = $arrControles['arrValor'];
            $arrPorcentajeDescuento = $arrControles['arrPorcentajeDescuento'];
            $arrCodigo = $arrControles['arrCodigo'];
            $arrImpuestoIva = $arrControles['cboImpuestoIva'];
            $arrImpuestoRetencion = $arrControles['cboImpuestoRetencion'];
            $mensajeError = "";
            foreach ($arrCodigo as $codigoMovimientoDetalle) {
                $arMovimientoDetalle = $this->getEntityManager()->getRepository(MovimientoDetalle::class)->find($codigoMovimientoDetalle);
                $arMovimientoDetalle->setCantidad($arrCantidad[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setVrPrecio($arrPrecio[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setPorcentajeDescuento($arrPorcentajeDescuento[$codigoMovimientoDetalle]);
                $codigoImpuestoIva = $arrImpuestoIva[$codigoMovimientoDetalle];
                if($arMovimientoDetalle->getCodigoImpuestoIvaFk() != $codigoImpuestoIva) {
                    $arImpuestoIva = $em->getRepository(Impuesto::class)->find($codigoImpuestoIva);
                    $arMovimientoDetalle->setPorcentajeIva($arImpuestoIva->getPorcentaje());
                }
                $arMovimientoDetalle->setCodigoImpuestoIvaFk($codigoImpuestoIva);
                $codigoImpuestoRetencion = $arrImpuestoRetencion[$codigoMovimientoDetalle];
                if($arMovimientoDetalle->getCodigoImpuestoRetencionFk() != $codigoImpuestoRetencion) {
                    $arImpuestoRetencion = $em->getRepository(Impuesto::class)->find($codigoImpuestoRetencion);
//                    $arMovimientoDetalle->setPorcentajeRetencion($arImpuestoRetencion->getPorcentaje());
                }
                $arMovimientoDetalle->setCodigoImpuestoRetencionFk($codigoImpuestoRetencion);
                $em->persist($arMovimientoDetalle);
                $em->flush();
            }
            if ($mensajeError == "") {
                $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
                $this->getEntityManager()->flush();
            } else {
                Mensajes::error($mensajeError);
            }
        }
    }

    /**
     * @param $arMovimiento
     * @param $arrSeleccionados
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function eliminar($arMovimiento, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoMovimientoDetalle) {
                $arMovimientoDetalle = $em->getRepository(MovimientoDetalle::class)->find($codigoMovimientoDetalle);
                if ($arMovimientoDetalle) {
                    $em->remove($arMovimientoDetalle);
                }
            }
            $em->flush();
        }
    }

    public function facturaElectronica($codigoMovimiento) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.vrBaseIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.codigoItemFk')
            ->addSelect('i.nombre as itemNombre')
            ->addSelect('i.codigo as itemCodigo')
            ->leftJoin('md.itemRel', 'i')
            ->where("md.codigoMovimientoFk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        return $arrMovimiento;
    }

    public function listaImprimirFactura($codigoMovimiento) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.vrBaseIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('md.codigoItemFk')
            ->addSelect('i.nombre as itemNombre')
            ->addSelect('i.codigo as itemCodigo')
            ->addSelect('i.referencia as itemReferencia')
            ->leftJoin('md.itemRel', 'i')
            ->where("md.codigoMovimientoFk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        return $arrMovimiento;
    }

    public function informeVenta($empresa)
    {
        $session = new Session();
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.codigoItemFk')
            ->addSelect('md.cantidad')
            ->addSelect('(md.vrPrecio * mt.operacionComercial) as vrPrecio')
            ->addSelect('(md.vrSubtotal * mt.operacionComercial) as vrSubtotal')
            ->addSelect('md.vrBaseIva')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('(md.vrIva * mt.operacionComercial) as vrIva')
            ->addSelect('(md.vrTotal* mt.operacionComercial) as vrTotal')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('md.codigoImpuestoRetencionFk')
            ->addSelect('md.codigoImpuestoIvaFk')
            ->addSelect('m.numero as movimientoNumero')
            ->addSelect('m.fecha as movimientoFecha')
            ->addSelect('m.codigoMovimientoTipoFk')
            ->addSelect('i.nombre as itemNombre')
            ->addSelect('i.referencia as referencia')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('t.nombreCorto as terceroNombreCorto')
            ->addSelect('cc.nombre as centroCostoNombre')
            ->leftJoin("md.itemRel", "i")
            ->leftJoin("md.movimientoRel", "m")
            ->leftJoin('m.movimientoTipoRel', 'mt')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.centroCostoRel', 'cc')
            ->where('m.codigoEmpresaFk = ' . $empresa)
            ->andWhere('m.estadoAprobado = 1')
            ->andWhere("m.codigoMovimientoTipoFk = 'FAC' OR m.codigoMovimientoTipoFk = 'NC' OR m.codigoMovimientoTipoFk = 'ND'");
        if ($session->get('fitroInformeVentasFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('fitroInformeVentasFechaDesde')} 00:00:00'");
        }
        if ($session->get('fitroInformeVentasFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('fitroInformeVentasFechaHasta')} 23:59:59'");
        }
        if ($session->get('fitroInformeVentaDetalleNumero') != '') {
            $queryBuilder->andWhere("m.numero = '{$session->get('fitroInformeVentaDetalleNumero')}'");
        }
        if ($session->get('fitroInformeVentaDetalleItem') != '') {
            $queryBuilder->andWhere("i.codigoItemPk = '{$session->get('fitroInformeVentaDetalleItem')}'");
        }
        $queryBuilder->orderBy("m.fecha", 'DESC');
        return $queryBuilder;
    }

    public function informeCompra($empresa)
    {
        $session = new Session();
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('md.codigoItemFk')
            ->addSelect('md.cantidad')
            ->addSelect('(md.vrPrecio * mt.operacionComercial) as vrPrecio')
            ->addSelect('(md.vrSubtotal * mt.operacionComercial) as vrSubtotal')
            ->addSelect('md.vrBaseIva')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('(md.vrIva * mt.operacionComercial) as vrIva')
            ->addSelect('(md.vrTotal* mt.operacionComercial) as vrTotal')
            ->addSelect('md.porcentajeDescuento')
            ->addSelect('md.codigoImpuestoRetencionFk')
            ->addSelect('md.codigoImpuestoIvaFk')
            ->addSelect('m.numero as movimientoNumero')
            ->addSelect('m.fecha as movimientoFecha')
            ->addSelect('m.codigoMovimientoTipoFk')
            ->addSelect('i.nombre as itemNombre')
            ->addSelect('i.referencia as referencia')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('t.nombreCorto as terceroNombreCorto')
            ->addSelect('cc.nombre as centroCostoNombre')
            ->leftJoin("md.itemRel", "i")
            ->leftJoin("md.movimientoRel", "m")
            ->leftJoin('m.movimientoTipoRel', 'mt')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.centroCostoRel', 'cc')
            ->where('m.codigoEmpresaFk = ' . $empresa)
            ->andWhere('m.estadoAprobado = 1')
            ->andWhere("m.codigoMovimientoTipoFk = 'COM'");
        if ($session->get('fitroInformeVentasFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('fitroInformeVentasFechaDesde')} 00:00:00'");
        }
        if ($session->get('fitroInformeVentasFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('fitroInformeVentasFechaHasta')} 23:59:59'");
        }
        if ($session->get('fitroInformeVentaDetalleNumero') != '') {
            $queryBuilder->andWhere("m.numero = '{$session->get('fitroInformeVentaDetalleNumero')}'");
        }
        if ($session->get('fitroInformeVentaDetalleItem') != '') {
            $queryBuilder->andWhere("i.codigoItemPk = '{$session->get('fitroInformeVentaDetalleItem')}'");
        }
        $queryBuilder->orderBy("m.fecha", 'DESC');
        return $queryBuilder;
    }
}