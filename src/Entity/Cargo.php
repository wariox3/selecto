<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cargo
 *
 * @ORM\Table(name="cargo")
 * @ORM\Entity(repositoryClass="App\Repository\CargoRepository")
 */
class Cargo
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo_cargo_pk", type="string",length=50, nullable=true)
     */
    private $codigoCargoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     *
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="cargoRel")
     */
    private $casosCargoRel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->casosCargoRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoCargoPk.
     *
     * @param string $codigoCargoPk
     *
     * @return Cargo
     */
    public function setCodigoCargoPk($codigoCargoPk)
    {
        $this->codigoCargoPk = $codigoCargoPk;

        return $this;
    }

    /**
     * Get codigoCargoPk.
     *
     * @return string
     */
    public function getCodigoCargoPk()
    {
        return $this->codigoCargoPk;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Cargo
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
     * Add casosCargoRel.
     *
     * @param \App\Entity\Caso $casosCargoRel
     *
     * @return Cargo
     */
    public function addCasosCargoRel(\App\Entity\Caso $casosCargoRel)
    {
        $this->casosCargoRel[] = $casosCargoRel;

        return $this;
    }

    /**
     * Remove casosCargoRel.
     *
     * @param \App\Entity\Caso $casosCargoRel
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCasosCargoRel(\App\Entity\Caso $casosCargoRel)
    {
        return $this->casosCargoRel->removeElement($casosCargoRel);
    }

    /**
     * Get casosCargoRel.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosCargoRel()
    {
        return $this->casosCargoRel;
    }
}
