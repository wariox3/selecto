<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoType
 *
 * @ORM\Table(name="movimiento")
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoRepository")
 */
class Movimiento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoMovimientoPk;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_tercero_fk", type="integer", nullable=true)
     */
    private $codigoTerceroFk;

    /**
     * @ORM\Column(name="subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $subtotal;

    /**
     * @ORM\Column(name="total_bruto", type="float", nullable=true, options={"default" : 0})
     */
    private $totalBruto;

    /**
     * @ORM\Column(name="total_neto", type="float", nullable=true, options={"default" : 0})
     */
    private $totalNeto;

    /**
     * @ORM\ManyToOne(targetEntity="Tercero", inversedBy="movimientosTerceroRel")
     * @ORM\JoinColumn(name="codigo_tercero_fk", referencedColumnName="codigo_tercero_pk")
     */
    private $terceroRel;

    /**
     * @ORM\OneToMany(targetEntity="MovimientoDetalle", mappedBy="movimientoRel")
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
    public function getTotalBruto()
    {
        return $this->totalBruto;
    }

    /**
     * @param mixed $totalBruto
     */
    public function setTotalBruto($totalBruto): void
    {
        $this->totalBruto = $totalBruto;
    }

    /**
     * @return mixed
     */
    public function getTotalNeto()
    {
        return $this->totalNeto;
    }

    /**
     * @param mixed $totalNeto
     */
    public function setTotalNeto($totalNeto): void
    {
        $this->totalNeto = $totalNeto;
    }



}
