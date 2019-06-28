<?php

namespace App\Repository\Inventario;

use App\Controller\Estructura\FuncionesController;
use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Compra\ComCuentaPagar;
use App\Entity\Compra\ComCuentaPagarTipo;
use App\Entity\General\GenDocumento;
use App\Entity\General\GenDocumentoEmpresa;
use App\Entity\General\GenImpuesto;
use App\Entity\Inventario\InvConfiguracion;
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
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.referencia')
            ->addSelect('m.vrSubtotal')
            ->addSelect('m.vrIva')
            ->addSelect('m.vrTotalNeto')
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
     * @param $arMovimientoDetalles InvMovimientoDetalle
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($arMovimiento)
    {
        $em = $this->getEntityManager();
        $respuesta = '';
        $retencionFuente = $arMovimiento->getTerceroRel()->getRetencionFuente();
        $retencionFuenteSinBase = $arMovimiento->getTerceroRel()->getRetencionFuenteSinBase();
        $vrSubtotalGlobal = 0;
        $vrTotalBrutoGlobal = 0;
        $vrTotalNetoGlobal = 0;
        $vrIvaGlobal = 0;
        $vrTotalGlobal = 0;
        $vrRetencionFuenteGlobal = 0;
        $vrRetencionIvaGlobal = 0;
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(InvMovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
        $arrImpuestoRetenciones = $this->retencion($arMovimientoDetalles, $retencionFuenteSinBase);
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {

            $vrSubtotal = $arMovimientoDetalle->getVrPrecio() * $arMovimientoDetalle->getCantidad();
            $vrIva = ($vrSubtotal * ($arMovimientoDetalle->getPorcentajeIva()) / 100);
            $vrTotalBruto = $vrSubtotal;
            $vrTotal = $vrTotalBruto + $vrIva;
            $vrRetencionFuente = 0;
            $vrTotalGlobal += $vrTotal;
            $vrTotalBrutoGlobal += $vrTotalBruto;
            $vrIvaGlobal += $vrIva;
            $vrSubtotalGlobal += $vrSubtotal;
            if ($arMovimiento->getCodigoDocumentoFk() == 'FAC' || $arMovimiento->getCodigoDocumentoFk() == 'COM') {
                if ($arMovimientoDetalle->getCodigoImpuestoRetencionFk()) {
                    if ($retencionFuente) {
                        if ($arrImpuestoRetenciones[$arMovimientoDetalle->getCodigoImpuestoRetencionFk()]['base'] == true || $retencionFuenteSinBase) {
                            $vrRetencionFuente = $vrSubtotal * $arrImpuestoRetenciones[$arMovimientoDetalle->getCodigoImpuestoRetencionFk()]['porcentaje'] / 100;
                        }
                    }
                }
            }
            $vrRetencionFuenteGlobal += $vrRetencionFuente;
            $arMovimientoDetalle->setVrSubtotal($vrSubtotal);
            $arMovimientoDetalle->setVrIva($vrIva);
            $arMovimientoDetalle->setVrTotal($vrTotal);
            $arMovimientoDetalle->setVrRetencionFuente($vrRetencionFuente);
            $this->getEntityManager()->persist($arMovimientoDetalle);
        }
        //Calcular retenciones en Ventas
        if ($arMovimiento->getCodigoDocumentoFk() == 'FAC') {
            //Liquidar retencion de iva para las ventas, solo los grandes contribuyentes y entidades del estado nos retienen 50% iva
            $arrConfiguracion = $em->getRepository(InvConfiguracion::class)->liquidarMovimiento();
            if ($arMovimiento->getTerceroRel()->getRetencionIva() == 1) {
                //Validacion acordada con Luz Dary de que las devoluciones tambien validen la base
                if ($vrIvaGlobal >= $arrConfiguracion['vrBaseRetencionIvaVenta']) {
                    $vrRetencionIvaGlobal = ($vrIvaGlobal * $arrConfiguracion['porcentajeRetencionIva']) / 100;
                }
            }
        }

        $vrTotalNetoGlobal = $vrTotalGlobal - $vrRetencionFuenteGlobal - $vrRetencionIvaGlobal;
        $arMovimiento->setVrIva($vrIvaGlobal);
        $arMovimiento->setVrSubtotal($vrSubtotalGlobal);
        $arMovimiento->setVrTotalBruto($vrTotalGlobal);
        $arMovimiento->setVrTotalNeto($vrTotalNetoGlobal);
        $arMovimiento->setVrRetencionFuente($vrRetencionFuenteGlobal);
        $arMovimiento->setVrRetencionIva($vrRetencionIvaGlobal);
        $this->getEntityManager()->persist($arMovimiento);
        if ($respuesta == '') {
            $em->flush();
        } else {
            Mensajes::error($respuesta);
        }
    }

    /**
     * @param $arMovimientoDetalles
     * @param $retencionFuenteSinBase
     * @return array
     */
    private function retencion($arMovimientoDetalles, $retencionFuenteSinBase)
    {
        /**
         * @var $arMovimientoDetalle InvMovimientoDetalle
         */
        $em = $this->getEntityManager();
        $arrImpuestoRetenciones = array();
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            if ($arMovimientoDetalle->getCodigoImpuestoRetencionFk()) {
                $vrPrecio = $arMovimientoDetalle->getVrPrecio() - (($arMovimientoDetalle->getVrPrecio()) / 100);
                $vrSubtotal = $vrPrecio * $arMovimientoDetalle->getCantidad();
                if (!array_key_exists($arMovimientoDetalle->getCodigoImpuestoRetencionFk(), $arrImpuestoRetenciones)) {
                    $arrImpuestoRetenciones[$arMovimientoDetalle->getCodigoImpuestoRetencionFk()] = array('codigo' => $arMovimientoDetalle->getCodigoImpuestoRetencionFk(),
                        'valor' => $vrSubtotal, 'base' => false, 'porcentaje' => 0);
                } else {
                    $arrImpuestoRetenciones[$arMovimientoDetalle->getCodigoImpuestoRetencionFk()]['valor'] += $vrSubtotal;
                }
            }
        }

        if ($arrImpuestoRetenciones) {
            foreach ($arrImpuestoRetenciones as $arrImpuestoRetencion) {
                $arImpuesto = $em->getRepository(GenImpuesto::class)->find($arrImpuestoRetencion['codigo']);
                if ($arImpuesto) {
                    if ($arrImpuestoRetencion['valor'] >= $arImpuesto->getBase() || $retencionFuenteSinBase) {
                        $arrImpuestoRetenciones[$arrImpuestoRetencion['codigo']]['base'] = true;
                        $arrImpuestoRetenciones[$arrImpuestoRetencion['codigo']]['porcentaje'] = $arImpuesto->getPorcentaje();
                    }
                }
            }
        }
        return $arrImpuestoRetenciones;
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
        } else {
            Mensajes::error("El registro no tiene detalles");
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
        if ($arMovimiento->getEstadoAnulado() == 0) {
            $this->afectar($arMovimiento);
            $arMovimiento->setEstadoAprobado(1);
            $consecutivo = $em->getRepository(GenDocumento::class)->generarConsecutivo($arMovimiento->getDocumentoRel()->getCodigoDocumentoPk(), $arMovimiento->getCodigoEmpresaFk());
            $arMovimiento->setNumero($consecutivo);
            $arMovimiento->setFecha(new \DateTime('now'));
            if ($arMovimiento->getDocumentoRel()->getCodigoDocumentoPk() == 'FAC') {
                $objFunciones = new FuncionesController();
                $fecha = new \DateTime('now');
                $arMovimiento->setFechaVence($arMovimiento->getPlazoPago() == 0 ? $fecha : $objFunciones->sumarDiasFecha($fecha, $arMovimiento->getPlazoPago()));
            }
            if ($arMovimiento->getDocumentoRel()->getGeneraCartera()) {
                $arCuentaCobrarTipo = $em->getRepository(CarCuentaCobrarTipo::class)->find($arMovimiento->getDocumentoRel()->getCodigoCuentaCobrarTipoFk());
                $arCuentaCobrar = New CarCuentaCobrar();
                $arCuentaCobrar->setCuentaCobrarTipoRel($arCuentaCobrarTipo);
                $arCuentaCobrar->setTerceroRel($arMovimiento->getTerceroRel());
                $arCuentaCobrar->setVrSubtotal($arMovimiento->getVrSubtotal());
                $arCuentaCobrar->setVrTotalBruto($arMovimiento->getVrTotalBruto());
                $arCuentaCobrar->setVrIva($arMovimiento->getVrIva());
                $arCuentaCobrar->setNumeroDocumento($arMovimiento->getNumero());
                $arCuentaCobrar->setFecha($arMovimiento->getFecha());
                $arCuentaCobrar->setFechaVence($arMovimiento->getFechaVence());
                $arCuentaCobrar->setOperacion($arCuentaCobrarTipo->getOperacion());
                $arCuentaCobrar->setCodigoEmpresaFk($arMovimiento->getCodigoEmpresaFk());
                $arCuentaCobrar->setVrRetencionIva($arMovimiento->getVrRetencionIva());
                $arrConfiguracion = $em->getRepository(InvConfiguracion::class)->aprobarMovimiento();
                $saldo = $arMovimiento->getVrTotalNeto();
                if ($arrConfiguracion['impuestoRecaudo']) {
                    $saldo = $arMovimiento->getVrTotalBruto();
                    $arCuentaCobrar->setVrRetencionFuente($arMovimiento->getVrRetencionFuente());
                }
                $arCuentaCobrar->setVrSaldoOriginal($saldo);
                $arCuentaCobrar->setVrSaldo($saldo);
                $arCuentaCobrar->setVrSaldoOperado($saldo * $arCuentaCobrarTipo->getOperacion());
                $arCuentaCobrar->setEstadoAutorizado(1);
                $arCuentaCobrar->setEstadoAprobado(1);
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
                $arCuentaPagar->setEstadoAprobado(1);
                $em->persist($arCuentaPagar);
            }
            $em->persist($arMovimiento);
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
            if ($arItem->getAfectaInventario() == true) {
                $existenciaAnterior = $arItem->getCantidadExistencia();
                if ($arMovimiento->getDocumentoRel()->getOperacionInventario() == -1) {
                    $arItem->setCantidadExistencia($existenciaAnterior - $arMovimientoDetalle->getCantidad());
                } elseif ($arMovimiento->getDocumentoRel()->getOperacionInventario() == 1) {
                    $arItem->setCantidadExistencia($existenciaAnterior + $arMovimientoDetalle->getCantidad());
                }
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