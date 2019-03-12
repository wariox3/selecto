<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="accion")
 * @ORM\Entity(repositoryClass="App\Repository\AccionRepository")
 */
class Accion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoAccionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Articulo", mappedBy="accionRel")
     */
    protected $articulosAccionRel;

    /**
     * @return mixed
     */
    public function getCodigoAccionPk()
    {
        return $this->codigoAccionPk;
    }

    /**
     * @param mixed $codigoAccionPk
     */
    public function setCodigoAccionPk($codigoAccionPk): void
    {
        $this->codigoAccionPk = $codigoAccionPk;
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
    public function getArticulosAccionRel()
    {
        return $this->articulosAccionRel;
    }

    /**
     * @param mixed $articulosAccionRel
     */
    public function setArticulosAccionRel($articulosAccionRel): void
    {
        $this->articulosAccionRel = $articulosAccionRel;
    }



}
