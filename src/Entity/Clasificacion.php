<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="clasificacion")
 * @ORM\Entity(repositoryClass="App\Repository\ClasificacionRepository")
 */
class Clasificacion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoClasificacionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="codigo_subgrupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoSubgrupoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="clasificacionesGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    private $grupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Subgrupo", inversedBy="clasificacionesSubgrupoRel")
     * @ORM\JoinColumn(name="codigo_subgrupo_fk", referencedColumnName="codigo_subgrupo_pk")
     */
    private $subgrupoRel;

    /**
     * @ORM\OneToMany(targetEntity="Obligacion", mappedBy="clasificacionRel")
     */
    protected $obligacionesClasificacionRel;

    /**
     * @return mixed
     */
    public function getCodigoClasificacionPk()
    {
        return $this->codigoClasificacionPk;
    }

    /**
     * @param mixed $codigoClasificacionPk
     */
    public function setCodigoClasificacionPk($codigoClasificacionPk): void
    {
        $this->codigoClasificacionPk = $codigoClasificacionPk;
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
    public function getCodigoSubgrupoFk()
    {
        return $this->codigoSubgrupoFk;
    }

    /**
     * @param mixed $codigoSubgrupoFk
     */
    public function setCodigoSubgrupoFk($codigoSubgrupoFk): void
    {
        $this->codigoSubgrupoFk = $codigoSubgrupoFk;
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
    public function getSubgrupoRel()
    {
        return $this->subgrupoRel;
    }

    /**
     * @param mixed $subgrupoRel
     */
    public function setSubgrupoRel($subgrupoRel): void
    {
        $this->subgrupoRel = $subgrupoRel;
    }

    /**
     * @return mixed
     */
    public function getObligacionesClasificacionRel()
    {
        return $this->obligacionesClasificacionRel;
    }

    /**
     * @param mixed $obligacionesClasificacionRel
     */
    public function setObligacionesClasificacionRel($obligacionesClasificacionRel): void
    {
        $this->obligacionesClasificacionRel = $obligacionesClasificacionRel;
    }



}
