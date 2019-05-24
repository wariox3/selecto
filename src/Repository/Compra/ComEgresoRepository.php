<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgreso;
use App\Entity\Compra\ComEgresoDetalle;
use App\Entity\General\GenConfiguracion;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class ComEgresoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComEgreso::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComEgreso::class, 'e')
            ->select('e.codigoEgresoPk')
            ->addSelect('e.fecha')
            ->addSelect('e.numero')
            ->addSelect('e.fechaPago')
            ->addSelect('e.vrPago')
            ->addSelect('e.vrPagoTotal')
            ->addSelect('et.numeroIdentificacion as identificacion')
            ->addSelect('et.nombreCorto as nombre')
            ->addSelect('ec.cuenta')
            ->addSelect('e.usuario')
            ->addSelect('ec.tipo ')
            ->addSelect('e.estadoAutorizado')
            ->addSelect('e.estadoAprobado')
            ->addSelect('e.estadoAnulado')
            ->leftJoin('e.cuentaRel', 'ec')
            ->leftJoin('e.terceroRel', 'et')
            ->where('e.codigoEmpresaFk = ' . $empresa);
        if ($session->get('filtroEgresoFechaDesde') != null) {
            $queryBuilder->andWhere("e.fecha >= '{$session->get('filtroEgresoFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroEgresoFechaHasta') != null) {
            $queryBuilder->andWhere("e.fecha <= '{$session->get('filtroEgresoFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroMovimientoTercero')) {
            $queryBuilder->andWhere("e.codigoTerceroFk = '{$session->get('filtroMovimientoTercero')}'");
        }
        $queryBuilder->orderBy("e.codigoEgresoPk", 'DESC');
        return $queryBuilder;
    }
//
//    /**
//     * @param $arRecibo CarRecibo
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function autorizar($arRecibo)
//    {
//        $em = $this->getEntityManager();
//        $error = false;
//        $arReciboDetalles = $em->getRepository(CarReciboDetalle::class)->findBy(array('codigoReciboFk' => $arRecibo->getCodigoReciboPk()));
//        if (count($em->getRepository(CarReciboDetalle::class)->findBy(['codigoReciboFk' => $arRecibo->getCodigoReciboPk()])) > 0) {
//            foreach ($arReciboDetalles AS $arReciboDetalle) {
//                $arCuentaCobrar = $em->getRepository(CarCuentaCobrar::class)->find($arReciboDetalle->getCodigoCuentaCobrarFk());
//                if ($arReciboDetalle->getVrPagoAfectar() < 0) {
//                    Mensajes::error("Error detalle ID: " . $arReciboDetalle->getCodigoReciboDetallePk() . " el pago a afectar es menor que cero");
//                    $error = true;
//                    break;
//                }
//                if ($arCuentaCobrar->getVrSaldo() >= $arReciboDetalle->getVrPagoAfectar()) {
//                    $saldo = $arCuentaCobrar->getVrSaldo() - $arReciboDetalle->getVrPagoAfectar();
//                    $saldoOperado = $saldo * $arCuentaCobrar->getOperacion();
//                    $arCuentaCobrar->setVrSaldo($saldo);
//                    $arCuentaCobrar->setVrSaldoOperado($saldoOperado);
//                    $arCuentaCobrar->setVrAbono($arCuentaCobrar->getVrAbono() + $arReciboDetalle->getVrPagoAfectar());
//                    $em->persist($arCuentaCobrar);
//                } else {
//                    Mensajes::error("Error detalle ID: " . $arReciboDetalle->getCodigoReciboDetallePk() . "el saldo " . $arCuentaCobrar->getVrSaldo() . " de la cuenta por cobrar numero: " . $arCuentaCobrar->getNumeroDocumento() . " es menor al ingresado " . $arReciboDetalle->getVrPagoAfectar());
//                    $error = true;
//                    break;
//                }
//                if ($error == false) {
//                    $arRecibo->setEstadoAutorizado(1);
//                    $em->persist($arRecibo);
//                    $em->flush();
//                }
//            }
//        }
//    }
//
//    /**
//     * @param $arRecibo CarRecibo
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function desautorizar($arRecibo)
//    {
//        $em = $this->getEntityManager();
//        $arReciboDetalles = $em->getRepository(CarReciboDetalle::class)->findBy(array('codigoReciboFk' => $arRecibo->getCodigoReciboPk()));
//        foreach ($arReciboDetalles AS $arReciboDetalle) {
//            $arCuentaCobrar = $em->getRepository(CarCuentaCobrar::class)->find($arReciboDetalle->getCodigoCuentaCobrarFk());
//            $saldo = $arCuentaCobrar->getVrSaldo() + $arReciboDetalle->getVrPagoAfectar();
//            $saldoOperado = $saldo * $arCuentaCobrar->getOperacion();
//            $arCuentaCobrar->setVrSaldo($saldo);
//            $arCuentaCobrar->setVrSaldoOperado($saldoOperado);
//            $arCuentaCobrar->setVrAbono($arCuentaCobrar->getVrAbono() - $arReciboDetalle->getVrPagoAfectar());
//            $em->persist($arCuentaCobrar);
//        }
//        $arRecibo->setEstadoAutorizado(0);
//        $em->persist($arRecibo);
//        $em->flush();
//    }
//
//    /**
//     * @param $codigoRecibo
//     * @return mixed
//     * @throws \Doctrine\ORM\NoResultException
//     * @throws \Doctrine\ORM\NonUniqueResultException
//     */
//    public function contarDetalles($codigoRecibo)
//    {
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarReciboDetalle::class, 'rd')
//            ->select("COUNT(rd.codigoReciboDetallePk)")
//            ->where("rd.codigoReciboFk = {$codigoRecibo} ");
//        $resultado = $queryBuilder->getQuery()->getSingleResult();
//        return $resultado[1];
//    }
//
    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($id)
    {
        $em = $this->getEntityManager();
        $pago = 0;
        $pagoTotal = 0;
        $arEgreso = $em->getRepository(ComEgreso::class)->find($id);
        $arEgresosDetalles = $em->getRepository(ComEgresoDetalle::class)->findBy(array('codigoEgresoFk' => $id));
        foreach ($arEgresosDetalles as $arEgresoDetalle) {
            $pago += $arEgresoDetalle->getVrPago() * $arEgresoDetalle->getOperacion();
            $pagoTotal += $arEgresoDetalle->getVrPagoAfectar();
        }
        $arEgreso->setVrPago($pago);
        $arEgreso->setVrPagoTotal($pagoTotal);
        $em->persist($arEgreso);
        $em->flush();
        return true;
    }
//
//    /**
//     * @param $arRecibo CarRecibo
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function aprobar($arRecibo)
//    {
//        $em = $this->getEntityManager();
//        if ($arRecibo->getEstadoAutorizado()) {
//            $arReciboTipo = $em->getRepository(CarReciboTipo::class)->find($arRecibo->getCodigoReciboTipoFk());
//            if ($arRecibo->getNumero() == 0 || $arRecibo->getNumero() == NULL) {
//                $arRecibo->setNumero($arReciboTipo->getConsecutivo());
//                $arReciboTipo->setConsecutivo($arReciboTipo->getConsecutivo() + 1);
//                $em->persist($arReciboTipo);
//            }
//            $arRecibo->setFecha(new \DateTime('now'));
//            $arRecibo->setEstadoAprobado(1);
//            $em->persist($arRecibo);
//            $em->flush();
//        }
//    }
}