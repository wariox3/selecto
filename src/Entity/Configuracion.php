<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="configuracion")
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
 */
class Configuracion
{

     /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="integer")
     */
    private $codigoConfiguracionPk;
    
    /**
     * @ORM\Column(name="informacion_legal_movimiento", type="text", nullable=true)
     */    
    private $informacionLegalMovimiento; 

    /**
     * @ORM\Column(name="informacion_pago_movimiento", type="text", nullable=true)
     */    
    private $informacionPagoMovimiento;     
    
    /**
     * @ORM\Column(name="informacion_contacto_movimiento", type="text", nullable=true)
     */    
    private $informacionContactoMovimiento;    
    
    /**
     * @ORM\Column(name="informacion_resolucion_dian_movimiento", type="text", nullable=true)
     */    
    private $informacionResolucionDianMovimiento;                              
    
    /**
     * @ORM\Column(name="codigo_formato_movimiento", type="integer")
     */    
    private $codigoFormatoMovimiento = 0;

    /**
     * @ORM\Column(name="codigo_formato_remision", type="integer", nullable=true, options={"default" : 0})
     */
    private $codigoFormatoRemision = 0;

    /**
     * @ORM\Column(name="codigo_formato_cotizacion", type="integer", nullable=true, options={"default" : 0})
     */
    private $codigoFormatoCotizacion = 0;

    /**
     * @ORM\Column(name="codigo_documento_movimientos_salida_bodega", type="integer", nullable=true, options={"default" : 0})
     */
    private $codigoDocumentoMovimientosSalidaBodega = 0;

    /**
     * @ORM\Column(name="codigo_documento_movimientos_entrada_bodega", type="integer", nullable=true, options={"default" : 0})
     */
    private $codigoDocumentoMovimientosEntradaBodega = 0;

    /**
     * @ORM\Column(name="vr_base_retencion_iva_venta", type="float", nullable=true, options={"default" : 0})
     */
    private $vrBaseRetencionIvaVenta = 0;

    /**
     * @ORM\Column(name="porcentaje_retencion_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeRetencionIva = 0;

    /**
     * @ORM\Column(name="validar_bodega_usuario", type="boolean", options={"default" : false})
     */
    private $validarBodegaUsuario = false;

    /**
     * Se usa para mandar el impuesto al recaudo
     * @ORM\Column(name="impuesto_recaudo", type="boolean", options={"default" : false})
     */
    private $impuestoRecaudo = false;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk($codigoConfiguracionPk): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getInformacionLegalMovimiento()
    {
        return $this->informacionLegalMovimiento;
    }

    /**
     * @param mixed $informacionLegalMovimiento
     */
    public function setInformacionLegalMovimiento($informacionLegalMovimiento): void
    {
        $this->informacionLegalMovimiento = $informacionLegalMovimiento;
    }

    /**
     * @return mixed
     */
    public function getInformacionPagoMovimiento()
    {
        return $this->informacionPagoMovimiento;
    }

    /**
     * @param mixed $informacionPagoMovimiento
     */
    public function setInformacionPagoMovimiento($informacionPagoMovimiento): void
    {
        $this->informacionPagoMovimiento = $informacionPagoMovimiento;
    }

    /**
     * @return mixed
     */
    public function getInformacionContactoMovimiento()
    {
        return $this->informacionContactoMovimiento;
    }

    /**
     * @param mixed $informacionContactoMovimiento
     */
    public function setInformacionContactoMovimiento($informacionContactoMovimiento): void
    {
        $this->informacionContactoMovimiento = $informacionContactoMovimiento;
    }

    /**
     * @return mixed
     */
    public function getInformacionResolucionDianMovimiento()
    {
        return $this->informacionResolucionDianMovimiento;
    }

    /**
     * @param mixed $informacionResolucionDianMovimiento
     */
    public function setInformacionResolucionDianMovimiento($informacionResolucionDianMovimiento): void
    {
        $this->informacionResolucionDianMovimiento = $informacionResolucionDianMovimiento;
    }

    /**
     * @return int
     */
    public function getCodigoFormatoMovimiento(): int
    {
        return $this->codigoFormatoMovimiento;
    }

    /**
     * @param int $codigoFormatoMovimiento
     */
    public function setCodigoFormatoMovimiento(int $codigoFormatoMovimiento): void
    {
        $this->codigoFormatoMovimiento = $codigoFormatoMovimiento;
    }

    /**
     * @return int
     */
    public function getCodigoFormatoRemision(): int
    {
        return $this->codigoFormatoRemision;
    }

    /**
     * @param int $codigoFormatoRemision
     */
    public function setCodigoFormatoRemision(int $codigoFormatoRemision): void
    {
        $this->codigoFormatoRemision = $codigoFormatoRemision;
    }

    /**
     * @return int
     */
    public function getCodigoFormatoCotizacion(): int
    {
        return $this->codigoFormatoCotizacion;
    }

    /**
     * @param int $codigoFormatoCotizacion
     */
    public function setCodigoFormatoCotizacion(int $codigoFormatoCotizacion): void
    {
        $this->codigoFormatoCotizacion = $codigoFormatoCotizacion;
    }

    /**
     * @return int
     */
    public function getCodigoDocumentoMovimientosSalidaBodega(): int
    {
        return $this->codigoDocumentoMovimientosSalidaBodega;
    }

    /**
     * @param int $codigoDocumentoMovimientosSalidaBodega
     */
    public function setCodigoDocumentoMovimientosSalidaBodega(int $codigoDocumentoMovimientosSalidaBodega): void
    {
        $this->codigoDocumentoMovimientosSalidaBodega = $codigoDocumentoMovimientosSalidaBodega;
    }

    /**
     * @return int
     */
    public function getCodigoDocumentoMovimientosEntradaBodega(): int
    {
        return $this->codigoDocumentoMovimientosEntradaBodega;
    }

    /**
     * @param int $codigoDocumentoMovimientosEntradaBodega
     */
    public function setCodigoDocumentoMovimientosEntradaBodega(int $codigoDocumentoMovimientosEntradaBodega): void
    {
        $this->codigoDocumentoMovimientosEntradaBodega = $codigoDocumentoMovimientosEntradaBodega;
    }

    /**
     * @return int
     */
    public function getVrBaseRetencionIvaVenta(): int
    {
        return $this->vrBaseRetencionIvaVenta;
    }

    /**
     * @param int $vrBaseRetencionIvaVenta
     */
    public function setVrBaseRetencionIvaVenta(int $vrBaseRetencionIvaVenta): void
    {
        $this->vrBaseRetencionIvaVenta = $vrBaseRetencionIvaVenta;
    }

    /**
     * @return int
     */
    public function getPorcentajeRetencionIva(): int
    {
        return $this->porcentajeRetencionIva;
    }

    /**
     * @param int $porcentajeRetencionIva
     */
    public function setPorcentajeRetencionIva(int $porcentajeRetencionIva): void
    {
        $this->porcentajeRetencionIva = $porcentajeRetencionIva;
    }

    /**
     * @return bool
     */
    public function isValidarBodegaUsuario(): bool
    {
        return $this->validarBodegaUsuario;
    }

    /**
     * @param bool $validarBodegaUsuario
     */
    public function setValidarBodegaUsuario(bool $validarBodegaUsuario): void
    {
        $this->validarBodegaUsuario = $validarBodegaUsuario;
    }

    /**
     * @return bool
     */
    public function isImpuestoRecaudo(): bool
    {
        return $this->impuestoRecaudo;
    }

    /**
     * @param bool $impuestoRecaudo
     */
    public function setImpuestoRecaudo(bool $impuestoRecaudo): void
    {
        $this->impuestoRecaudo = $impuestoRecaudo;
    }


}
