<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\General\GenConfiguracionRepository")
 */
class GenConfiguracion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="integer")
     */
    private $codigoConfiguracionPk;

    /**
     * @ORM\Column(name="formato_factura", type="string", length=1, nullable=true)
     */
    private $formatoFactura;
    /**
     * @ORM\Column(name="porcentaje_interes_mora", type="float", options={"default":0} , nullable=true)
     */
    private $porcentajeInteresMora = 0;

    /**
     * @ORM\Column(name="codigo_item_interes_mora", type="integer", nullable=true)
     */
    private $codigoItemInteresMora;

    /**
     * @ORM\Column(name="genera_interes_mora", type="boolean", nullable=true, options={"default" : false})
     */
    private $generaInteresMora = false;


}
