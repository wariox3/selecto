<?php
/**
 * Created by PhpStorm.
 * User: avera
 * Date: 5/12/17
 * Time: 08:13 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caso
 *
 * @ORM\Table(name="caso_categoria")
 * @ORM\Entity(repositoryClass="App\Repository\CasoCategoriaRepository")
 */
class CasoCategoria
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo_categoria_caso_pk", type="string", length=50, unique=true)
     */
    private $codigoCategoriaCasoPk;

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
     *
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="categoriaRel")
     */
    private $casosCategoriaRel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->casosCategoriaRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoCategoriaCasoPk
     *
     * @param string $codigoCategoriaCasoPk
     *
     * @return CasoCategoria
     */
    public function setCodigoCategoriaCasoPk($codigoCategoriaCasoPk)
    {
        $this->codigoCategoriaCasoPk = $codigoCategoriaCasoPk;

        return $this;
    }

    /**
     * Get codigoCategoriaCasoPk
     *
     * @return string
     */
    public function getCodigoCategoriaCasoPk()
    {
        return $this->codigoCategoriaCasoPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CasoCategoria
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
     * @return CasoCategoria
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
     * Set color
     *
     * @param string $color
     *
     * @return CasoCategoria
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add casosCategoriaRel
     *
     * @param \App\Entity\Caso $casosCategoriaRel
     *
     * @return CasoCategoria
     */
    public function addCasosCategoriaRel(\App\Entity\Caso $casosCategoriaRel)
    {
        $this->casosCategoriaRel[] = $casosCategoriaRel;

        return $this;
    }

    /**
     * Remove casosCategoriaRel
     *
     * @param \App\Entity\Caso $casosCategoriaRel
     */
    public function removeCasosCategoriaRel(\App\Entity\Caso $casosCategoriaRel)
    {
        $this->casosCategoriaRel->removeElement($casosCategoriaRel);
    }

    /**
     * Get casosCategoriaRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosCategoriaRel()
    {
        return $this->casosCategoriaRel;
    }
}
