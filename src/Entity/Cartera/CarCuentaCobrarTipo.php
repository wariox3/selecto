<?php

namespace App\Entity\Cartera;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaCobrarTipoType
 * @ORM\Entity(repositoryClass="App\Repository\Cartera\CarCuentaCobrarTipoRepository")
 */
class CarCuentaCobrarTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_cobrar_tipo_pk", type="string", length=5)
     */
    private $codigoCuentaCobrarTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="operacion", type="integer")
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="saldo_inicial", type="boolean", options={"default":false})
     */
    private $saldoInicial;

    /**
     * @ORM\Column(name="prefijo", type="string", length=5, nullable=true)
     */
    private $prefijo;

    /**
     * @ORM\OneToMany(targetEntity="CarCuentaCobrar", mappedBy="cuentaCobrarTipoRel")
     */
    protected $cuentaCobrarRel;




}
