<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="subgrupo")
 * @ORM\Entity(repositoryClass="App\Repository\SubgrupoRepository")
 */
class Subgrupo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoSubgrupoPk;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

}
