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
     * @ORM\Column(name="documento_soporte", type="string", length=100, nullable=true)
     */
    private $documentoSoporte;

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
     * @ORM\Column(name="vr_base_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrBaseIva = 0;

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
     * @ORM\Column(name="codigo_empresa_fk", type="integer")
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
     * @ORM\Column(name="estado_electronico", type="boolean", options={"default":false})
     */
    private $estadoElectronico = false;

    /**
     * @ORM\Column(name="estado_electronico_notificado", type="boolean", options={"default":false})
     */
    private $estadoElectronicoNotificado = false;

    /**
     * @ORM\Column(name="codigo_resolucion_fk", type="integer", nullable=true)
     */
    private $codigoResolucionFk;

    /**
     * @ORM\Column(name="codigo_movimiento_fk", type="integer", nullable=true)
     */
    private $codigoMovimientoFk;

    /**
     * @ORM\Column(name="cue", type="string", length=200, nullable=true)
     */
    private $cue;

    /**
     * @ORM\Column(name="codigo_externo", type="string", length=200, nullable=true)
     */
    private $codigoExterno;

    /**
     * @ORM\Column(name="cadena_codigo_qr", type="text", nullable=true)
     */
    private $cadenaCodigoQr;

    /**
     * @ORM\Column(name="comentario", type="string", length=500, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_centro_costo_fk", type="integer", nullable=true)
     */
    private $codigoCentroCostoFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenResolucion", inversedBy="movimientosResolucionRel")
     * @ORM\JoinColumn(name="codigo_resolucion_fk", referencedColumnName="codigo_resolucion_pk")
     */
    protected $resolucionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inventario\InvMovimiento", inversedBy="movimientosMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    protected $movimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Empresa", inversedBy="movimientosEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    private $empresaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CentroCosto", inversedBy="movimientosCentroCostoRel")
     * @ORM\JoinColumn(name="codigo_centro_costo_fk", referencedColumnName="codigo_centro_costo_pk")
     */
    protected $centroCostoRel;

    /**
     * @ORM\OneToMany(targetEntity="InvMovimientoDetalle", mappedBy="movimientoRel")
     */
    protected $movimientosDetallesMovimientoRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoPk()
    {
        return $this->codigoMovimientoPk;
    }

    /**
     * @param mixed $codigoMovimientoPk
     */
    public function setCodigoMovimientoPk($codigoMovimientoPk): void
    {
        $this->codigoMovimientoPk = $codigoMovimientoPk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getFechaVence()
    {
        return $this->fechaVence;
    }

    /**
     * @param mixed $fechaVence
     */
    public function setFechaVence($fechaVence): void
    {
        $this->fechaVence = $fechaVence;
    }

    /**
     * @return int
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return int
     */
    public function getPlazoPago(): int
    {
        return $this->plazoPago;
    }

    /**
     * @param int $plazoPago
     */
    public function setPlazoPago(int $plazoPago): void
    {
        $this->plazoPago = $plazoPago;
    }

    /**
     * @return mixed
     */
    public function getCodigoFormaPagoFk()
    {
        return $this->codigoFormaPagoFk;
    }

    /**
     * @param mixed $codigoFormaPagoFk
     */
    public function setCodigoFormaPagoFk($codigoFormaPagoFk): void
    {
        $this->codigoFormaPagoFk = $codigoFormaPagoFk;
    }

    /**
     * @return mixed
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     */
    public function setReferencia($referencia): void
    {
        $this->referencia = $referencia;
    }

    /**
     * @return mixed
     */
    public function getCodigoTerceroFk()
    {
        return $this->codigoTerceroFk;
    }

    /**
     * @param mixed $codigoTerceroFk
     */
    public function setCodigoTerceroFk($codigoTerceroFk): void
    {
        $this->codigoTerceroFk = $codigoTerceroFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoDocumentoFk()
    {
        return $this->codigoDocumentoFk;
    }

    /**
     * @param mixed $codigoDocumentoFk
     */
    public function setCodigoDocumentoFk($codigoDocumentoFk): void
    {
        $this->codigoDocumentoFk = $codigoDocumentoFk;
    }

    /**
     * @return int
     */
    public function getVrSubtotal(): int
    {
        return $this->vrSubtotal;
    }

    /**
     * @param int $vrSubtotal
     */
    public function setVrSubtotal(int $vrSubtotal): void
    {
        $this->vrSubtotal = $vrSubtotal;
    }

    /**
     * @return int
     */
    public function getVrTotalBruto(): int
    {
        return $this->vrTotalBruto;
    }

    /**
     * @param int $vrTotalBruto
     */
    public function setVrTotalBruto(int $vrTotalBruto): void
    {
        $this->vrTotalBruto = $vrTotalBruto;
    }

    /**
     * @return int
     */
    public function getVrTotalNeto(): int
    {
        return $this->vrTotalNeto;
    }

    /**
     * @param int $vrTotalNeto
     */
    public function setVrTotalNeto(int $vrTotalNeto): void
    {
        $this->vrTotalNeto = $vrTotalNeto;
    }

    /**
     * @return int
     */
    public function getVrIva(): int
    {
        return $this->vrIva;
    }

    /**
     * @param int $vrIva
     */
    public function setVrIva(int $vrIva): void
    {
        $this->vrIva = $vrIva;
    }

    /**
     * @return int
     */
    public function getVrRetencionFuente(): int
    {
        return $this->vrRetencionFuente;
    }

    /**
     * @param int $vrRetencionFuente
     */
    public function setVrRetencionFuente(int $vrRetencionFuente): void
    {
        $this->vrRetencionFuente = $vrRetencionFuente;
    }

    /**
     * @return int
     */
    public function getVrRetencionIva(): int
    {
        return $this->vrRetencionIva;
    }

    /**
     * @param int $vrRetencionIva
     */
    public function setVrRetencionIva(int $vrRetencionIva): void
    {
        $this->vrRetencionIva = $vrRetencionIva;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return bool
     */
    public function isEstadoAutorizado(): bool
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param bool $estadoAutorizado
     */
    public function setEstadoAutorizado(bool $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return bool
     */
    public function isEstadoAprobado(): bool
    {
        return $this->estadoAprobado;
    }

    /**
     * @param bool $estadoAprobado
     */
    public function setEstadoAprobado(bool $estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return bool
     */
    public function isEstadoAnulado(): bool
    {
        return $this->estadoAnulado;
    }

    /**
     * @param bool $estadoAnulado
     */
    public function setEstadoAnulado(bool $estadoAnulado): void
    {
        $this->estadoAnulado = $estadoAnulado;
    }

    /**
     * @return mixed
     */
    public function getTerceroRel()
    {
        return $this->terceroRel;
    }

    /**
     * @param mixed $terceroRel
     */
    public function setTerceroRel($terceroRel): void
    {
        $this->terceroRel = $terceroRel;
    }

    /**
     * @return mixed
     */
    public function getDocumentoRel()
    {
        return $this->documentoRel;
    }

    /**
     * @param mixed $documentoRel
     */
    public function setDocumentoRel($documentoRel): void
    {
        $this->documentoRel = $documentoRel;
    }

    /**
     * @return mixed
     */
    public function getFormaPagoRel()
    {
        return $this->formaPagoRel;
    }

    /**
     * @param mixed $formaPagoRel
     */
    public function setFormaPagoRel($formaPagoRel): void
    {
        $this->formaPagoRel = $formaPagoRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosDetallesMovimientoRel()
    {
        return $this->movimientosDetallesMovimientoRel;
    }

    /**
     * @param mixed $movimientosDetallesMovimientoRel
     */
    public function setMovimientosDetallesMovimientoRel($movimientosDetallesMovimientoRel): void
    {
        $this->movimientosDetallesMovimientoRel = $movimientosDetallesMovimientoRel;
    }

    /**
     * @return bool
     */
    public function isEstadoElectronico(): bool
    {
        return $this->estadoElectronico;
    }

    /**
     * @param bool $estadoElectronico
     */
    public function setEstadoElectronico(bool $estadoElectronico): void
    {
        $this->estadoElectronico = $estadoElectronico;
    }

    /**
     * @return mixed
     */
    public function getCodigoResolucionFk()
    {
        return $this->codigoResolucionFk;
    }

    /**
     * @param mixed $codigoResolucionFk
     */
    public function setCodigoResolucionFk($codigoResolucionFk): void
    {
        $this->codigoResolucionFk = $codigoResolucionFk;
    }

    /**
     * @return mixed
     */
    public function getResolucionRel()
    {
        return $this->resolucionRel;
    }

    /**
     * @param mixed $resolucionRel
     */
    public function setResolucionRel($resolucionRel): void
    {
        $this->resolucionRel = $resolucionRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoMovimientoFk()
    {
        return $this->codigoMovimientoFk;
    }

    /**
     * @param mixed $codigoMovimientoFk
     */
    public function setCodigoMovimientoFk($codigoMovimientoFk): void
    {
        $this->codigoMovimientoFk = $codigoMovimientoFk;
    }

    /**
     * @return mixed
     */
    public function getMovimientoRel()
    {
        return $this->movimientoRel;
    }

    /**
     * @param mixed $movimientoRel
     */
    public function setMovimientoRel($movimientoRel): void
    {
        $this->movimientoRel = $movimientoRel;
    }

    /**
     * @return mixed
     */
    public function getCue()
    {
        return $this->cue;
    }

    /**
     * @param mixed $cue
     */
    public function setCue($cue): void
    {
        $this->cue = $cue;
    }

    /**
     * @return mixed
     */
    public function getEmpresaRel()
    {
        return $this->empresaRel;
    }

    /**
     * @param mixed $empresaRel
     */
    public function setEmpresaRel($empresaRel): void
    {
        $this->empresaRel = $empresaRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoExterno()
    {
        return $this->codigoExterno;
    }

    /**
     * @param mixed $codigoExterno
     */
    public function setCodigoExterno($codigoExterno): void
    {
        $this->codigoExterno = $codigoExterno;
    }

    /**
     * @return mixed
     */
    public function getVrBaseIva()
    {
        return $this->vrBaseIva;
    }

    /**
     * @param mixed $vrBaseIva
     */
    public function setVrBaseIva($vrBaseIva): void
    {
        $this->vrBaseIva = $vrBaseIva;
    }

    /**
     * @return bool
     */
    public function isEstadoElectronicoNotificado(): bool
    {
        return $this->estadoElectronicoNotificado;
    }

    /**
     * @param bool $estadoElectronicoNotificado
     */
    public function setEstadoElectronicoNotificado(bool $estadoElectronicoNotificado): void
    {
        $this->estadoElectronicoNotificado = $estadoElectronicoNotificado;
    }

    /**
     * @return mixed
     */
    public function getCadenaCodigoQr()
    {
        return $this->cadenaCodigoQr;
    }

    /**
     * @param mixed $cadenaCodigoQr
     */
    public function setCadenaCodigoQr($cadenaCodigoQr): void
    {
        $this->cadenaCodigoQr = $cadenaCodigoQr;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getDocumentoSoporte()
    {
        return $this->documentoSoporte;
    }

    /**
     * @param mixed $documentoSoporte
     */
    public function setDocumentoSoporte($documentoSoporte): void
    {
        $this->documentoSoporte = $documentoSoporte;
    }

    /**
     * @return mixed
     */
    public function getCodigoCentroCostoFk()
    {
        return $this->codigoCentroCostoFk;
    }

    /**
     * @param mixed $codigoCentroCostoFk
     */
    public function setCodigoCentroCostoFk($codigoCentroCostoFk): void
    {
        $this->codigoCentroCostoFk = $codigoCentroCostoFk;
    }

    /**
     * @return mixed
     */
    public function getCentroCostoRel()
    {
        return $this->centroCostoRel;
    }

    /**
     * @param mixed $centroCostoRel
     */
    public function setCentroCostoRel($centroCostoRel): void
    {
        $this->centroCostoRel = $centroCostoRel;
    }



}
