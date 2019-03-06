<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="jurisdiccion")
 * @ORM\Entity(repositoryClass="App\Repository\JurisdiccionRepository")
 */
class Jurisdiccion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=30)
     */
    private $codigoJurisdiccionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="jurisdiccionRel")
     */
    protected $normasJurisdiccionRel;

    /**
     * @return mixed
     */
    public function getCodigoJurisdiccionPk()
    {
        return $this->codigoJurisdiccionPk;
    }

    /**
     * @param mixed $codigoJurisdiccionPk
     */
    public function setCodigoJurisdiccionPk($codigoJurisdiccionPk): void
    {
        $this->codigoJurisdiccionPk = $codigoJurisdiccionPk;
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
    public function getNormasJurisdiccionRel()
    {
        return $this->normasJurisdiccionRel;
    }

    /**
     * @param mixed $normasJurisdiccionRel
     */
    public function setNormasJurisdiccionRel($normasJurisdiccionRel): void
    {
        $this->normasJurisdiccionRel = $normasJurisdiccionRel;
    }



}
