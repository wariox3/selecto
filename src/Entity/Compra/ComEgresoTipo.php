<?php

namespace App\Entity\Compra;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\Compra\ComEgresoTipoRepository")
*/

class ComEgresoTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_egreso_tipo_pk", type="string", length=10, nullable=false, unique=true)
     */
    private $codigoEgresoTipoPk;

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
     * @ORM\OneToMany(targetEntity="ComEgreso", mappedBy="egresoTipoRel")
     */
    protected $egresosEgresoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoEgresoTipoPk()
    {
        return $this->codigoEgresoTipoPk;
    }

    /**
     * @param mixed $codigoEgresoTipoPk
     */
    public function setCodigoEgresoTipoPk($codigoEgresoTipoPk): void
    {
        $this->codigoEgresoTipoPk = $codigoEgresoTipoPk;
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
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * @param mixed $prefijo
     */
    public function setPrefijo($prefijo): void
    {
        $this->prefijo = $prefijo;
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
    public function getEgresosEgresoTipoRel()
    {
        return $this->egresosEgresoTipoRel;
    }

    /**
     * @param mixed $egresosEgresoTipoRel
     */
    public function setEgresosEgresoTipoRel($egresosEgresoTipoRel): void
    {
        $this->egresosEgresoTipoRel = $egresosEgresoTipoRel;
    }



}
