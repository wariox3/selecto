<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="area")
 * @ORM\Entity(repositoryClass="App\Repository\AreaRepository")
 */
class Area
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo_area_pk", type="string",length=50, nullable=true)
     */
    private $codigoAreaPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     *
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="areaRel")
     */
    private $casosAreaRel;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->casosAreaRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoAreaPk.
     *
     * @param string $codigoAreaPk
     *
     * @return Area
     */
    public function setCodigoAreaPk($codigoAreaPk)
    {
        $this->codigoAreaPk = $codigoAreaPk;

        return $this;
    }

    /**
     * Get codigoAreaPk.
     *
     * @return string
     */
    public function getCodigoAreaPk()
    {
        return $this->codigoAreaPk;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Area
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add casosAreaRel.
     *
     * @param \App\Entity\Caso $casosAreaRel
     *
     * @return Area
     */
    public function addCasosAreaRel(\App\Entity\Caso $casosAreaRel)
    {
        $this->casosAreaRel[] = $casosAreaRel;

        return $this;
    }

    /**
     * Remove casosAreaRel.
     *
     * @param \App\Entity\Caso $casosAreaRel
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCasosAreaRel(\App\Entity\Caso $casosAreaRel)
    {
        return $this->casosAreaRel->removeElement($casosAreaRel);
    }

    /**
     * Get casosAreaRel.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosAreaRel()
    {
        return $this->casosAreaRel;
    }
}
