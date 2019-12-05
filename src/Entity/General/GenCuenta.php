<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenCuentaRepository")
 */
class GenCuenta
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_pk", type="string", length=10, nullable=false)
     */
    private $codigoCuentaPk;

    /**
     * @ORM\Column(name="codigo_banco_fk", type="string", length=10, nullable=true)
     */
    private $codigoBancoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="cuenta", type="string", length=20)
     */
    private $cuenta;

    /**
     * @ORM\Column(name="tipo", type="string", length=60)
     */
    private $tipo;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\ManyToOne(targetEntity="GenBanco", inversedBy="cuentasBancoRel")
     * @ORM\JoinColumn(name="codigo_banco_fk", referencedColumnName="codigo_banco_pk")
     */
    protected $bancoRel;


}
