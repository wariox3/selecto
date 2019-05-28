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
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenDocumento", inversedBy="movimientosDocumentoRel")
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
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getPlazoPago()
    {
        return $this->plazoPago;
    }

    /**
     * @param mixed $plazoPago
     */
    public function setPlazoPago($plazoPago): void
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
     * @return mixed
     */
    public function getVrSubtotal()
    {
        return $this->vrSubtotal;
    }

    /**
     * @param mixed $vrSubtotal
     */
    public function setVrSubtotal($vrSubtotal): void
    {
        $this->vrSubtotal = $vrSubtotal;
    }

    /**
     * @return mixed
     */
    public function getVrTotalBruto()
    {
        return $this->vrTotalBruto;
    }

    /**
     * @param mixed $vrTotalBruto
     */
    public function setVrTotalBruto($vrTotalBruto): void
    {
        $this->vrTotalBruto = $vrTotalBruto;
    }

    /**
     * @return mixed
     */
    public function getVrTotalNeto()
    {
        return $this->vrTotalNeto;
    }

    /**
     * @param mixed $vrTotalNeto
     */
    public function setVrTotalNeto($vrTotalNeto): void
    {
        $this->vrTotalNeto = $vrTotalNeto;
    }

    /**
     * @return mixed
     */
    public function getVrIva()
    {
        return $this->vrIva;
    }

    /**
     * @param mixed $vrIva
     */
    public function setVrIva($vrIva): void
    {
        $this->vrIva = $vrIva;
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
     * @return mixed
     */
    public function getEstadoAutorizado()
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param mixed $estadoAutorizado
     */
    public function setEstadoAutorizado($estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return mixed
     */
    public function getEstadoAprobado()
    {
        return $this->estadoAprobado;
    }

    /**
     * @param mixed $estadoAprobado
     */
    public function setEstadoAprobado($estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return mixed
     */
    public function getEstadoAnulado()
    {
        return $this->estadoAnulado;
    }

    /**
     * @param mixed $estadoAnulado
     */
    public function setEstadoAnulado($estadoAnulado): void
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




}
