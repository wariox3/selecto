<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table(name="empresa")
 * @ORM\Entity(repositoryClass="App\Repository\EmpresaRepository")
 */
class Empresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoEmpresaPk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=255, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="empresaRel")
     */
    protected $usuariosEmpresaRel;



}
