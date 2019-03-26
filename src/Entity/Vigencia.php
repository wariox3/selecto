<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vigencia")
 * @ORM\Entity(repositoryClass="App\Repository\VigenciaRepository")
 */
class Vigencia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoVigenciaPk;

    /**
     * @ORM\Column(name="codigo_norma_fk", type="integer", nullable=true)
     */
    private $codigoNormaFk;

    /**
     * @ORM\Column(name="vigencia", type="text", nullable=true)
     */
    private $vigencia;

    /**
     * @ORM\ManyToOne(targetEntity="Norma", inversedBy="vigenciasNormaRel")
     * @ORM\JoinColumn(name="codigo_norma_fk", referencedColumnName="codigo_norma_pk")
     */
    private $normaRel;

    /**
     * @return mixed
     */
    public function getCodigoVigenciaPk()
    {
        return $this->codigoVigenciaPk;
    }

    /**
     * @param mixed $codigoVigenciaPk
     */
    public function setCodigoVigenciaPk($codigoVigenciaPk): void
    {
        $this->codigoVigenciaPk = $codigoVigenciaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoNormaFk()
    {
        return $this->codigoNormaFk;
    }

    /**
     * @param mixed $codigoNormaFk
     */
    public function setCodigoNormaFk($codigoNormaFk): void
    {
        $this->codigoNormaFk = $codigoNormaFk;
    }

    /**
     * @return mixed
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * @param mixed $vigencia
     */
    public function setVigencia($vigencia): void
    {
        $this->vigencia = $vigencia;
    }

    /**
     * @return mixed
     */
    public function getNormaRel()
    {
        return $this->normaRel;
    }

    /**
     * @param mixed $normaRel
     */
    public function setNormaRel($normaRel): void
    {
        $this->normaRel = $normaRel;
    }




}
