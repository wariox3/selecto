<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoDetalleType
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvMovimientoDetalleRepository")
 */
class InvMovimientoDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoDetallePk;

    /**
     * @ORM\Column(name="codigo_movimiento_fk", type="integer", nullable=true)
     */
    private $codigoMovimientoFk;

    /**
     * @ORM\Column(name="codigo_item_fk", type="integer", nullable=true)
     */
    private $codigoItemFk;

    /**
     * @ORM\Column(name="cantidad", type="float", nullable=true, options={"default" : 0})
     */
    private $cantidad = 0;

    /**
     * @ORM\Column(name="vr_precio", type="float", nullable=true, options={"default" : 0})
     */
    private $vrPrecio = 0;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSubtotal;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="porcentaje_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeIva = 0;

    /**
     * @ORM\Column(name="porcentaje_descuento", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeDescuento = 0;

    /**
     * @ORM\Column(name="codigo_impuesto_retencion_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoRetencionFk;

    /**
     * @ORM\Column(name="codigo_impuesto_iva_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoIvaFk;

    /**
     * @ORM\Column(name="vr_base_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrBaseIva = 0;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrIva = 0;

    /**
     * @ORM\Column(name="vr_retencion_fuente", type="float", options={"default" : 0})
     */
    private $vrRetencionFuente = 0;

    /**
     * @ORM\Column(name="vr_total", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotal;

    /**
     * @ORM\ManyToOne(targetEntity="InvMovimiento", inversedBy="movimientosDetallesMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    protected $movimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="InvItem", inversedBy="movimientosDetallesItemRel")
     * @ORM\JoinColumn(name="codigo_item_fk", referencedColumnName="codigo_item_pk")
     */
    protected $itemRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoDetallePk()
    {
        return $this->codigoMovimientoDetallePk;
    }

    /**
     * @param mixed $codigoMovimientoDetallePk
     */
    public function setCodigoMovimientoDetallePk($codigoMovimientoDetallePk): void
    {
        $this->codigoMovimientoDetallePk = $codigoMovimientoDetallePk;
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
    public function getCodigoItemFk()
    {
        return $this->codigoItemFk;
    }

    /**
     * @param mixed $codigoItemFk
     */
    public function setCodigoItemFk($codigoItemFk): void
    {
        $this->codigoItemFk = $codigoItemFk;
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return int
     */
    public function getVrPrecio(): int
    {
        return $this->vrPrecio;
    }

    /**
     * @param int $vrPrecio
     */
    public function setVrPrecio(int $vrPrecio): void
    {
        $this->vrPrecio = $vrPrecio;
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
     * @return int
     */
    public function getPorcentajeIva(): int
    {
        return $this->porcentajeIva;
    }

    /**
     * @param int $porcentajeIva
     */
    public function setPorcentajeIva(int $porcentajeIva): void
    {
        $this->porcentajeIva = $porcentajeIva;
    }

    /**
     * @return mixed
     */
    public function getCodigoImpuestoRetencionFk()
    {
        return $this->codigoImpuestoRetencionFk;
    }

    /**
     * @param mixed $codigoImpuestoRetencionFk
     */
    public function setCodigoImpuestoRetencionFk($codigoImpuestoRetencionFk): void
    {
        $this->codigoImpuestoRetencionFk = $codigoImpuestoRetencionFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoImpuestoIvaFk()
    {
        return $this->codigoImpuestoIvaFk;
    }

    /**
     * @param mixed $codigoImpuestoIvaFk
     */
    public function setCodigoImpuestoIvaFk($codigoImpuestoIvaFk): void
    {
        $this->codigoImpuestoIvaFk = $codigoImpuestoIvaFk;
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
     * @return mixed
     */
    public function getVrTotal()
    {
        return $this->vrTotal;
    }

    /**
     * @param mixed $vrTotal
     */
    public function setVrTotal($vrTotal): void
    {
        $this->vrTotal = $vrTotal;
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
    public function getItemRel()
    {
        return $this->itemRel;
    }

    /**
     * @param mixed $itemRel
     */
    public function setItemRel($itemRel): void
    {
        $this->itemRel = $itemRel;
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
     * @return mixed
     */
    public function getPorcentajeDescuento()
    {
        return $this->porcentajeDescuento;
    }

    /**
     * @param mixed $porcentajeDescuento
     */
    public function setPorcentajeDescuento($porcentajeDescuento): void
    {
        $this->porcentajeDescuento = $porcentajeDescuento;
    }



}
