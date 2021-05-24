<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoType
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoTipoRepository")
 */
class MovimientoTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_tipo_pk", type="string", length=5)
     */
    private $codigoMovimientoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @ORM\Column(name="abreviatura", type="string", length=10)
     */
    private $abreviatura;

    /**
     * @ORM\Column(name="genera_cartera", type="boolean", options={"default":false})
     */
    private $generaCartera = false;

    /**
     * @ORM\Column(name="genera_tesoreria", type="boolean", options={"default":false})
     */
    private $generaTesoreria = false;

    /**
     * @ORM\Column(name="operacion_inventario", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionInventario = 0;

    /**
     * @ORM\Column(name="operacion_comercial", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionComercial = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="movimientoTipoRel")
     */
    protected $movimientosMovimientoTipoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MovimientoTipoEmpresa", mappedBy="movimientoTipoRel")
     */
    protected $movimientosTiposEmpresasMovimientoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoTipoPk()
    {
        return $this->codigoMovimientoTipoPk;
    }

    /**
     * @param mixed $codigoMovimientoTipoPk
     */
    public function setCodigoMovimientoTipoPk($codigoMovimientoTipoPk): void
    {
        $this->codigoMovimientoTipoPk = $codigoMovimientoTipoPk;
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
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * @param mixed $abreviatura
     */
    public function setAbreviatura($abreviatura): void
    {
        $this->abreviatura = $abreviatura;
    }

    /**
     * @return bool
     */
    public function isGeneraCartera(): bool
    {
        return $this->generaCartera;
    }

    /**
     * @param bool $generaCartera
     */
    public function setGeneraCartera(bool $generaCartera): void
    {
        $this->generaCartera = $generaCartera;
    }

    /**
     * @return bool
     */
    public function isGeneraTesoreria(): bool
    {
        return $this->generaTesoreria;
    }

    /**
     * @param bool $generaTesoreria
     */
    public function setGeneraTesoreria(bool $generaTesoreria): void
    {
        $this->generaTesoreria = $generaTesoreria;
    }

    /**
     * @return int
     */
    public function getOperacionInventario(): int
    {
        return $this->operacionInventario;
    }

    /**
     * @param int $operacionInventario
     */
    public function setOperacionInventario(int $operacionInventario): void
    {
        $this->operacionInventario = $operacionInventario;
    }

    /**
     * @return mixed
     */
    public function getMovimientosMovimientoTipoRel()
    {
        return $this->movimientosMovimientoTipoRel;
    }

    /**
     * @param mixed $movimientosMovimientoTipoRel
     */
    public function setMovimientosMovimientoTipoRel($movimientosMovimientoTipoRel): void
    {
        $this->movimientosMovimientoTipoRel = $movimientosMovimientoTipoRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosTiposEmpresasMovimientoTipoRel()
    {
        return $this->movimientosTiposEmpresasMovimientoTipoRel;
    }

    /**
     * @param mixed $movimientosTiposEmpresasMovimientoTipoRel
     */
    public function setMovimientosTiposEmpresasMovimientoTipoRel($movimientosTiposEmpresasMovimientoTipoRel): void
    {
        $this->movimientosTiposEmpresasMovimientoTipoRel = $movimientosTiposEmpresasMovimientoTipoRel;
    }

    /**
     * @return int
     */
    public function getOperacionComercial(): int
    {
        return $this->operacionComercial;
    }

    /**
     * @param int $operacionComercial
     */
    public function setOperacionComercial(int $operacionComercial): void
    {
        $this->operacionComercial = $operacionComercial;
    }



}
