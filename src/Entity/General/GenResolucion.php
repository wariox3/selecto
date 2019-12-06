<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenResolucionRepository")
 */
class GenResolucion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_resolucion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoResolucionPk;

    /**
     * @ORM\Column(name="numero", type="float", nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="prefijo", type="string",length=5, nullable=true)
     */
    private $prefijo;

    /**
     * @ORM\Column(name="numero_desde", type="float", nullable=true)
     */
    private $numeroDesde;

    /**
     * @ORM\Column(name="numero_hasta", type="float", nullable=true)
     */
    private $numeroHasta;

    /**
     * @ORM\Column(name="llave_tecnica", type="string",length=500, nullable=true)
     */
    private $llaveTecnica;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvMovimiento", mappedBy="resolucionRel")
     */
    protected $movimientosResolucionRel;

    /**
     * @return mixed
     */
    public function getCodigoResolucionPk()
    {
        return $this->codigoResolucionPk;
    }

    /**
     * @param mixed $codigoResolucionPk
     */
    public function setCodigoResolucionPk($codigoResolucionPk): void
    {
        $this->codigoResolucionPk = $codigoResolucionPk;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
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
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde): void
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
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
    public function getNumeroDesde()
    {
        return $this->numeroDesde;
    }

    /**
     * @param mixed $numeroDesde
     */
    public function setNumeroDesde($numeroDesde): void
    {
        $this->numeroDesde = $numeroDesde;
    }

    /**
     * @return mixed
     */
    public function getNumeroHasta()
    {
        return $this->numeroHasta;
    }

    /**
     * @param mixed $numeroHasta
     */
    public function setNumeroHasta($numeroHasta): void
    {
        $this->numeroHasta = $numeroHasta;
    }

    /**
     * @return mixed
     */
    public function getLlaveTecnica()
    {
        return $this->llaveTecnica;
    }

    /**
     * @param mixed $llaveTecnica
     */
    public function setLlaveTecnica($llaveTecnica): void
    {
        $this->llaveTecnica = $llaveTecnica;
    }

    /**
     * @return mixed
     */
    public function getMovimientosResolucionRel()
    {
        return $this->movimientosResolucionRel;
    }

    /**
     * @param mixed $movimientosResolucionRel
     */
    public function setMovimientosResolucionRel($movimientosResolucionRel): void
    {
        $this->movimientosResolucionRel = $movimientosResolucionRel;
    }



}
