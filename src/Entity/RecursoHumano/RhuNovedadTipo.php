<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuNovedadTipo
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuNovedadTipoRepository")
 */
class RhuNovedadTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_novedad_tipo_pk", type="string", length=10)
     */
    private $codigoNovedadTipoPk;

    /**
     * @ORM\Column(name="codigo_concepto_fk", type="string",length=10, nullable=true)
     */
    private $codigoConceptoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="incapacidad", type="boolean", nullable=true, options={"default":false})
     */
    private $incapacidad = false;

    /**
     * @ORM\Column(name="licencia", type="boolean", nullable=true, options={"default":false})
     */
    private $licencia = false;

    /**
     * @ORM\OneToMany(targetEntity="RhuNovedad", mappedBy="novedadTipoRel")
     */
    protected $novedadesNovedadTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuConcepto", inversedBy="novedadesConceptoRel")
     * @ORM\JoinColumn(name="codigo_concepto_fk", referencedColumnName="codigo_concepto_pk")
     */
    protected $conceptoRel;

    /**
     * @return mixed
     */
    public function getCodigoNovedadTipoPk()
    {
        return $this->codigoNovedadTipoPk;
    }

    /**
     * @param mixed $codigoNovedadTipoPk
     */
    public function setCodigoNovedadTipoPk($codigoNovedadTipoPk): void
    {
        $this->codigoNovedadTipoPk = $codigoNovedadTipoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoFk()
    {
        return $this->codigoConceptoFk;
    }

    /**
     * @param mixed $codigoConceptoFk
     */
    public function setCodigoConceptoFk($codigoConceptoFk): void
    {
        $this->codigoConceptoFk = $codigoConceptoFk;
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
     * @return bool
     */
    public function isIncapacidad(): bool
    {
        return $this->incapacidad;
    }

    /**
     * @param bool $incapacidad
     */
    public function setIncapacidad(bool $incapacidad): void
    {
        $this->incapacidad = $incapacidad;
    }

    /**
     * @return bool
     */
    public function isLicencia(): bool
    {
        return $this->licencia;
    }

    /**
     * @param bool $licencia
     */
    public function setLicencia(bool $licencia): void
    {
        $this->licencia = $licencia;
    }

    /**
     * @return mixed
     */
    public function getNovedadesNovedadTipoRel()
    {
        return $this->novedadesNovedadTipoRel;
    }

    /**
     * @param mixed $novedadesNovedadTipoRel
     */
    public function setNovedadesNovedadTipoRel($novedadesNovedadTipoRel): void
    {
        $this->novedadesNovedadTipoRel = $novedadesNovedadTipoRel;
    }

    /**
     * @return mixed
     */
    public function getConceptoRel()
    {
        return $this->conceptoRel;
    }

    /**
     * @param mixed $conceptoRel
     */
    public function setConceptoRel($conceptoRel): void
    {
        $this->conceptoRel = $conceptoRel;
    }

}