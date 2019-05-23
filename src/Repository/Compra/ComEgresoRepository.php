<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComEgreso;
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

//    public function lista($empresa)
//    {
//        $session = new Session();
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarRecibo::class, 'r')
//            ->select('r.codigoReciboPk')
//            ->addSelect('r.fecha')
//            ->addSelect('r.numero')
//            ->addSelect('r.fechaPago')
//            ->addSelect('r.vrPago')
//            ->addSelect('r.vrPagoTotal')
//            ->addSelect('rt.numeroIdentificacion as identificacion')
//            ->addSelect('rt.nombreCorto as nombre')
//            ->addSelect('rc.cuenta')
//            ->addSelect('r.usuario')
//            ->addSelect('rc.tipo ')
//            ->addSelect('r.estadoAutorizado')
//            ->addSelect('r.estadoAprobado')
//            ->addSelect('r.estadoAnulado')
//            ->leftJoin('r.cuentaRel', 'rc')
//            ->leftJoin('r.terceroRel', 'rt')
//            ->where('r.codigoEmpresaFk = ' . $empresa);
//        if ($session->get('filtroReciboFechaDesde') != null) {
//            $queryBuilder->andWhere("r.fecha >= '{$session->get('filtroReciboFechaDesde')} 00:00:00'");
//        }
//        if ($session->get('filtroReciboFechaHasta') != null) {
//            $queryBuilder->andWhere("r.fecha <= '{$session->get('filtroReciboFechaHasta')} 23:59:59'");
//        }
//        if ($session->get('filtroMovimientoTercero')) {
//            $queryBuilder->andWhere("r.codigoTerceroFk = '{$session->get('filtroMovimientoTercero')}'");
//        }
//        $queryBuilder->orderBy("r.codigoReciboPk", 'DESC');
//        return $queryBuilder;
//    }
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
//    /**
//     * @param $id
//     * @return bool
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function liquidar($id)
//    {
//        $em = $this->getEntityManager();
//        $pago = 0;
//        $pagoTotal = 0;
//        $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
//        $arRecibosDetalles = $em->getRepository(CarReciboDetalle::class)->findBy(array('codigoReciboFk' => $id));
//        foreach ($arRecibosDetalles as $arReciboDetalle) {
//            $pago += $arReciboDetalle->getVrPago() * $arReciboDetalle->getOperacion();
//            $pagoTotal += $arReciboDetalle->getVrPagoAfectar();
//        }
//        $arRecibo->setVrPago($pago);
//        $arRecibo->setVrPagoTotal($pagoTotal);
//        $em->persist($arRecibo);
//        $em->flush();
//        return true;
//    }
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