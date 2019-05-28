<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenBancoRepository")
 */
class GenBanco
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_banco_pk", type="string", length=10, nullable=false)
     */
    private $codigoBancoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_general", type="string", length=20, nullable=true)
     */
    private $codigoGeneral;

    /**
     * @ORM\Column(name="nit", type="string", length=10, nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="direccion", type="string", length=80, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity="GenCuenta", mappedBy="bancoRel")
     */
    protected $cuentasBancoRel;

    /**
     * @return mixed
     */
    public function getCodigoBancoPk()
    {
        return $this->codigoBancoPk;
    }

    /**
     * @param mixed $codigoBancoPk
     */
    public function setCodigoBancoPk($codigoBancoPk): void
    {
        $this->codigoBancoPk = $codigoBancoPk;
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
    public function getNumeroDigitos()
    {
        return $this->numeroDigitos;
    }

    /**
     * @param mixed $numeroDigitos
     */
    public function setNumeroDigitos($numeroDigitos): void
    {
        $this->numeroDigitos = $numeroDigitos;
    }

    /**
     * @return mixed
     */
    public function getCodigoGeneral()
    {
        return $this->codigoGeneral;
    }

    /**
     * @param mixed $codigoGeneral
     */
    public function setCodigoGeneral($codigoGeneral): void
    {
        $this->codigoGeneral = $codigoGeneral;
    }

    /**
     * @return mixed
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getCuentasBancoRel()
    {
        return $this->cuentasBancoRel;
    }

    /**
     * @param mixed $cuentasBancoRel
     */
    public function setCuentasBancoRel($cuentasBancoRel): void
    {
        $this->cuentasBancoRel = $cuentasBancoRel;
    }



}
