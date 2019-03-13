<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="subgrupo")
 * @ORM\Entity(repositoryClass="App\Repository\SubgrupoRepository")
 */
class Subgrupo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoSubgrupoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="subgruposGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    private $grupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="subgrupoRel")
     */
    protected $normasSubgrupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Obligacion", mappedBy="subgrupoRel")
     */
    protected $obligacionesSubgrupoRel;

    /**
     * @return mixed
     */
    public function getCodigoSubgrupoPk()
    {
        return $this->codigoSubgrupoPk;
    }

    /**
     * @param mixed $codigoSubgrupoPk
     */
    public function setCodigoSubgrupoPk($codigoSubgrupoPk): void
    {
        $this->codigoSubgrupoPk = $codigoSubgrupoPk;
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
    public function getNormasSubgrupoRel()
    {
        return $this->normasSubgrupoRel;
    }

    /**
     * @param mixed $normasSubgrupoRel
     */
    public function setNormasSubgrupoRel($normasSubgrupoRel): void
    {
        $this->normasSubgrupoRel = $normasSubgrupoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoGrupoFk()
    {
        return $this->codigoGrupoFk;
    }

    /**
     * @param mixed $codigoGrupoFk
     */
    public function setCodigoGrupoFk($codigoGrupoFk): void
    {
        $this->codigoGrupoFk = $codigoGrupoFk;
    }

    /**
     * @return mixed
     */
    public function getGrupoRel()
    {
        return $this->grupoRel;
    }

    /**
     * @param mixed $grupoRel
     */
    public function setGrupoRel($grupoRel): void
    {
        $this->grupoRel = $grupoRel;
    }



}
