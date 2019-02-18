<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Caso
 *
 * @ORM\Table(name="implementacion_tema")
 * @ORM\Entity(repositoryClass="App\Repository\ImplementacionTemaRepository")
 */
class ImplementacionTema
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_implementacion_tema_pk", type="integer", unique=true)
     */
    private $codigoImplementacionTemaPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=250, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_implementacion_grupo_fk", type="integer", nullable=true)
     */
    private $codigoImplementacionGrupoFK;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable =true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="ImplementacionGrupo", inversedBy="implementacionesTemasImplementacionGrupoRel")
     * @ORM\JoinColumn(name="codigo_implementacion_grupo_fk", referencedColumnName="codigo_implementacion_grupo_pk")
     */
    private $implementacionGrupoRel;

    /**
     *
     * @ORM\OneToMany(targetEntity="ImplementacionDetalle", mappedBy="implementacionTemaRel")
     */
    private $implementacionesDetallesImplementacionTemaRel;

    /**
     * @return int
     */
    public function getCodigoImplementacionTemaPk(): int
    {
        return $this->codigoImplementacionTemaPk;
    }

    /**
     * @param int $codigoImplementacionTemaPk
     */
    public function setCodigoImplementacionTemaPk(int $codigoImplementacionTemaPk): void
    {
        $this->codigoImplementacionTemaPk = $codigoImplementacionTemaPk;
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
    public function getImplementacionesDetallesImplementacionTemaRel()
    {
        return $this->implementacionesDetallesImplementacionTemaRel;
    }

    /**
     * @param mixed $implementacionesDetallesImplementacionTemaRel
     */
    public function setImplementacionesDetallesImplementacionTemaRel($implementacionesDetallesImplementacionTemaRel): void
    {
        $this->implementacionesDetallesImplementacionTemaRel = $implementacionesDetallesImplementacionTemaRel;
    }

    /**
     * @return mixed
     */
    public function getImplementacionGrupoRel()
    {
        return $this->implementacionGrupoRel;
    }

    /**
     * @param mixed $implementacionGrupoRel
     */
    public function setImplementacionGrupoRel($implementacionGrupoRel): void
    {
        $this->implementacionGrupoRel = $implementacionGrupoRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoImplementacionGrupoFK()
    {
        return $this->codigoImplementacionGrupoFK;
    }

    /**
     * @param mixed $codigoImplementacionGrupoFK
     */
    public function setCodigoImplementacionGrupoFK($codigoImplementacionGrupoFK): void
    {
        $this->codigoImplementacionGrupoFK = $codigoImplementacionGrupoFK;
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

}
