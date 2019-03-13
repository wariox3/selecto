<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="matriz")
 * @ORM\Entity(repositoryClass="App\Repository\MatrizRepository")
 */
class Matriz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoMatrizPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="matricesGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    private $grupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="matrizRel")
     */
    protected $normasMatrizRel;

    /**
     * @ORM\OneToMany(targetEntity="Obligacion", mappedBy="matrizRel")
     */
    protected $obligacionesMatrizRel;

    /**
     * @return mixed
     */
    public function getCodigoMatrizPk()
    {
        return $this->codigoMatrizPk;
    }

    /**
     * @param mixed $codigoMatrizPk
     */
    public function setCodigoMatrizPk($codigoMatrizPk): void
    {
        $this->codigoMatrizPk = $codigoMatrizPk;
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

    /**
     * @return mixed
     */
    public function getNormasMatrizRel()
    {
        return $this->normasMatrizRel;
    }

    /**
     * @param mixed $normasMatrizRel
     */
    public function setNormasMatrizRel($normasMatrizRel): void
    {
        $this->normasMatrizRel = $normasMatrizRel;
    }

    /**
     * @return mixed
     */
    public function getObligacionesMatrizRel()
    {
        return $this->obligacionesMatrizRel;
    }

    /**
     * @param mixed $obligacionesMatrizRel
     */
    public function setObligacionesMatrizRel($obligacionesMatrizRel): void
    {
        $this->obligacionesMatrizRel = $obligacionesMatrizRel;
    }



}
