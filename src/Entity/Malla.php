<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="malla")
 * @ORM\Entity(repositoryClass="App\Repository\MallaRepository")
 */
class Malla
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoMallaPk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer")
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="codigo_centro_fk", type="integer")
     */
    private $codigoCentroFk;

    /**
     * @ORM\Column(name="codigo_norma_fk", type="integer")
     */
    private $codigoNormaFk;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="mallasClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="Centro", inversedBy="mallasCentroRel")
     * @ORM\JoinColumn(name="codigo_centro_fk", referencedColumnName="codigo_centro_pk")
     */
    private $centroRel;

    /**
     * @ORM\ManyToOne(targetEntity="Norma", inversedBy="mallasNormaRel")
     * @ORM\JoinColumn(name="codigo_norma_fk", referencedColumnName="codigo_norma_pk")
     */
    private $normaRel;

}
