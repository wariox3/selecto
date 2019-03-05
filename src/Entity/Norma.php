<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Norma
 *
 * @ORM\Table(name="norma")
 * @ORM\Entity(repositoryClass="App\Repository\NormaRepository")
 */
class Norma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoNormaPk;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Malla", mappedBy="normaRel")
     */
    protected $mallasNormaRel;

    /**
     * @ORM\OneToMany(targetEntity="MatrizDetalle", mappedBy="normaRel")
     */
    protected $matricesDetallesNormaRel;

}
