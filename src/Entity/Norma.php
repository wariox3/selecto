<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Norma
 *
 * @ORM\Table(name="norma")
 * @ORM\Entity(repositoryClass="App\Repository\NormaRepository")
 */
class Norma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoNormaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="codigo_subgrupo_fk", type="string", length=30, nullable=true)
     */
    private $codigoSubgrupoFk;

    /**
     * @ORM\Column(name="codigo_entidad_fk", type="string", length=30, nullable=true)
     */
    private $codigoEntidadFk;

    /**
     * @ORM\Column(name="codigo_jurisdiccion_fk", type="string", length=30, nullable=true)
     */
    private $codigoJurisdiccionFk;

    /**
     * @ORM\Column(name="estado_derogado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDerogado = false;

    /**
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="normasGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    private $grupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Subgrupo", inversedBy="normasSubgrupoRel")
     * @ORM\JoinColumn(name="codigo_subgrupo_fk", referencedColumnName="codigo_subgrupo_pk")
     */
    private $subgrupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Entidad", inversedBy="normasEntidadRel")
     * @ORM\JoinColumn(name="codigo_entidad_fk", referencedColumnName="codigo_entidad_pk")
     */
    private $entidadRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jurisdiccion", inversedBy="normasJurisdiccionRel")
     * @ORM\JoinColumn(name="codigo_jurisdiccion_fk", referencedColumnName="codigo_jurisdiccion_pk")
     */
    private $jurisdiccionRel;

    /**
     * @ORM\OneToMany(targetEntity="Malla", mappedBy="normaRel")
     */
    protected $mallasNormaRel;

    /**
     * @ORM\OneToMany(targetEntity="MatrizDetalle", mappedBy="normaRel")
     */
    protected $matricesDetallesNormaRel;

    /**
     * @return mixed
     */
    public function getCodigoNormaPk()
    {
        return $this->codigoNormaPk;
    }

    /**
     * @param mixed $codigoNormaPk
     */
    public function setCodigoNormaPk($codigoNormaPk): void
    {
        $this->codigoNormaPk = $codigoNormaPk;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getMallasNormaRel()
    {
        return $this->mallasNormaRel;
    }

    /**
     * @param mixed $mallasNormaRel
     */
    public function setMallasNormaRel($mallasNormaRel): void
    {
        $this->mallasNormaRel = $mallasNormaRel;
    }

    /**
     * @return mixed
     */
    public function getMatricesDetallesNormaRel()
    {
        return $this->matricesDetallesNormaRel;
    }

    /**
     * @param mixed $matricesDetallesNormaRel
     */
    public function setMatricesDetallesNormaRel($matricesDetallesNormaRel): void
    {
        $this->matricesDetallesNormaRel = $matricesDetallesNormaRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoDerogado()
    {
        return $this->estadoDerogado;
    }

    /**
     * @param mixed $estadoDerogado
     */
    public function setEstadoDerogado($estadoDerogado): void
    {
        $this->estadoDerogado = $estadoDerogado;
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
    public function getCodigoEntidadFk()
    {
        return $this->codigoEntidadFk;
    }

    /**
     * @param mixed $codigoEntidadFk
     */
    public function setCodigoEntidadFk($codigoEntidadFk): void
    {
        $this->codigoEntidadFk = $codigoEntidadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoJurisdiccionFk()
    {
        return $this->codigoJurisdiccionFk;
    }

    /**
     * @param mixed $codigoJurisdiccionFk
     */
    public function setCodigoJurisdiccionFk($codigoJurisdiccionFk): void
    {
        $this->codigoJurisdiccionFk = $codigoJurisdiccionFk;
    }

    /**
     * @return mixed
     */
    public function getEntidadRel()
    {
        return $this->entidadRel;
    }

    /**
     * @param mixed $entidadRel
     */
    public function setEntidadRel($entidadRel): void
    {
        $this->entidadRel = $entidadRel;
    }

    /**
     * @return mixed
     */
    public function getJurisdiccionRel()
    {
        return $this->jurisdiccionRel;
    }

    /**
     * @param mixed $jurisdiccionRel
     */
    public function setJurisdiccionRel($jurisdiccionRel): void
    {
        $this->jurisdiccionRel = $jurisdiccionRel;
    }



}
