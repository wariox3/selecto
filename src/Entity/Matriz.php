<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="matriz")
 * @ORM\Entity(repositoryClass="App\Repository\MatrizRepository")
 */
class Matriz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoMatrizPk;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="MatrizDetalle", mappedBy="matrizRel")
     */
    protected $matricesDetallesMatrizRel;

}
