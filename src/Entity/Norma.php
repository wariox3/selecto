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
     * @ORM\Column(name="codigo_matriz_fk", type="integer", nullable=true)
     */
    private $codigoMatrizFk;

    /**
     * @ORM\Column(name="codigo_norma_tipo_fk", type="string", length=30, nullable=true)
     */
    private $codigoNormaTipoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

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
     * @ORM\ManyToOne(targetEntity="Matriz", inversedBy="normasMatrizRel")
     * @ORM\JoinColumn(name="codigo_matriz_fk", referencedColumnName="codigo_matriz_pk")
     */
    private $matrizRel;

    /**
     * @ORM\ManyToOne(targetEntity="NormaTipo", inversedBy="normasNormaTipoRel")
     * @ORM\JoinColumn(name="codigo_norma_tipo_fk", referencedColumnName="codigo_norma_tipo_pk")
     */
    private $normaTipoRel;

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
     * @ORM\OneToMany(targetEntity="Obligacion", mappedBy="normaRel")
     */
    protected $obligacionesNormaRel;

    /**
     * @ORM\OneToMany(targetEntity="Vigencia", mappedBy="normaRel")
     */
    protected $vigenciasNormaRel;

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
    public function getCodigoMatrizFk()
    {
        return $this->codigoMatrizFk;
    }

    /**
     * @param mixed $codigoMatrizFk
     */
    public function setCodigoMatrizFk($codigoMatrizFk): void
    {
        $this->codigoMatrizFk = $codigoMatrizFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoNormaTipoFk()
    {
        return $this->codigoNormaTipoFk;
    }

    /**
     * @param mixed $codigoNormaTipoFk
     */
    public function setCodigoNormaTipoFk($codigoNormaTipoFk): void
    {
        $this->codigoNormaTipoFk = $codigoNormaTipoFk;
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
    public function getMatrizRel()
    {
        return $this->matrizRel;
    }

    /**
     * @param mixed $matrizRel
     */
    public function setMatrizRel($matrizRel): void
    {
        $this->matrizRel = $matrizRel;
    }

    /**
     * @return mixed
     */
    public function getNormaTipoRel()
    {
        return $this->normaTipoRel;
    }

    /**
     * @param mixed $normaTipoRel
     */
    public function setNormaTipoRel($normaTipoRel): void
    {
        $this->normaTipoRel = $normaTipoRel;
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
    public function getObligacionesNormaRel()
    {
        return $this->obligacionesNormaRel;
    }

    /**
     * @param mixed $obligacionesNormaRel
     */
    public function setObligacionesNormaRel($obligacionesNormaRel): void
    {
        $this->obligacionesNormaRel = $obligacionesNormaRel;
    }

    /**
     * @return mixed
     */
    public function getVigenciasNormaRel()
    {
        return $this->vigenciasNormaRel;
    }

    /**
     * @param mixed $vigenciasNormaRel
     */
    public function setVigenciasNormaRel($vigenciasNormaRel): void
    {
        $this->vigenciasNormaRel = $vigenciasNormaRel;
    }



}
