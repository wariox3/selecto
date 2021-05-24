<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImpuestoRepository")
 */
class Impuesto
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_impuesto_pk", type="string", length=3, nullable=false)
     */
    private $codigoImpuestoPk;

    /**
     * @ORM\Column(name="codigo_impuesto_tipo_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoTipoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="porcentaje", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="base", type="float", nullable=true, options={"default" : 0})
     */
    private $base = 0;

    /**
     * @ORM\Column(name="codigo_cuenta_fk", type="string", length=20, nullable=true)
     */
    private $codigoCuentaFk;

    /**
     * @ORM\Column(name="codigo_cuenta_devolucion_fk", type="string", length=20, nullable=true)
     */
    private $codigoCuentaDevolucionFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImpuestoTipo", inversedBy="impuestosImpuestoTipoRel")
     * @ORM\JoinColumn(name="codigo_impuesto_tipo_fk",referencedColumnName="codigo_impuesto_tipo_pk")
     */
    protected $impuestoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoImpuestoPk()
    {
        return $this->codigoImpuestoPk;
    }

    /**
     * @param mixed $codigoImpuestoPk
     */
    public function setCodigoImpuestoPk($codigoImpuestoPk): void
    {
        $this->codigoImpuestoPk = $codigoImpuestoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoImpuestoTipoFk()
    {
        return $this->codigoImpuestoTipoFk;
    }

    /**
     * @param mixed $codigoImpuestoTipoFk
     */
    public function setCodigoImpuestoTipoFk($codigoImpuestoTipoFk): void
    {
        $this->codigoImpuestoTipoFk = $codigoImpuestoTipoFk;
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
     * @return int
     */
    public function getPorcentaje(): int
    {
        return $this->porcentaje;
    }

    /**
     * @param int $porcentaje
     */
    public function setPorcentaje(int $porcentaje): void
    {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return int
     */
    public function getBase(): int
    {
        return $this->base;
    }

    /**
     * @param int $base
     */
    public function setBase(int $base): void
    {
        $this->base = $base;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaFk()
    {
        return $this->codigoCuentaFk;
    }

    /**
     * @param mixed $codigoCuentaFk
     */
    public function setCodigoCuentaFk($codigoCuentaFk): void
    {
        $this->codigoCuentaFk = $codigoCuentaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaDevolucionFk()
    {
        return $this->codigoCuentaDevolucionFk;
    }

    /**
     * @param mixed $codigoCuentaDevolucionFk
     */
    public function setCodigoCuentaDevolucionFk($codigoCuentaDevolucionFk): void
    {
        $this->codigoCuentaDevolucionFk = $codigoCuentaDevolucionFk;
    }

    /**
     * @return mixed
     */
    public function getImpuestoTipoRel()
    {
        return $this->impuestoTipoRel;
    }

    /**
     * @param mixed $impuestoTipoRel
     */
    public function setImpuestoTipoRel($impuestoTipoRel): void
    {
        $this->impuestoTipoRel = $impuestoTipoRel;
    }



}

