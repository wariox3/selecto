<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table(name="rol")
 * @ORM\Entity(repositoryClass="App\Repository\RolRepository")
 */
class Rol
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_rol_pk", type="integer", unique=true)
     */
    private $codigoRolPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

//
//    /**
//     *
//     * ORM\OneToMany(targetEntity="Usuario", mappedBy="rolRel")
//     */
//
//    private $usuarioRolRel;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarioRolRel = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Add usuarioRolRel
     *
     * @param \App\Entity\Usuario $usuarioRolRel
     *
     * @return usuarioRolRel
     */
    public function addusuarioRolRel(\App\Entity\Usuario $usuarioRolRel)
    {
        $this->usuarioRolRel[] = $usuarioRolRel;

        return $this;
    }

    /**
     * Remove usuarioRolRel
     *
     * @param \App\Entity\Usuario $usuarioRolRel
     */
    public function removeUsuarioRolRel(\App\Entity\Usuario $usuarioRolRel)
    {
        $this->usuarioRolRel->removeElement($usuarioRolRel);
    }

    /**
     * Get usuarioRolRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarioRolRel()
    {
        return $this->usuarioRolRel;
    }

    /**
     * Get codigoRolPk
     *
     * @return integer
     */
    public function getCodigoRolPk()
    {
        return $this->codigoRolPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Rol
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
}
