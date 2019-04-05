<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerceroType
 *
 * @ORM\Table(name="tercero")
 * @ORM\Entity(repositoryClass="App\Repository\TerceroRepository")
 */
class Tercero
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoTerceroPk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=150, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="cliente", type="boolean", nullable=true, options={"default" : false})
     */
    private $cliente = false;

    /**
     * @ORM\Column(name="proveedor", type="boolean", nullable=true, options={"default" : false})
     */
    private $proveedor = false;

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="terceroRel")
     */
    protected $movimientosTerceroRel;

    /**
     *
     * @return mixed
     */
    public function getCodigoTerceroPk()
    {
        return $this->codigoTerceroPk;
    }

    /**
     * @param mixed $codigoTerceroPk
     */
    public function setCodigoTerceroPk($codigoTerceroPk): void
    {
        $this->codigoTerceroPk = $codigoTerceroPk;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param mixed $proveedor
     */
    public function setProveedor($proveedor): void
    {
        $this->proveedor = $proveedor;
    }

    /**
     * @return mixed
     */
    public function getMovimientosTerceroRel()
    {
        return $this->movimientosTerceroRel;
    }

    /**
     * @param mixed $movimientosTerceroRel
     */
    public function setMovimientosTerceroRel($movimientosTerceroRel): void
    {
        $this->movimientosTerceroRel = $movimientosTerceroRel;
    }



}
