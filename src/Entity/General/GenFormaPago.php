<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenFormaPagoRepository")
 */
class GenFormaPago
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_forma_pago_pk", type="string", length=3)
     */
    private $codigoFormaPagoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\GenTercero", mappedBy="formaPagoRel")
     */
    private $tercerosFormaPagoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvMovimiento", mappedBy="formaPagoRel")
     */
    private $movimientosFormaPagoRel;


}
