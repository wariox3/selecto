<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Entity\Cartera\CarReciboTipo;
use App\Entity\Compra\ComCuentaPagar;
use App\Entity\Compra\ComEgreso;
use App\Entity\Compra\ComEgresoDetalle;
use App\Entity\General\GenConfiguracion;
use App\Entity\General\GenDocumento;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class ComEgresoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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

    /**
     * @param $arEgreso ComEgreso
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function autorizar($arEgreso)
    {
        $em = $this->getEntityManager();
        $error = false;
        $arEgresoDetalles = $em->getRepository(ComEgresoDetalle::class)->findBy(array('codigoEgresoFk' => $arEgreso->getCodigoEgresoPk()));
        if (count($em->getRepository(ComEgresoDetalle::class)->findBy(['codigoEgresoFk' => $arEgreso->getCodigoEgresoPk()])) > 0) {
            foreach ($arEgresoDetalles AS $arEgresoDetalle) {
                $arCuentaPagar = $em->getRepository(ComCuentaPagar::class)->find($arEgresoDetalle->getCodigoCuentaPagarFk());
                if ($arEgresoDetalle->getVrPagoAfectar() < 0) {
                    Mensajes::error("Error detalle ID: " . $arEgresoDetalle->getCodigoEgresoDetallePk() . " el pago a afectar es menor que cero");
                    $error = true;
                    break;
                }
                if ($arCuentaPagar->getVrSaldo() >= $arEgresoDetalle->getVrPagoAfectar()) {
                    $saldo = $arCuentaPagar->getVrSaldo() - $arEgresoDetalle->getVrPagoAfectar();
                    $saldoOperado = $saldo * $arCuentaPagar->getOperacion();
                    $arCuentaPagar->setVrSaldo($saldo);
                    $arCuentaPagar->setVrSaldoOperado($saldoOperado);
                    $arCuentaPagar->setVrAbono($arCuentaPagar->getVrAbono() + $arEgresoDetalle->getVrPagoAfectar());
                    $em->persist($arCuentaPagar);
                } else {
                    Mensajes::error("Error detalle ID: " . $arEgresoDetalle->getCodigEgresoDetallePk() . "el saldo " . $arCuentaPagar->getVrSaldo() . " de la cuenta por cobrar numero: " . $arCuentaCobrar->getNumeroDocumento() . " es menor al ingresado " . $arReciboDetalle->getVrPagoAfectar());
                    $error = true;
                    break;
                }
                if ($error == false) {
                    $arEgreso->setEstadoAutorizado(1);
                    $em->persist($arEgreso);
                    $em->flush();
                }
            }
        }
    }

    /**
     * @param $arEgreso ComEgreso
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function desautorizar($arEgreso)
    {
        $em = $this->getEntityManager();
        $arEgresoDetalles = $em->getRepository(ComEgresoDetalle::class)->findBy(array('codigoEgresoFk' => $arEgreso->getCodigoEgresoPk()));
        foreach ($arEgresoDetalles AS $arEgresoDetalle) {
            $arCuentaPagar = $em->getRepository(ComCuentaPagar::class)->find($arEgresoDetalle->getCodigoCuentaPagarFk());
            $saldo = $arCuentaPagar->getVrSaldo() + $arEgresoDetalle->getVrPagoAfectar();
            $saldoOperado = $saldo * $arCuentaPagar->getOperacion();
            $arCuentaPagar->setVrSaldo($saldo);
            $arCuentaPagar->setVrSaldoOperado($saldoOperado);
            $arCuentaPagar->setVrAbono($arCuentaPagar->getVrAbono() - $arEgresoDetalle->getVrPagoAfectar());
            $em->persist($arCuentaPagar);
        }
        $arEgreso->setEstadoAutorizado(0);
        $em->persist($arEgreso);
        $em->flush();
    }

    /**
     * @param $codigoEgreso ComEgreso
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function contarDetalles($codigoEgreso)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComEgresoDetalle::class, 'ed')
            ->select("COUNT(ed.codigoEgresoDetallePk)")
            ->where("ed.codigoEgresoFk = {$codigoEgreso} ");
        $resultado = $queryBuilder->getQuery()->getSingleResult();
        return $resultado[1];
    }
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

    /**
     * @param $arEgreso ComEgreso
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function aprobar($arEgreso)
    {
        $em = $this->getEntityManager();
        if ($arEgreso->getEstadoAutorizado()) {
            $consecutivo = $em->getRepository(GenDocumento::class)->generarConsecutivo($arEgreso->getCodigoDocumentoFk(), $arEgreso->getCodigoEmpresaFk());
            $arEgreso->setNumero($consecutivo);
            $arEgreso->setEstadoAprobado(1);
            $em->persist($arEgreso);
            $em->flush();
        } else {
            Mensajes::error("El registro no se encuentra autorizado");
        }
    }
}