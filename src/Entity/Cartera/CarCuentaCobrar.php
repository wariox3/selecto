<?php

namespace App\Entity\Cartera;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaCobrarType
 * @ORM\Entity(repositoryClass="App\Repository\Cartera\CarCuentaCobrarRepository")
 */
class CarCuentaCobrar
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_cobrar_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCuentaCobrarPk;

    /**
     * @ORM\Column(name="codigo_cuenta_cobrar_tipo_fk", type="string", length=5, nullable=true)
     */
    private $codigoCuentaCobrarTipoFk;

    /**
     * @ORM\Column(name="numero_documento", type="integer", nullable=true)
     */
    private $numeroDocumento = 0;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_vence", type="date", nullable=true)
     */
    private $fechaVence;

    /**
     * @ORM\Column(name="operacion", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="codigo_tercero_fk", type="integer", nullable=true)
     */
    private $codigoTerceroFk;

    /**
     * @ORM\Column(name="plazo", type="integer", nullable=true, options={"default" : 0})
     */
    private $plazo = 0;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSubtotal;

    /**
     * @ORM\Column(name="vr_total_bruto", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotalBruto;

    /**
     * @ORM\Column(name="vr_abono", type="float", nullable=true, options={"default" : 0})
     */
    private $vrAbono;

    /**
     * @ORM\Column(name="vr_saldo_original", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSaldoOriginal;

    /**
     * @ORM\Column(name="vr_saldo", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSaldo;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true)
     */
    private $vrIva;

    /**
     * @ORM\Column(name="vr_retencion_fuente", type="float", nullable=true, options={"default" : 0})
     */
    private $vrRetencionFuente = 0;

    /**
     * @ORM\Column(name="vr_retencion_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrRetencionIva = 0;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="vr_saldo_operado", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSaldoOperado = 0;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean", options={"default":false})
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", options={"default":false})
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", type="boolean", options={"default":false})
     */
    private $estadoAnulado = false;

    /**
     * @ORM\ManyToOne(targetEntity="CarCuentaCobrarTipo", inversedBy="cuentaCobrarRel")
     * @ORM\JoinColumn(name="codigo_cuenta_cobrar_tipo_fk", referencedColumnName="codigo_cuenta_cobrar_tipo_pk")
     */
    protected $cuentaCobrarTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenTercero", inversedBy="cuentaCobroRel")
     * @ORM\JoinColumn(name="codigo_tercero_fk", referencedColumnName="codigo_tercero_pk")
     */
    protected $terceroRel;



}
