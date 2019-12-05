<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenBancoRepository")
 */
class GenBanco
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_banco_pk", type="string", length=10, nullable=false)
     */
    private $codigoBancoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_general", type="string", length=20, nullable=true)
     */
    private $codigoGeneral;

    /**
     * @ORM\Column(name="nit", type="string", length=10, nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="direccion", type="string", length=80, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity="GenCuenta", mappedBy="bancoRel")
     */
    protected $cuentasBancoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="bancoRel")
     */
    protected $empleadosBancoRel;


}
