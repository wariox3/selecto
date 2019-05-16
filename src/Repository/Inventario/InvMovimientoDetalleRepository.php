<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class InvMovimientoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvMovimientoDetalle::class);
    }

    public function lista($id)
    {
//        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvMovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('i.codigoItemPk as item')
            ->addSelect('i.descripcion as descripcion')
            ->addSelect('i.referencia as referencia')
            ->addSelect(' md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->leftJoin("md.itemRel", "i")
            ->where('md.codigoMovimientoFk = ' . $id);
        return $queryBuilder->getQuery()->getResult();
    }

    public function informe($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvMovimientoDetalle::class, 'md')
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
            ->leftJoin('m.documentoRel', 'd')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin("md.itemRel", "i")
        ->where('md.codigoEmpresaFk = ' .$empresa );
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
     * @param $arMovimiento InvMovimiento
     * @param $arMovimientoDetalle InvMovimientoDetalle
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arMovimiento)
    {
        $em = $this->getEntityManager();
        if ($this->getEntityManager()->getRepository(InvMovimiento::class)->contarDetalles($arMovimiento->getCodigoMovimientoPk()) > 0) {
            $arrCantidad = $arrControles['arrCantidad'];
            $arrPrecio = $arrControles['arrValor'];
            $arrCodigo = $arrControles['arrCodigo'];
            foreach ($arrCodigo as $codigoMovimientoDetalle) {
                $arMovimientoDetalle = $this->getEntityManager()->getRepository(InvMovimientoDetalle::class)->find($codigoMovimientoDetalle);
                $arMovimientoDetalle->setCantidad($arrCantidad[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setVrPrecio($arrPrecio[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setVrSubtotal($arMovimientoDetalle->getVrPrecio() * $arMovimientoDetalle->getCantidad());
                $arMovimientoDetalle->setVrIva($arMovimientoDetalle->getVrSubtotal() * $arMovimientoDetalle->getPorcentajeIva() / 100);
                $arMovimientoDetalle->setvrTotal($arMovimientoDetalle->getVrSubtotal() + $arMovimientoDetalle->getVrIva());
                $em->persist($arMovimientoDetalle);
                $em->flush();
            }
            $em->getRepository(InvMovimiento::class)->liquidar($arMovimiento);
            $this->getEntityManager()->flush();
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
                $arMovimientoDetalle = $em->getRepository(InvMovimientoDetalle::class)->find($codigoMovimientoDetalle);
                if ($arMovimientoDetalle) {
                    $em->remove($arMovimientoDetalle);
                }
            }
            $em->flush();
        }
    }
}