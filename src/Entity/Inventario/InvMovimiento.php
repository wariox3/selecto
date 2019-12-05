<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoType
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvMovimientoRepository")
 */
class InvMovimiento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoPk;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_vence", type="date", nullable=true)
     */
    private $fechaVence;

    /**
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero = 0;

    /**
     * @ORM\Column(name="plazo_pago", type="integer", nullable=true)
     */
    private $plazoPago = 0;

    /**
     * @ORM\Column(name="codigo_forma_pago_fk", type="string", length=3, nullable=true)
     */
    private $codigoFormaPagoFk;

    /**
     * @ORM\Column(name="referencia", type="string", length=100, nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(name="codigo_tercero_fk", type="integer", nullable=true)
     */
    private $codigoTerceroFk;

    /**
     * @ORM\Column(name="codigo_documento_fk", type="string", length=10, nullable=true)
     */
    private $codigoDocumentoFk;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSubtotal = 0;

    /**
     * @ORM\Column(name="vr_total_bruto", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotalBruto = 0;

    /**
     * @ORM\Column(name="vr_total_neto", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotalNeto = 0;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrIva = 0;

    /**
     * @ORM\Column(name="vr_retencion_fuente", type="float")
     */
    private $vrRetencionFuente = 0;

    /**
     * @ORM\Column(name="vr_retencion_iva", type="float")
     */
    private $vrRetencionIva = 0;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenTercero", inversedBy="movimientosTerceroRel")
     * @ORM\JoinColumn(name="codigo_tercero_fk", referencedColumnName="codigo_tercero_pk")
     */
    protected $terceroRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inventario\InvDocumento", inversedBy="movimientosDocumentoRel")
     * @ORM\JoinColumn(name="codigo_documento_fk", referencedColumnName="codigo_documento_pk")
     */
    protected $documentoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenFormaPago", inversedBy="movimientosFormaPagoRel")
     * @ORM\JoinColumn(name="codigo_forma_pago_fk", referencedColumnName="codigo_forma_pago_pk")
     */
    protected $formaPagoRel;

    /**
     * @ORM\OneToMany(targetEntity="InvMovimientoDetalle", mappedBy="movimientoRel")
     */
    protected $movimientosDetallesMovimientoRel;



}
