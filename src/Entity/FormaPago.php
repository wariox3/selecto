<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormaPagoRepository")
 */
class FormaPago
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_forma_pago_pk", type="string", length=3)
     */
    private $codigoFormaPagoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true, options={"default":0})
     */
    private $orden = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tercero", mappedBy="formaPagoRel")
     */
    private $tercerosFormaPagoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="formaPagoRel")
     */
    private $movimientosFormaPagoRel;

    /**
     * @return mixed
     */
    public function getCodigoFormaPagoPk()
    {
        return $this->codigoFormaPagoPk;
    }

    /**
     * @param mixed $codigoFormaPagoPk
     */
    public function setCodigoFormaPagoPk($codigoFormaPagoPk): void
    {
        $this->codigoFormaPagoPk = $codigoFormaPagoPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getTercerosFormaPagoRel()
    {
        return $this->tercerosFormaPagoRel;
    }

    /**
     * @param mixed $tercerosFormaPagoRel
     */
    public function setTercerosFormaPagoRel($tercerosFormaPagoRel): void
    {
        $this->tercerosFormaPagoRel = $tercerosFormaPagoRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosFormaPagoRel()
    {
        return $this->movimientosFormaPagoRel;
    }

    /**
     * @param mixed $movimientosFormaPagoRel
     */
    public function setMovimientosFormaPagoRel($movimientosFormaPagoRel): void
    {
        $this->movimientosFormaPagoRel = $movimientosFormaPagoRel;
    }

    /**
     * @return int
     */
    public function getOrden(): int
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     */
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }



}
