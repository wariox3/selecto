<?php

namespace App\Repository\Inventario;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Compra\ComCuentaPagar;
use App\Entity\Compra\ComCuentaPagarTipo;
use App\Entity\Inventario\InvDocumento;
use App\Entity\Inventario\InvItem;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class InvMovimientoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvMovimiento::class);
    }

    public function lista($documento, $empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvMovimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.fecha')
            ->addSelect('m.estadoAutorizado')
            ->addSelect('m.estadoAprobado')
            ->addSelect('m.estadoAnulado')
            ->addSelect('t.nombreCorto AS tercero')
            ->leftJoin('m.terceroRel', 't')
            ->where("m.codigoDocumentoFk = '" . $documento . "'")
        ->andWhere('m.codigoEmpresaFk = ' . $empresa);
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
     * @param $arMovimiento InvMovimiento
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($arMovimiento)
    {
        $em = $this->getEntityManager();
        $vrSubtotalGlobal = 0;
        $vrTotalBrutoGlobal = 0;
        $vrIvaGlobal = 0;
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(InvMovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
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
     * @param $arMovimiento InvMovimiento
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function autorizar($arMovimiento)
    {
        if ($this->getEntityManager()->getRepository(InvMovimiento::class)->contarDetalles($arMovimiento->getCodigoMovimientoPk()) > 0) {
            $arMovimiento->setEstadoAutorizado(1);
            $this->getEntityManager()->persist($arMovimiento);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $arMovimiento InvMovimiento
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function aprobar($arMovimiento)
    {
        $em = $this->getEntityManager();
        $arDocumento = $em->getRepository(InvDocumento::class)->find($arMovimiento->getCodigoDocumentoFk());
        if ($arMovimiento->getEstadoAnulado() == 0) {
            $this->afectar($arMovimiento);
            $arMovimiento->setEstadoAprobado(1);
            $arDocumento->setConsecutivo($arDocumento->getConsecutivo() + 1);
            $arMovimiento->setNumero($arDocumento->getConsecutivo());
            if ($arMovimiento->getDocumentoRel()->getGeneraCartera()) {
                $arCuentaCobrarTipo = $em->getRepository(CarCuentaCobrarTipo::class)->find($arMovimiento->getDocumentoRel()->getCodigoCuentaCobrarTipoFk());
                $arCuentaCobrar = New CarCuentaCobrar();
                $arCuentaCobrar->setCuentaCobroTipoRel($arCuentaCobrarTipo);
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
                $arCuentaCobrar->setCodigoEmpresaFk($arMovimiento->getCodigoEmpresaFk());
                $arCuentaCobrar->setVrSaldoOperado($arCuentaCobrar->getVrSaldo() * $arCuentaCobrar->getOperacion());
                $arCuentaCobrar->setEstadoAutorizado(1);
                $em->persist($arCuentaCobrar);
            }
            if ($arMovimiento->getDocumentoRel()->getGeneraTesoreria()) {
                $arCuentaPagarTipo = $em->getRepository(ComCuentaPagarTipo::class)->find($arMovimiento->getDocumentoRel()->getCodigoCuentaPagarTipoFk());
                $arCuentaPagar = New ComCuentaPagar();
                $arCuentaPagar->setCuentaPagarTipoRel($arCuentaPagarTipo);
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
                $arCuentaPagar->setCodigoEmpresaFk($arMovimiento->getCodigoEmpresaFk());
                $arCuentaPagar->setVrSaldoOperado($arCuentaPagar->getVrSaldo() * $arCuentaPagar->getOperacion());
                $arCuentaPagar->setEstadoAutorizado(1);
                $em->persist($arCuentaPagar);
            }
            $this->getEntityManager()->persist($arMovimiento);
            $this->getEntityManager()->flush();
        } else {
            Mensajes::error('El registro se encuentra anulado');
        }
    }

    /**
     * @param $arMovimiento InvMovimiento
     * @param $arItem InvItem
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function afectar($arMovimiento)
    {

        $em = $this->getEntityManager();
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(InvMovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
        foreach ($arMovimientoDetalles AS $arMovimientoDetalle) {
            $arItem = $this->getEntityManager()->getRepository(InvItem::class)->find($arMovimientoDetalle->getCodigoItemFk());
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
     * @param $arMovimiento InvMovimiento
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
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvMovimientoDetalle::class, 'md')
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
            'class' => InvMovimiento::class,
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
            $array['data'] = $this->getEntityManager()->getReference(InvMovimiento::class, $session->get('filtroMovimiento'));
        }
        return $array;
    }
}