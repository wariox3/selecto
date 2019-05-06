<?php

namespace App\Repository\Cartera;

use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CarReciboDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarReciboDetalle::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarReciboDetalle::class, 'rd')
            ->select('rd.codigoReciboDetallePk')
            ->addSelect('rd.numeroFactura')
            ->addSelect('rd.vrPago')
            ->addSelect('rd.vrPagoAfectar')
            ->addSelect('rdcc.vrTotalBruto as total' )
            ->addSelect('rdcct.nombre')
            ->leftJoin('rd.cuentaCobrarRel','rdcc')
            ->leftJoin('rd.cuentaCobrarTipoRel', 'rdcct');
        if ($session->get('filtroReciboFechaDesde') != null) {
            $queryBuilder->andWhere("r.fecha >= '{$session->get('filtroReciboFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroReciboFechaHasta') != null) {
            $queryBuilder->andWhere("r.fecha <= '{$session->get('filtroReciboFechaHasta')} 23:59:59'");
        }
//        if ($session->get('filtroRecibo' != '')) {
//
//        }
        return $queryBuilder;
    }

    /**
     * @param $arrControles
     * @param $form
     * @param $arRecibos
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arRecibos)
    {
        $em = $this->getEntityManager();
        if ($this->getEntityManager()->getRepository(CarRecibo::class)->contarDetalles($arRecibos->getCodigoReciboPk()) > 0) {
            $arrCodigo = $arrControles['arrCodigo'];

            foreach ($arrCodigo as $codigoReciboDetalle) {
                $arReciboDetalle = $this->getEntityManager()->getRepository(CarReciboDetalle::class)->find($codigoReciboDetalle);
                $arReciboDetalle->setCodigoReciboFk($arReciboDetalle->getCodigoReciboPk());
                $arReciboDetalle->setCodigoCuentaCobrarFk($arReciboDetalle->getCodigoCuentaCobrarFk());
                $arReciboDetalle->setCodigoCuentaCobrarTipoFk($arReciboDetalle->getCodigoCuentaCobrarTipoFk());
                $arReciboDetalle->setNumeroFactura($arReciboDetalle->getNumeroFactura());
                $arReciboDetalle->setVrPago($arReciboDetalle->getVrPago());
                $arReciboDetalle->setVrPagoAfectar($arReciboDetalle->getVrPagoAfectar());
                $arReciboDetalle->setUsuario($arReciboDetalle->getUsuario());
                $arReciboDetalle->setOperacion($arReciboDetalle->getOperacion());
                $em->persist($arReciboDetalle);
                $em->flush();
            }
            $em->getRepository(CarReciboDetalle::class)->liquidar($arRecibos);
            $this->getEntityManager()->flush();
        }
    }

    public function liquidar($id)
    {
        $em = $this->getEntityManager();
        $pago = 0;
        $pagoTotal = 0;
        $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
        $arRecibosDetalle = $em->getRepository(CarReciboDetalle::class)->findBy(array('codigoReciboFk' => $id));
        foreach ($arRecibosDetalle as $arReciboDetalle) {
            $pago += $arReciboDetalle->getVrPago() * $arReciboDetalle->getOperacion();
            $pagoTotal += $arReciboDetalle->getVrPagoAfectar();
        }
        $arRecibo->setVrPago($pago);
        $arRecibo->setVrPagoTotal($pagoTotal);
        $em->persist($arRecibo);
        $em->flush();
        return true;
    }

    public function eliminar($arMovimiento, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoReciboDetalle) {
                $arReciboDetalle = $em->getRepository(CarReciboDetalle::class)->find($codigoReciboDetalle);
                if ($arReciboDetalle) {
                    $em->remove($arReciboDetalle);
                }
            }
            $em->flush();
        }
    }
}