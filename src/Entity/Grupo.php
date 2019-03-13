<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity(repositoryClass="App\Repository\GrupoRepository")
 */
class Grupo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoGrupoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Subgrupo", mappedBy="grupoRel")
     */
    protected $subgruposGrupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="grupoRel")
     */
    protected $normasGrupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Matriz", mappedBy="grupoRel")
     */
    protected $matricesGrupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Obligacion", mappedBy="grupoRel")
     */
    protected $obligacionesGrupoRel;

    /**
     * @return mixed
     */
    public function getCodigoGrupoPk()
    {
        return $this->codigoGrupoPk;
    }

    /**
     * @param mixed $codigoGrupoPk
     */
    public function setCodigoGrupoPk($codigoGrupoPk): void
    {
        $this->codigoGrupoPk = $codigoGrupoPk;
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
    public function getNormasGrupoRel()
    {
        return $this->normasGrupoRel;
    }

    /**
     * @param mixed $normasGrupoRel
     */
    public function setNormasGrupoRel($normasGrupoRel): void
    {
        $this->normasGrupoRel = $normasGrupoRel;
    }

    /**
     * @return mixed
     */
    public function getSubgruposGrupoRel()
    {
        return $this->subgruposGrupoRel;
    }

    /**
     * @param mixed $subgruposGrupoRel
     */
    public function setSubgruposGrupoRel($subgruposGrupoRel): void
    {
        $this->subgruposGrupoRel = $subgruposGrupoRel;
    }

    /**
     * @return mixed
     */
    public function getMatricesGrupoRel()
    {
        return $this->matricesGrupoRel;
    }

    /**
     * @param mixed $matricesGrupoRel
     */
    public function setMatricesGrupoRel($matricesGrupoRel): void
    {
        $this->matricesGrupoRel = $matricesGrupoRel;
    }



}
