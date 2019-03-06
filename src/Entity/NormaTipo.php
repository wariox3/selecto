<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="norma_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\NormaTipoRepository")
 */
class NormaTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoNormaTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="normaTipoRel")
     */
    protected $normasNormaTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoNormaTipoPk()
    {
        return $this->codigoNormaTipoPk;
    }

    /**
     * @param mixed $codigoNormaTipoPk
     */
    public function setCodigoNormaTipoPk($codigoNormaTipoPk): void
    {
        $this->codigoNormaTipoPk = $codigoNormaTipoPk;
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
    public function getNormasNormaTipoRel()
    {
        return $this->normasNormaTipoRel;
    }

    /**
     * @param mixed $normasNormaTipoRel
     */
    public function setNormasNormaTipoRel($normasNormaTipoRel): void
    {
        $this->normasNormaTipoRel = $normasNormaTipoRel;
    }



}
