<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="centro")
 * @ORM\Entity(repositoryClass="App\Repository\CentroRepository")
 */
class Centro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoCentroPk;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer")
     */
    private $codigoClienteFk;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="centrosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Malla", mappedBy="centroRel")
     */
    protected $mallasCentroRel;

}
