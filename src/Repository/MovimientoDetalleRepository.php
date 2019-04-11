<?php

namespace App\Repository;

use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class MovimientoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MovimientoDetalle::class);
    }

    public function lista($id)
    {
//        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('i.descripcion as item')
            ->addSelect(' md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->leftJoin("md.itemRel", "i")
            ->where('md.codigoMovimientoFk = '. $id);

        return $queryBuilder->getQuery()->getResult();
    }

    public function informe()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('i.descripcion as item')
            ->addSelect('m.fecha as movimientofecha')
            ->addSelect('m.numero as movimientonumero')
            ->addSelect('d.nombre as documento')
            ->addSelect('t.nombreCorto as tercero')
            ->addSelect(' md.cantidad')
            ->addSelect('md.vrPrecio')
            ->addSelect('md.vrSubtotal')
            ->addSelect('md.porcentajeIva')
            ->addSelect('md.vrIva')
            ->addSelect('md.vrTotal')
            ->leftJoin('md.movimientoRel', 'm')
            ->leftJoin('m.documentoRel', 'd')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin("md.itemRel", "i");
        if ($session->get('filtroInformeMovimientoFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('filtroInformeMovimientoFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroInformeMovimientoFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('filtroInformeMovimientoFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroMovimientoNumero') !='') {
            $queryBuilder->andWhere("m.numero = '{$session->get('filtroMovimientoNumero')}'");
        }

        $queryBuilder->orderBy("m.fecha", 'DESC');

        return $queryBuilder;


//        return $queryBuilder->getQuery()->getResult();
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
            $arrCantidad = $arrControles['arrCantidad'];
            $arrPrecio = $arrControles['arrValor'];
            $arrCodigo = $arrControles['arrCodigo'];
            foreach ($arrCodigo as $codigoMovimientoDetalle) {
                $arMovimientoDetalle = $this->getEntityManager()->getRepository(MovimientoDetalle::class)->find($codigoMovimientoDetalle);
                $arMovimientoDetalle->setCantidad($arrCantidad[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setVrPrecio($arrPrecio[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setVrSubtotal($arMovimientoDetalle->getVrPrecio() * $arMovimientoDetalle->getCantidad());
                $arMovimientoDetalle->setVrIva($arMovimientoDetalle->getVrSubtotal() * $arMovimientoDetalle->getPorcentajeIva() /100);
                $arMovimientoDetalle->setvrTotal($arMovimientoDetalle->getVrSubtotal() + $arMovimientoDetalle->getVrIva());
                $em->persist($arMovimientoDetalle);
                $em->flush();
            }

                $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
                $this->getEntityManager()->flush();

    }

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

}