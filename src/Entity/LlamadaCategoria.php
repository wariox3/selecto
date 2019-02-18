<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LlamadaCategoria
 *
 * @ORM\Table(name="llamada_categoria")
 * @ORM\Entity(repositoryClass="App\Repository\LlamadaCategoriaRepository")
 */
class LlamadaCategoria
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_categoria_llamada_pk", type="integer", unique=true)
     */
    private $codigoCategoriaLlamadaPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     *
     * @ORM\OneToMany(targetEntity="Llamada", mappedBy="categoriaRel")
     */

    private $llamadasCategoriaRel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->llamadasCategoriaRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codigoCategoriaLlamadaPk
     *
     * @return integer
     */
    public function getCodigoCategoriaLlamadaPk()
    {
        return $this->codigoCategoriaLlamadaPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return LlamadaCategoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return LlamadaCategoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add llamadasCategoriaRel
     *
     * @param \App\Entity\Llamada $llamadasCategoriaRel
     *
     * @return LlamadaCategoria
     */
    public function addLlamadasCategoriaRel(\App\Entity\Llamada $llamadasCategoriaRel)
    {
        $this->llamadasCategoriaRel[] = $llamadasCategoriaRel;

        return $this;
    }

    /**
     * Remove llamadasCategoriaRel
     *
     * @param \App\Entity\Llamada $llamadasCategoriaRel
     */
    public function removeLlamadasCategoriaRel(\App\Entity\Llamada $llamadasCategoriaRel)
    {
        $this->llamadasCategoriaRel->removeElement($llamadasCategoriaRel);
    }

    /**
     * Get llamadasCategoriaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLlamadasCategoriaRel()
    {
        return $this->llamadasCategoriaRel;
    }
}
