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
     * @ORM\OneToMany(targetEntity="Norma", mappedBy="subgrupoRel")
     */
    protected $normasSubgrupoRel;

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



}
