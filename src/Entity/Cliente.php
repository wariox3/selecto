<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoClientePk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=255, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\OneToMany(targetEntity="Centro", mappedBy="clienteRel")
     */
    protected $centrosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Malla", mappedBy="clienteRel")
     */
    protected $mallasClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="clienteRel")
     */
    protected $usuariosClienteRel;

}
