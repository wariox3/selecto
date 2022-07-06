<?php

namespace App\Repository;

use App\Controller\Estructura\FuncionesController;

use App\Entity\Configuracion;
use App\Entity\Empresa;
use App\Entity\FormaPago;
use App\Entity\Impuesto;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Entity\MovimientoTipo;
use App\Entity\Tercero;
use App\Entity\Usuario;
use App\Formatos\Compra;
use App\Formatos\Entrada;
use App\Formatos\Factura;
use App\Formatos\Factura1;
use App\Formatos\Salida;
use App\Utilidades\FacturaElectronica;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class MovimientoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movimiento::class);
    }

    public function lista($movimientoTipo, $empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
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
            ->addSelect('m.codigoTerceroFk')
            ->addSelect('t.nombreCorto AS terceroNombreCorto')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('cc.nombre as centroCostoNombre')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.centroCostoRel', 'cc')
            ->where("m.codigoMovimientoTipoFk = '" . $movimientoTipo . "'")
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
        return $queryBuilder->getQuery()->getResult();
    }

    public function listaReferencia($codigoTercero, $empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
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
            ->where("m.codigoTerceroFk = '" . $codigoTercero . "'")
            ->andWhere('m.codigoEmpresaFk = ' . $empresa)
            ->andWhere("m.codigoMovimientoTipoFk = 'FAC'")
            ->andWhere('m.estadoAprobado = 1');
        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
        return $queryBuilder;
    }

    public function facturaElectronicaPendiente($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.referencia')
            ->addSelect('m.vrSubtotal')
            ->addSelect('m.vrBaseIva')
            ->addSelect('m.vrIva')
            ->addSelect('m.vrTotalNeto')
            ->addSelect('m.estadoAutorizado')
            ->addSelect('m.estadoAprobado')
            ->addSelect('m.estadoAnulado')
            ->addSelect('t.nombreCorto AS terceroNombreCorto')
            ->addSelect('t.codigoPostal as terceroCodigoPostal')
            ->addSelect('t.correoFacturaElectronica as terceroCorreoFacturaElectronica')
            ->addSelect('d.nombre AS documentoNombre')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.movimientoTipoRel', 'd')
            ->where("m.codigoMovimientoTipoFk = 'FAC' OR m.codigoMovimientoTipoFk = 'NC' OR m.codigoMovimientoTipoFk = 'ND'")
            ->andWhere('m.codigoEmpresaFk = ' . $empresa)
            ->andWhere('m.estadoElectronico = 0')
            ->andWhere('m.estadoAprobado = 1');
        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
        return $queryBuilder;
    }

    /**
     * @param $arMovimiento Movimiento
     * @param $arMovimientoDetalles MovimientoDetalle
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($arMovimiento)
    {
        $em = $this->getEntityManager();
        $respuesta = '';
        $retencionFuente = $arMovimiento->getTerceroRel()->isRetencionFuente();
        $retencionFuenteSinBase = $arMovimiento->getTerceroRel()->isRetencionFuenteSinBase();
        $vrSubtotalGlobal = 0;
        $vrTotalBrutoGlobal = 0;
        $vrBaseIvaGlobal = 0;
        $vrIvaGlobal = 0;
        $vrTotalGlobal = 0;
        $vrRetencionFuenteGlobal = 0;
        $vrRetencionIvaGlobal = 0;
        $arMovimientoDetalles = $this->getEntityManager()->getRepository(MovimientoDetalle::class)->findBy(['codigoMovimientoFk' => $arMovimiento->getCodigoMovimientoPk()]);
        $arrImpuestoRetenciones = $this->retencion($arMovimientoDetalles, $retencionFuenteSinBase);
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $vrBaseIva = 0;
            $vrIva = 0;
            $vrSubtotal = ($arMovimientoDetalle->getVrPrecio() - ($arMovimientoDetalle->getVrPrecio() * $arMovimientoDetalle->getPorcentajeDescuento() / 100)) * $arMovimientoDetalle->getCantidad();
            if ($arMovimientoDetalle->getCodigoImpuestoIvaFk()) {
                if ($arMovimientoDetalle->getCodigoImpuestoIvaFk() != 'I00') {
                    $vrBaseIva = $vrSubtotal;
                    $vrIva = ($vrSubtotal * ($arMovimientoDetalle->getPorcentajeIva()) / 100);
                }
            }
            $vrTotalBruto = $vrSubtotal;
            $vrTotal = $vrTotalBruto + $vrIva;
            $vrRetencionFuente = 0;
            $vrTotalGlobal += $vrTotal;
            $vrTotalBrutoGlobal += $vrTotalBruto;
            $vrBaseIvaGlobal += $vrBaseIva;
            $vrIvaGlobal += $vrIva;
            $vrSubtotalGlobal += $vrSubtotal;

            if ($arMovimiento->getcodigoMovimientoTipoFk() == 'FAC' || $arMovimiento->getCodigoMovimientoTipoFk() == 'COM') {
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
            $arMovimientoDetalle->setVrBaseIva($vrBaseIva);
            $arMovimientoDetalle->setVrIva($vrIva);
            $arMovimientoDetalle->setVrTotal($vrTotal);
            $arMovimientoDetalle->setVrRetencionFuente($vrRetencionFuente);
            $this->getEntityManager()->persist($arMovimientoDetalle);
        }
        //Calcular retenciones en Ventas
        if ($arMovimiento->getCodigoMovimientoTipoFk() == 'FAC') {
            //Liquidar retencion de iva para las ventas, solo los grandes contribuyentes y entidades del estado nos retienen 50% iva
            $arrConfiguracion = $em->getRepository(Configuracion::class)->liquidarMovimiento();
            if ($arMovimiento->getTerceroRel()->isRetencionIva() == 1) {
                //Validacion acordada con Luz Dary de que las devoluciones tambien validen la base
                if ($vrIvaGlobal >= $arrConfiguracion['vrBaseRetencionIvaVenta']) {
                    $vrRetencionIvaGlobal = ($vrIvaGlobal * $arrConfiguracion['porcentajeRetencionIva']) / 100;
                }
            }
        }

        $vrTotalNetoGlobal = $vrTotalGlobal - $vrRetencionFuenteGlobal - $vrRetencionIvaGlobal;
        $arMovimiento->setVrBaseIva($vrBaseIvaGlobal);
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
         * @var $arMovimientoDetalle MovimientoDetalle
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
                $arImpuesto = $em->getRepository(Impuesto::class)->find($arrImpuestoRetencion['codigo']);
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
            Mensajes::error("El registro no tiene detalles");
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
        if ($arMovimiento->isEstadoAnulado() == 0) {
            $this->afectar($arMovimiento);
            $arMovimiento->setEstadoAprobado(1);
            if ($arMovimiento->getNumero() == 0) {
                $consecutivo = $em->getRepository(MovimientoTipo::class)->generarConsecutivo($arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk(), $arMovimiento->getCodigoEmpresaFk());
                $arMovimiento->setNumero($consecutivo);
                $arMovimiento->setFecha(new \DateTime('now'));
            }

            if ($arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk() == 'FAC' || $arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk() == 'NC' || $arMovimiento->getMovimientoTipoRel()->getCodigoMovimientoTipoPk() == 'ND') {
                $objFunciones = new FuncionesController();
                $fecha = new \DateTime('now');
                $arMovimiento->setFechaVence($arMovimiento->getPlazoPago() == 0 ? $fecha : $objFunciones->sumarDiasFecha($fecha, $arMovimiento->getPlazoPago()));
            }
            if ($arMovimiento->getMovimientoTipoRel()->isGeneraCartera()) {
                /*if($arMovimiento->getDocumentoRel()->getCodigoCuentaCobrarTipoFk()) {
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
                }*/
            }
            if ($arMovimiento->getMovimientoTipoRel()->isGeneraTesoreria()) {
                /*if($arMovimiento->getDocumentoRel()->getCodigoCuentaPagarTipoFk()) {
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
                }*/
            }
            $em->persist($arMovimiento);
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
        foreach ($arMovimientoDetalles as $arMovimientoDetalle) {
            $arItem = $this->getEntityManager()->getRepository(Item::class)->find($arMovimientoDetalle->getCodigoItemFk());
            if ($arItem->isAfectaInventario() == true) {
                $existenciaAnterior = $arItem->getCantidadExistencia();
                if ($arMovimiento->getMovimientoTipoRel()->getOperacionInventario() == -1) {
                    $arItem->setCantidadExistencia($existenciaAnterior - $arMovimientoDetalle->getCantidad());
                } elseif ($arMovimiento->getMovimientoTipoRel()->getOperacionInventario() == 1) {
                    $arItem->setCantidadExistencia($existenciaAnterior + $arMovimientoDetalle->getCantidad());
                }
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
        if ($arMovimiento->isEstadoAprobado() == 0) {
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

    public function movimientoFacturaElectronica($codigoMovimiento)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.fechaVence')
            ->addSelect('m.vrSubtotal')
            ->addSelect('m.vrBaseIva')
            ->addSelect('m.vrIva')
            ->addSelect('m.vrTotalBruto')
            ->addSelect('m.estadoAprobado')
            ->addSelect('m.estadoElectronico')
            ->addSelect('m.codigoMovimientoTipoFk')
            ->addSelect('m.cue')
            ->addSelect('i.codigoEntidad as tipoIdentificacion')
            ->addSelect('t.numeroIdentificacion as numeroIdentificacion')
            ->addSelect('t.digitoVerificacion as digitoVerificacion')
            ->addSelect('t.nombreCorto as nombreCorto')
            ->addSelect('t.direccion')
            ->addSelect('t.correoFacturaElectronica as email')
            ->addSelect('t.barrio')
            ->addSelect('t.codigoPostal')
            ->addSelect('t.telefono')
            ->addSelect('t.codigoCIUU')
            ->addSelect('tp.codigoInterface as tipoPersona')
            ->addSelect('r.codigoInterface as regimen')
            ->addSelect('rs.numero as resolucionNumero')
            ->addSelect('rs.prefijo as resolucionPrefijo')
            ->addSelect('rs.fechaDesde as resolucionFechaDesde')
            ->addSelect('rs.fechaHasta as resolucionFechaHasta')
            ->addSelect('rs.numeroDesde as resolucionNumeroDesde')
            ->addSelect('rs.numeroHasta as resolucionNumeroHasta')
            ->addSelect('rs.ambiente as resolucionAmbiente')
            ->addSelect('ciu.nombre as ciudadNombre')
            ->addSelect('ciu.codigoDaneCompleto as ciudadCodigoDaneCompleto')
            ->addSelect('dep.nombre as departamentoNombre')
            ->addSelect('dep.codigoDaneMascara as departamentoCodigoDaneMascara')
            ->addSelect('mr.cue as referenciaCue')
            ->addSelect('mr.numero as referenciaNumero')
            ->addSelect('mrrs.prefijo as referenciaPrefijo')
            ->addSelect('mr.fecha as referenciaFecha')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.resolucionRel', 'rs')
            ->leftJoin('m.movimientoRel', 'mr')
            ->leftJoin('mr.resolucionRel', 'mrrs')
            ->leftJoin('t.identificacionRel', 'i')
            ->leftJoin('t.tipoPersonaRel', 'tp')
            ->leftJoin('t.regimenRel', 'r')
            ->leftJoin('t.ciudadRel', 'ciu')
            ->leftJoin('ciu.departamentoRel', 'dep')
            ->where("m.codigoMovimientoPk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        if ($arrMovimiento) {
            $arrMovimiento = $arrMovimiento[0];
        }
        return $arrMovimiento;
    }

    public function movimientoCorreoElectronica($codigoMovimiento)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.codigoExterno')
            ->addSelect('m.codigoMovimientoTipoFk as doc_tipo')
            ->addSelect('m.cue')
            ->addSelect('m.numero as doc_numero')
            ->addSelect('m.fecha')
            ->addSelect('m.vrTotalNeto')
            ->addSelect('ter.correoFacturaElectronica')
            ->addSelect('ter.nombreCorto as adquiriente')
            ->addSelect('r.prefijo as res_prefijo')
            ->leftJoin('m.terceroRel', 'ter')
            ->leftJoin('m.resolucionRel', 'r')
            ->where("m.codigoMovimientoPk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        if ($arrMovimiento) {
            $arrMovimiento = $arrMovimiento[0];
        }
        return $arrMovimiento;
    }

    public function facturaElectronica($arr, $codigoEmpresa): bool
    {
        $em = $this->getEntityManager();
        if ($arr) {
            $arrConfiguracion = $em->getRepository(Empresa::class)->facturaElectronica($codigoEmpresa);
            foreach ($arr as $codigo) {
                $arFactura = $em->getRepository(Movimiento::class)->movimientoFacturaElectronica($codigo);
                if ($arFactura['estadoAprobado'] && !$arFactura['estadoElectronico']) {
                    $arrFactura = [
                        'dat_suscriptor' => $arrConfiguracion['suscriptor'],
                        'dat_nitFacturador' => $arrConfiguracion['nit'],
                        'dat_tipoAmbiente' => $arFactura['resolucionAmbiente'],
                        'res_numero' => $arFactura['resolucionNumero'],
                        'res_prefijo' => $arFactura['resolucionPrefijo'],
                        'res_fechaDesde' => $arFactura['resolucionFechaDesde'] ? $arFactura['resolucionFechaDesde']->format('Y-m-d') : null,
                        'res_fechaHasta' => $arFactura['resolucionFechaHasta'] ? $arFactura['resolucionFechaHasta']->format('Y-m-d') : null,
                        'res_desde' => $arFactura['resolucionNumeroDesde'],
                        'res_hasta' => $arFactura['resolucionNumeroHasta'],
                        'doc_codigo' => $arFactura['codigoMovimientoPk'],
                        'doc_tipo' => $arFactura['codigoMovimientoTipoFk'],
                        'doc_codigoDocumento' => $arFactura['codigoMovimientoTipoFk'],
                        'doc_cue' => $arFactura['cue'],
                        'doc_numero' => $arFactura['numero'],
                        'doc_fecha' => $arFactura['fecha']->format('Y-m-d'),
                        'doc_fecha_vence' => $arFactura['fechaVence']->format('Y-m-d'),
                        'doc_hora' => '12:00:00-05:00',
                        'doc_hora2' => '12:00:00',
                        'doc_subtotal' => number_format($arFactura['vrSubtotal'], 2, '.', ''),
                        'doc_baseIva' => number_format($arFactura['vrBaseIva'], 2, '.', ''),
                        'doc_iva' => number_format($arFactura['vrIva'], 2, '.', ''),
                        'doc_inc' => number_format(0, 2, '.', ''),
                        'doc_ica' => number_format(0, 2, '.', ''),
                        'doc_total' => number_format($arFactura['vrTotalBruto'], 2, '.', ''),
                        'ref_cue' => $arFactura['referenciaCue'],
                        'ref_numero' => $arFactura['referenciaNumero'],
                        'ref_prefijo' => $arFactura['referenciaPrefijo'],
                        'ref_fecha' => $arFactura['referenciaFecha'] ? $arFactura['referenciaFecha']->format('Y-m-d') : null,
                        'em_tipoPersona' => $arrConfiguracion['tipoPersona'],
                        'em_numeroIdentificacion' => $arrConfiguracion['nit'],
                        'em_digitoVerificacion' => $arrConfiguracion['digitoVerificacion'],
                        'em_nombreCompleto' => $arrConfiguracion['nombre'],
                        'em_matriculaMercantil' => $arrConfiguracion['matriculaMercantil'],
                        'em_codigoCiudad' => $arrConfiguracion['ciudadCodigoDaneCompleto'],
                        'em_nombreCiudad' => $arrConfiguracion['ciudadNombre'],
                        'em_codigoPostal' => '055460',
                        'em_codigoDepartamento' => $arrConfiguracion['departamentoCodigoDaneMascara'],
                        'em_nombreDepartamento' => $arrConfiguracion['departamentoNombre'],
                        'em_correo' => $arrConfiguracion['correo'],
                        'em_direccion' => $arrConfiguracion['direccion'],
                        'ad_tipoIdentificacion' => $arFactura['tipoIdentificacion'],
                        'ad_numeroIdentificacion' => $arFactura['numeroIdentificacion'],
                        'ad_digitoVerificacion' => $arFactura['digitoVerificacion'],
                        'ad_nombreCompleto' => $arFactura['nombreCorto'],
                        'ad_tipoPersona' => $arFactura['tipoPersona'],
                        'ad_regimen' => $arFactura['regimen'],
                        'ad_responsabilidadFiscal' => '',
                        'ad_direccion' => $arFactura['direccion'],
                        'ad_barrio' => $arFactura['barrio'],
                        'ad_codigoPostal' => $arFactura['codigoPostal'],
                        'ad_telefono' => $arFactura['telefono'],
                        'ad_correo' => $arFactura['email'],
                        'ad_codigoCIUU' => $arFactura['codigoCIUU'],
                        'ad_codigoCiudad' => $arrConfiguracion['ciudadCodigoDaneCompleto'],
                        'ad_nombreCiudad' => $arrConfiguracion['ciudadNombre'],
                        'ad_codigoDepartamento' => $arrConfiguracion['departamentoCodigoDaneMascara'],
                        'ad_nombreDepartamento' => $arrConfiguracion['departamentoNombre'],
                    ];
                    $arrItem = [];
                    $cantidadItemes = 0;
                    $arFacturaDetalles = $em->getRepository(MovimientoDetalle::class)->facturaElectronica($arFactura['codigoMovimientoPk']);
                    foreach ($arFacturaDetalles as $arFacturaDetalle) {
                        $cantidadItemes++;
                        $arrItem[] = [
                            "item_id" => $cantidadItemes,
                            "item_codigo" => $arFacturaDetalle['codigoItemFk'],
                            "item_nombre" => $arFacturaDetalle['itemNombre'],
                            "item_cantidad" => number_format($arFacturaDetalle['cantidad'], 2, '.', ''),
                            "item_precio" => number_format($arFacturaDetalle['vrPrecio'], 2, '.', ''),
                            "item_subtotal" => number_format($arFacturaDetalle['vrSubtotal'], 2, '.', ''),
                            "item_baseIva" => number_format($arFacturaDetalle['vrBaseIva'], 2, '.', ''),
                            "item_iva" => number_format($arFacturaDetalle['vrIva'], 2, '.', ''),
                            "item_porcentaje_iva" => number_format($arFacturaDetalle['porcentajeIva'], 2, '.', '')
                        ];
                    }
                    $arrFactura['doc_itemes'] = $arrItem;
                    $arrFactura['doc_cantidad_item'] = $cantidadItemes;
                    $facturaElectronica = new FacturaElectronica($em);
                    $respuesta = $facturaElectronica->validarDatos($arrFactura);
                    if ($respuesta['estado'] == 'ok') {
                        $procesoFacturaElectronica = $facturaElectronica->enviarSoftwareEstrategico($arrFactura);
                        if ($procesoFacturaElectronica['estado'] == 'CN') {
                            break;
                        }
                        if ($procesoFacturaElectronica['estado'] == 'EX') {
                            $arFactura = $em->getRepository(Movimiento::class)->find($codigo);
                            $arFactura->setEstadoElectronico(1);
                            $arFactura->setCodigoExterno($procesoFacturaElectronica['codigoExterno']);
                            $arFactura->setCue($procesoFacturaElectronica['cue']);
                            $arFactura->setCadenaCodigoQr($procesoFacturaElectronica['cadenaCodigoQr']);
                            $em->persist($arFactura);
                            $em->flush();
                            if ($arFactura->getResolucionRel()->getAmbiente() == 1) {
                                $facturaElectronica = new FacturaElectronica($em);
                                $facturaElectronica->correo($codigo, $codigoEmpresa);
                            }
                        }
                    } else {
                        Mensajes::error($respuesta['mensaje']);
                        break;
                    }
                } else {
                    Mensajes::error("El documento debe estar aprobado y sin enviar a facturacion electronica");
                    break;
                }

            }
        }
        return true;
    }

    public function imprimirFactura($codigoMovimiento)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.fechaVence')
            ->addSelect('m.plazoPago')
            ->addSelect('m.documentoSoporte')
            ->addSelect('m.codigoMovimientoTipoFk')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('t.nombreCorto as terceroNombreCorto')
            ->addSelect('t.telefono as terceroTelefono')
            ->addSelect('t.direccion as terceroDireccion')
            ->addSelect('rs.nombre as resolucionNombre')
            ->addSelect('rs.prefijo as resolucionPrefijo')
            ->addSelect('fp.nombre as formaPagoNombre')
            ->addSelect('e.nombreCorto as empresaNombreCorto')
            ->addSelect('e.nit as empresaNit')
            ->addSelect('e.digitoVerificacion as empresaDigitoVerificacion')
            ->addSelect('e.direccion as empresaDireccion')
            ->addSelect('e.telefono as empresaTelefono')
            ->addSelect('e.logo as empresaLogo')
            ->addSelect('e.extension as empresaLogoExtension')
            ->addSelect('tciu.nombre as terceroCiudadNombre')
            ->addSelect('etp.nombre as empresaTipoPersonaNombre')
            ->addSelect('ere.nombre as empresaRegimenNombre')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('t.ciudadRel', 'tciu')
            ->leftJoin('m.resolucionRel', 'rs')
            ->leftJoin('m.formaPagoRel', 'fp')
            ->leftJoin('m.empresaRel', 'e')
            ->leftJoin('e.tipoPersonaRel', 'etp')
            ->leftJoin('e.regimenRel', 'ere')
            ->where("m.codigoMovimientoPk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        if ($arrMovimiento) {
            $arrMovimiento = $arrMovimiento[0];
        }
        return $arrMovimiento;
    }

    public function imprimirFacturaFooter($codigoMovimiento)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.vrSubtotal')
            ->addSelect('m.vrBaseIva')
            ->addSelect('m.vrIva')
            ->addSelect('m.vrTotalNeto')
            ->addSelect('m.cue')
            ->addSelect('m.cadenaCodigoQr')
            ->addSelect('m.comentario')
            ->addSelect('rs.numero as resolucionNumero')
            ->addSelect('rs.numeroDesde as resolucionNumeroDesde')
            ->addSelect('rs.numeroHasta as resolucionNumeroHasta')
            ->addSelect('rs.fechaHasta as resolucionFechaHasta')
            ->addSelect('e.informacionPago as empresaInformacionPago')
            ->leftJoin('m.resolucionRel', 'rs')
            ->leftJoin('m.empresaRel', 'e')
            ->where("m.codigoMovimientoPk = {$codigoMovimiento} ");
        $arrMovimiento = $queryBuilder->getQuery()->getResult();
        if ($arrMovimiento) {
            $arrMovimiento = $arrMovimiento[0];
        }
        return $arrMovimiento;
    }

    public function generarFormato($arrMovimiento, $codigoEmpresa, $generarArchivo = false)
    {
        $em = $this->getEntityManager();
        $respuesta = ['nombre' => null, 'base64' => null, 'ruta' => null];
        $archivo = null;
        if ($generarArchivo) {
            $archivo = '/var/www/html/temporal/documento' . $arrMovimiento['codigoMovimientoPk'] . '.pdf';
        }
        if ($arrMovimiento['codigoMovimientoTipoFk'] == 'SAL') {
            $objFormato = new Salida();
            $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa);
        } elseif ($arrMovimiento['codigoMovimientoTipoFk'] == 'ENT') {
            $objFormato = new Entrada();
            $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa);
        } elseif ($arrMovimiento['codigoMovimientoTipoFk'] == 'FAC' || $arrMovimiento['codigoMovimientoTipoFk'] == 'NC' || $arrMovimiento['codigoMovimientoTipoFk'] == 'ND') {
            $arrEmpresa = $em->getRepository(Empresa::class)->formato($codigoEmpresa);
            switch ($arrEmpresa['formatoFactura']) {
                case "0":
                    $objFormato = new Factura();
                    $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa, $archivo);
                    break;
                case "1":
                    $objFormato = new Factura1();
                    $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa);
                    break;
                case "2":
                    $objFormato = new Factura();
                    $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa, $archivo);
                    break;
            }
        } elseif ($arrMovimiento['codigoMovimientoTipoFk'] == 'COM') {
            $objFormato = new Compra();
            $objFormato->Generar($em, $arrMovimiento['codigoMovimientoPk'], $codigoEmpresa);
        }

        if ($generarArchivo) {
            $b64Doc = chunk_split(base64_encode(file_get_contents($archivo)));
            $respuesta['nombre'] = "documento{$arrMovimiento['codigoMovimientoPk']}.pdf";
            $respuesta['base64'] = $b64Doc;
            $respuesta['ruta'] = $archivo;
        }
        return $respuesta;
    }

    public function informeVenta($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.referencia')
            ->addSelect('(m.vrSubtotal * mt.operacionComercial) as vrSubtotal')
            ->addSelect('(m.vrIva * mt.operacionComercial) as vrIva')
            ->addSelect('(m.vrTotalNeto * mt.operacionComercial) as vrTotalNeto')
            ->addSelect('m.estadoAutorizado')
            ->addSelect('m.estadoAprobado')
            ->addSelect('m.estadoAnulado')
            ->addSelect('m.codigoTerceroFk')
            ->addSelect('t.nombreCorto AS terceroNombreCorto')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('mt.nombre as movimientoTipoNombre')
            ->addSelect('cc.nombre as centroCostoNombre')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.movimientoTipoRel', 'mt')
            ->leftJoin('m.centroCostoRel', 'cc')
            ->where("m.codigoMovimientoTipoFk = 'FAC' OR m.codigoMovimientoTipoFk = 'NC' OR m.codigoMovimientoTipoFk = 'ND'")
            ->andWhere('m.estadoAprobado = 1')
            ->andWhere('m.codigoEmpresaFk = ' . $empresa);

        if ($session->get('fitroInformeVentasFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('fitroInformeVentasFechaDesde')} 00:00:00'");
        }
        if ($session->get('fitroInformeVentasFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('fitroInformeVentasFechaHasta')} 23:59:59'");
        }
        if ($session->get('fitroInformeVentasTercero')) {
            $queryBuilder->andWhere("m.codigoTerceroFk = '{$session->get('fitroInformeVentasTercero')}'");
        }
        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function informeCompra($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Movimiento::class, 'm')
            ->select('m.codigoMovimientoPk')
            ->addSelect('m.numero')
            ->addSelect('m.fecha')
            ->addSelect('m.referencia')
            ->addSelect('(m.vrSubtotal * mt.operacionComercial) as vrSubtotal')
            ->addSelect('(m.vrIva * mt.operacionComercial) as vrIva')
            ->addSelect('(m.vrTotalNeto * mt.operacionComercial) as vrTotalNeto')
            ->addSelect('m.estadoAutorizado')
            ->addSelect('m.estadoAprobado')
            ->addSelect('m.estadoAnulado')
            ->addSelect('m.codigoTerceroFk')
            ->addSelect('t.nombreCorto AS terceroNombreCorto')
            ->addSelect('t.numeroIdentificacion as terceroNumeroIdentificacion')
            ->addSelect('mt.nombre as movimientoTipoNombre')
            ->addSelect('cc.nombre as centroCostoNombre')
            ->leftJoin('m.terceroRel', 't')
            ->leftJoin('m.movimientoTipoRel', 'mt')
            ->leftJoin('m.centroCostoRel', 'cc')
            ->where("m.codigoMovimientoTipoFk = 'COM'")
            ->andWhere('m.estadoAprobado = 1')
            ->andWhere('m.codigoEmpresaFk = ' . $empresa);

        if ($session->get('fitroInformeVentasFechaDesde') != null) {
            $queryBuilder->andWhere("m.fecha >= '{$session->get('fitroInformeVentasFechaDesde')} 00:00:00'");
        }
        if ($session->get('fitroInformeVentasFechaHasta') != null) {
            $queryBuilder->andWhere("m.fecha <= '{$session->get('fitroInformeVentasFechaHasta')} 23:59:59'");
        }
        if ($session->get('fitroInformeVentasTercero')) {
            $queryBuilder->andWhere("m.codigoTerceroFk = '{$session->get('fitroInformeVentasTercero')}'");
        }
        $queryBuilder->orderBy("m.codigoMovimientoPk", 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function apiExternoFacturaLista($codigoFactura)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(Movimiento::class, 'f')
            ->select('f.codigoMovimientoPk AS codigoFactura')
            ->addSelect('f.numero AS numeroFactura')
            ->addSelect('f.fecha AS fecha')
            ->addSelect('f.fechaVence')
            ->addSelect('f.vrSubtotal')
            ->addSelect('f.vrIva')
            ->addSelect('f.vrRetencionFuente')
            ->addSelect('f.vrTotal')
            ->addSelect('f.respuestaElectronico')
            ->where("f.codigoFacturaPk = {$codigoFactura}")
            ->andWhere("f.codigoMovimientoTipoFk = 'FAC'");
        $arFactura = $queryBuilder->getQuery()->getSingleResult();
        return $arFactura;
    }

    public function apiExternoFactura($raw)
    {
        $em = $this->getEntityManager();
        try {
            $codigoFactura = $raw['codigoFactura'] ?? null;
            $estado = $raw['estado'] ?? null;
            if ($codigoFactura) {
                $arFactura = $em->getRepository(Movimiento::class)->find($codigoFactura);
                if ($arFactura) {
                    if ($arFactura->getRespuestaElectronico() == "P") {
                        $arFactura->setRespuestaElectronico($estado);
                        $em->persist($arFactura);
                        $em->flush();
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "La factura ya fue procesada anteriormente"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "La factura no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "Faltan datos para el consumo de la api"
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'errorMensaje' => "Ocurrió un error en la api " . $e->getMessage()];
        }
    }

    public function apiExternoMovimientoNuevo($raw)
    {
        $em = $this->getEntityManager();
        if ($raw) {
            $arEmpresa = $em->getRepository(Empresa::class)->find($raw['codigoEmpresaFk']);
            if ($arEmpresa) {
                $arTercero = $em->getRepository(Tercero::class)->findOneBy(array('codigoIdentificacionFk' => $raw['codigoIdentificacionFk'], 'numeroIdentificacion' => $raw['numeroIdentificacion'], 'codigoEmpresaFk' => $arEmpresa->getCodigoEmpresaPk()));
                if ($arTercero) {
                    $arMovimientoTipo = $em->getRepository(MovimientoTipo::class)->find($raw['codigoMovimientoTipoFk']);
                    if ($arMovimientoTipo) {
                        $arFormaPago = $em->getRepository(FormaPago::class)->find($raw['codigoFormaPagoFk']);
                        if ($arFormaPago) {
                            $arMovimiento = new Movimiento();
                            $arMovimiento->setTerceroRel($arTercero);
                            $arMovimiento->setMovimientoTipoRel($arMovimientoTipo);
                            $arMovimiento->setCodigoMovimientoTipoFk($arMovimientoTipo->getCodigoMovimientoTipoPk());
                            $arMovimiento->setFecha(new \DateTime('now'));
                            $arMovimiento->setEmpresaRel($arEmpresa);
                            $arMovimiento->setCodigoEmpresaFk($arEmpresa->getCodigoEmpresaPk());
                            $arMovimiento->setResolucionRel($arEmpresa->getResolucionRel());
                            $arMovimiento->setFormaPagoRel($arFormaPago);
                            $arMovimiento->setCodigoFormaPagoFk($arFormaPago->getCodigoFormaPagoPk());
                            $arMovimiento->setPlazoPago($raw['plazoPago']);
                            $arMovimiento->setComentario(utf8_decode($raw['comentario']));
                            $arMovimiento->setDocumentoSoporte($raw['documentoSoporte']);
                            $em->persist($arMovimiento);
                            $em->flush();
                            foreach ($raw['detalles'] as $detalle) {
                                $arItem = $em->getRepository(Item::class)->findOneBy(array('codigoItemPk' => $detalle['codigoItemFk'], 'codigoEmpresaFk' => $arEmpresa->getCodigoEmpresaPk()));
                                if ($arItem) {
                                    $arMovimientoDetalle = new MovimientoDetalle();
                                    $arMovimientoDetalle->setMovimientoRel($arMovimiento);
                                    $arMovimientoDetalle->setCodigoMovimientoFk($arMovimiento->getCodigoMovimientoPk());
                                    $arMovimientoDetalle->setItemRel($arItem);
                                    $arMovimientoDetalle->setCodigoItemFk($arItem->getCodigoItemPk());
                                    $arMovimientoDetalle->setCantidad($detalle['cantidad']);
                                    $arMovimientoDetalle->setVrPrecio($detalle['vrPrecio']);
                                    $arMovimientoDetalle->setPorcentajeDescuento($detalle['porcentajeDescuento']);
                                    $arMovimientoDetalle->setPorcentajeIva($arItem->getPorcentajeIva());
                                    $arMovimientoDetalle->setCodigoImpuestoIvaFk($detalle['codigoImpuestoIvaFk']);
                                    $arMovimientoDetalle->setCodigoImpuestoRetencionFk($detalle['codigoImpuestoRetencionFk']);
                                    $em->persist($arMovimientoDetalle);
                                } else {
                                    return [
                                        'error' => true,
                                        'errorMensaje' => "El codigo del item relacionado no existe, por favor validar"
                                    ];
                                }
                            }
                            $em->flush();
                            $em->getRepository(Movimiento::class)->liquidar($arMovimiento);
                            $em->getRepository(Movimiento::class)->autorizar($arMovimiento);
                            $em->getRepository(Movimiento::class)->aprobar($arMovimiento);
                            $em->flush();
                            return [
                                'error' => false,
                                'errorMensaje' => "Registro creado con éxito"
                            ];
                        } else {
                            return [
                                'error' => true,
                                'errorMensaje' => "La forma de pago informada no existe, por favor validar"
                            ];
                        }
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "El tipo de movimiento informado no existe, por favor validar"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El tercero ingresado no se encuentra en el sistema, por favor validar"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "La empresa ingresada no existe, por favor validar"
                ];
            }
        }
    }
}