<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="entidad")
 * @ORM\Entity(repositoryClass="App\Repository\EntidadRepository")
 */
class Entidad
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoEntidadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="entidadRel")
     */
    protected $normasEntidadRel;

    /**
     * @return mixed
     */
    public function getCodigoEntidadPk()
    {
        return $this->codigoEntidadPk;
    }

    /**
     * @param mixed $codigoEntidadPk
     */
    public function setCodigoEntidadPk($codigoEntidadPk): void
    {
        $this->codigoEntidadPk = $codigoEntidadPk;
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
    public function getNormasEntidadRel()
    {
        return $this->normasEntidadRel;
    }

    /**
     * @param mixed $normasEntidadRel
     */
    public function setNormasEntidadRel($normasEntidadRel): void
    {
        $this->normasEntidadRel = $normasEntidadRel;
    }



}
