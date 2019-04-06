<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoType
 *
 * @ORM\Table(name="movimiento_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoDetalleRepository")
 */
class MovimientoDetalle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
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
     * @ORM\Column(name="precio", type="float", nullable=true, options={"default" : 0})
     */
    private $precio = 0;

    /**
     * @ORM\Column(name="subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $subtotal;

    /**
     * @ORM\Column(name="total", type="float", nullable=true, options={"default" : 0})
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="Movimiento", inversedBy="movimientosDetallesMovimientoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_fk", referencedColumnName="codigo_movimiento_pk")
     */
    private $movimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="movimientosDetallesItemRel")
     * @ORM\JoinColumn(name="codigo_item_fk", referencedColumnName="codigo_item_pk")
     */
    private $itemRel;

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
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param mixed $subtotal
     */
    public function setSubtotal($subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
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




}
