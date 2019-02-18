<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulo
 *
 * @ORM\Table(name="modulo")
 * @ORM\Entity(repositoryClass="App\Repository\ModuloRepository")
 */
class Modulo
{

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo_modulo_pk", type="string", length=255, unique=true)
     */
    private $codigoModuloPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     *
     * @ORM\OneToMany(targetEntity="Llamada", mappedBy="moduloRel")
     */

    private $llamadasModuloRel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->llamadasModuloRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoModuloPk
     *
     * @param string $codigoModuloPk
     *
     * @return Modulo
     */
    public function setCodigoModuloPk($codigoModuloPk)
    {
        $this->codigoModuloPk = $codigoModuloPk;

        return $this;
    }

    /**
     * Get codigoModuloPk
     *
     * @return string
     */
    public function getCodigoModuloPk()
    {
        return $this->codigoModuloPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Modulo
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
     * Add llamadasModuloRel
     *
     * @param \App\Entity\Llamada $llamadasModuloRel
     *
     * @return Modulo
     */
    public function addLlamadasModuloRel(\App\Entity\Llamada $llamadasModuloRel)
    {
        $this->llamadasModuloRel[] = $llamadasModuloRel;

        return $this;
    }

    /**
     * Remove llamadasModuloRel
     *
     * @param \App\Entity\Llamada $llamadasModuloRel
     */
    public function removeLlamadasModuloRel(\App\Entity\Llamada $llamadasModuloRel)
    {
        $this->llamadasModuloRel->removeElement($llamadasModuloRel);
    }

    /**
     * Get llamadasModuloRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLlamadasModuloRel()
    {
        return $this->llamadasModuloRel;
    }
}
