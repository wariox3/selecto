<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenPaisRepository")
 */
class GenPais
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_pais_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPaisPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="GenDepartamento", mappedBy="paisRel")
     */
    protected $departamentosPaisRel;


}
