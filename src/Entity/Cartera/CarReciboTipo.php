<?php

namespace App\Entity\Cartera;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\Cartera\CarReciboTipoRepository")
*/

class CarReciboTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10, nullable=false, unique=true)
     */
    private $codigoReciboTipoPk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="consecutivo", type="integer", nullable=true)
     */
    private $consecutivo = 0;

    /**
     * @ORM\Column(name="codigo_comprobante_fk", type="string", length=20, nullable=true)
     */
    private $codigoComprobanteFk;

    /**
     * @ORM\Column(name="prefijo", type="string", length=20, nullable=true)
     */
    private $prefijo;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;

    /**
     * @ORM\Column(name="cruce_cuentas", type="boolean", nullable=true, options={"default" : false})
     */
    private $cruceCuentas = 0;

    /**
     * @ORM\OneToMany(targetEntity="CarRecibo", mappedBy="reciboTipoRel")
     */
    protected $recibosReciboTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoReciboTipoPk()
    {
        return $this->codigoReciboTipoPk;
    }

    /**
     * @param mixed $codigoReciboTipoPk
     */
    public function setCodigoReciboTipoPk($codigoReciboTipoPk): void
    {
        $this->codigoReciboTipoPk = $codigoReciboTipoPk;
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
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * @param mixed $consecutivo
     */
    public function setConsecutivo($consecutivo): void
    {
        $this->consecutivo = $consecutivo;
    }

    /**
     * @return mixed
     */
    public function getCodigoComprobanteFk()
    {
        return $this->codigoComprobanteFk;
    }

    /**
     * @param mixed $codigoComprobanteFk
     */
    public function setCodigoComprobanteFk($codigoComprobanteFk): void
    {
        $this->codigoComprobanteFk = $codigoComprobanteFk;
    }

    /**
     * @return mixed
     */
    public function getRecibosReciboTipoRel()
    {
        return $this->recibosReciboTipoRel;
    }

    /**
     * @param mixed $recibosReciboTipoRel
     */
    public function setRecibosReciboTipoRel($recibosReciboTipoRel): void
    {
        $this->recibosReciboTipoRel = $recibosReciboTipoRel;
    }

    /**
     * @return mixed
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * @param mixed $orden
     */
    public function setOrden($orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return mixed
     */
    public function getCruceCuentas()
    {
        return $this->cruceCuentas;
    }

    /**
     * @param mixed $cruceCuentas
     */
    public function setCruceCuentas( $cruceCuentas ): void
    {
        $this->cruceCuentas = $cruceCuentas;
    }

    /**
     * @return mixed
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * @param mixed $prefijo
     */
    public function setPrefijo( $prefijo ): void
    {
        $this->prefijo = $prefijo;
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


}
