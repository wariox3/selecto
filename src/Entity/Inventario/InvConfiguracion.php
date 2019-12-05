<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="inv_configuracion")
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvConfiguracionRepository")
 */
class InvConfiguracion
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


}
