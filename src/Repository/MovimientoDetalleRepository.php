<?php

namespace App\Repository;

use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Entity\Tercero;
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
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select('md.codigoMovimientoDetallePk')
            ->addSelect('i.descripcion as item')
            ->addSelect(' md.cantidad')
            ->addSelect('md.precio')
            ->addSelect('md.subtotal')
            ->leftJoin("md.itemRel", "i")
            ->where('md.codigoMovimientoFk = '. $id);

        return $queryBuilder->getQuery()->getResult();
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
                $arMovimientoDetalle->setPrecio($arrPrecio[$codigoMovimientoDetalle]);
                $arMovimientoDetalle->setSubtotal($arMovimientoDetalle->getPrecio() * $arMovimientoDetalle->getCantidad());
                $em->persist($arMovimientoDetalle);
                $em->flush();
            }
//            if ($mensajeError == "") {
//                $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
//                $this->getEntityManager()->flush();
//            } else {
//                Mensajes::error($mensajeError);
//            }
    }

}