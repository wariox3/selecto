<?php

namespace App\Repository;

use App\Entity\CuentaCobrar;
use App\Entity\CuentaCobrarTipo;
use App\Entity\CuentaPagar;
use App\Entity\CuentaPagarTipo;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class MovimientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movimiento::class);
    }

    public function lista($documento)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.fecha')
            ->addSelect('t.nombreCorto AS tercero')
            ->leftJoin('m.terceroRel', 't')
            ->where("m.codigoDocumentoFk = '" . $documento . "'");
        if ($session->get('filtroMovimientoFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('filtroMovimientoFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroMovimientoFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('filtroMovimientoFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroMovimientoTercero')) {
            $queryBuilder->andWhere("m.codigoTerceroFk = '{$session->get('filtroMovimientoTercero')}'");
        }
        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
        return $queryBuilder;
    }

    /**
     * @param $arMovimiento Movimiento
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($arMovimiento)
    {
        $em = $this->getEntityManager();
        $vrSubtotalGlobal = 0;
        $vrTotalBrutoGlobal = 0;
        $vrIvaGlobal = 0;
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(MovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $vrSubtotal = $arMovimientoDetalle->getVrSubtotal();
            $vrSubtotalGlobal += $vrSubtotal;
            $vrTotal = $arMovimientoDetalle->getVrTotal();
            $vrTotalBrutoGlobal += $vrTotal;
            $vrIva = $arMovimientoDetalle->getVrIva();
            $vrIvaGlobal += $vrIva;
        }
        $arMovimiento->setVrSubtotal($vrSubtotalGlobal);
        $arMovimiento->setVrTotalBruto($vrTotalBrutoGlobal);
        $arMovimiento->setVrIva($vrIvaGlobal);
        $arMovimiento->setVrTotalNeto($vrTotalBrutoGlobal);
        $em->persist($arMovimiento);
        $em->flush();
    }

    /**
     * @param $arMovimiento Movimiento
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function autorizar($arMovimiento)
    {
        if ($this->getEntityManager()->getRepository(Movimiento::class)->contarDetalles($arMovimiento->getCodigoMovimientoPk()) > 0) {
            $arMovimiento->setEstadoAutorizado(1);
            $this->getEntityManager()->persist($arMovimiento);
            $this->getEntityManager()->flush();
        } else {
            Mensajes::error('El registro no tiene detalles');
        }
    }

    /**
     * @param $arMovimiento Movimiento
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function aprobar($arMovimiento)
    {
        $em = $this->getEntityManager();
        if ($arMovimiento->getEstadoAnulado() == 0) {
            $this->afectar($arMovimiento);
            $arMovimiento->setEstadoAprobado(1);
            if ($arMovimiento->getDocumentoRel()->getGeneraCartera()) {
                if ($arMovimiento->getCodigoDocumentoFk() == 'COM') {
                    $arCuentaPagarTipo = $em->getRepository(CuentaPagarTipo::class)->find($arMovimiento->getDocumentoRel()->getCodigoCuentaPagarTipoFk());
                    $arCuentaPagar = New CuentaPagar();
                    $arCuentaPagar->setTerceroRel($arMovimiento->getTerceroRel());
                    $arCuentaPagar->setVrSubtotal($arMovimiento->getVrSubtotal());
                    $arCuentaPagar->setVrTotalBruto($arMovimiento->getVrTotalBruto());
                    $arCuentaPagar->setVrIva($arMovimiento->getVrIva());
                    $arCuentaPagar->setNumeroDocumento($arMovimiento->getNumero());
                    $arCuentaPagar->setFecha($arMovimiento->getFecha());
                    $arCuentaPagar->setFechaVence($arMovimiento->getFecha());
                    $arCuentaPagar->setVrSaldo($arMovimiento->getVrTotalNeto());
                    $arCuentaPagar->setVrSaldoOriginal($arMovimiento->getVrTotalNeto());
                    $arCuentaPagar->setOperacion($arCuentaPagarTipo->getOperacion());
                    $arCuentaPagar->setVrSaldoOperado($arCuentaPagar->getVrSaldo() * $arCuentaPagar->getOperacion());
                    $arCuentaPagar->setEstadoAutorizado(1);
                    $em->persist($arCuentaPagar);
                } else {
                    $arCuentaCobrarTipo = $em->getRepository(CuentaCobrarTipo::class)->find($arMovimiento->getDocumentoRel()->getCodigoCuentaCobrarTipoFk());
                    $arCuentaCobrar = New CuentaCobrar();
                    $arCuentaCobrar->setTerceroRel($arMovimiento->getTerceroRel());
                    $arCuentaCobrar->setVrSubtotal($arMovimiento->getVrSubtotal());
                    $arCuentaCobrar->setVrTotalBruto($arMovimiento->getVrTotalBruto());
                    $arCuentaCobrar->setVrIva($arMovimiento->getVrIva());
                    $arCuentaCobrar->setNumeroDocumento($arMovimiento->getNumero());
                    $arCuentaCobrar->setFecha($arMovimiento->getFecha());
                    $arCuentaCobrar->setFechaVence($arMovimiento->getFecha());
                    $arCuentaCobrar->setVrSaldo($arMovimiento->getVrTotalNeto());
                    $arCuentaCobrar->setVrSaldoOriginal($arMovimiento->getVrTotalNeto());
                    $arCuentaCobrar->setOperacion($arCuentaCobrarTipo->getOperacion());
                    $arCuentaCobrar->setVrSaldoOperado($arCuentaCobrar->getVrSaldo() * $arCuentaCobrar->getOperacion());
                    $arCuentaCobrar->setEstadoAutorizado(1);
                    $em->persist($arCuentaCobrar);
                }

            }
            $this->getEntityManager()->persist($arMovimiento);
            $this->getEntityManager()->flush();
        } else {
            Mensajes::error('El registro se encuentra anulado');
        }
    }

    /**
     * @param $arMovimiento Movimiento
     * @param $arItem Item
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function afectar($arMovimiento)
    {

        $em = $this->getEntityManager();
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(MovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
        foreach ($arMovimientoDetalles AS $arMovimientoDetalle) {
            $arItem = $this->getEntityManager()->getRepository(Item::class)->find($arMovimientoDetalle->getCodigoItemFk());
            $existenciaAnterior = $arItem->getCantidadExistencia();
            if ($arMovimiento->getDocumentoRel()->getOperacionInventario() == -1) {
                $arItem->setCantidadExistencia($existenciaAnterior - $arMovimientoDetalle->getCantidad());
            } elseif ($arMovimiento->getDocumentoRel()->getOperacionInventario() == 1) {
                $arItem->setCantidadExistencia($existenciaAnterior + $arMovimientoDetalle->getCantidad());
            }
            $em->persist($arItem);
            $em->flush();
        }
    }

    /**
     * @param $arMovimiento Movimiento
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function desautorizar($arMovimiento)
    {
        if ($arMovimiento->getEstadoAprobado() == 0) {
            $arMovimiento->setEstadoAutorizado(0);
            $this->getEntityManager()->persist($arMovimiento);
            $this->getEntityManager()->flush();

        } else {
            Mensajes::error('El registro ya se encuentra aprobado');
        }
    }

    /**
     * @param $codigoMovimiento
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function contarDetalles($codigoMovimiento)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(MovimientoDetalle::class, 'md')
            ->select("COUNT(md.codigoMovimientoDetallePk)")
            ->where("md.codigoMovimientoFk = {$codigoMovimiento} ");
        $resultado = $queryBuilder->getQuery()->getSingleResult();
        return $resultado[1];
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
    public function llenarCombo()
    {
        $session = new Session();
        $array = [
            'class' => Movimiento::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->orderBy('m.numero', 'ASC');
            },
            'choice_label' => 'numero',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroMovimiento')) {
            $array['data'] = $this->getEntityManager()->getReference(Movimiento::class, $session->get('filtroMovimiento'));
        }
        return $array;
    }
}