<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity(repositoryClass="App\Repository\GrupoRepository")
 */
class Grupo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoGrupoPk;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

}
