<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenImpuestoTipoRepository")
 */
class GenImpuestoTipo
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_impuesto_tipo_pk", type="string", length=3, nullable=false)
     */
    private $codigoImpuestoTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=10)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\GenImpuesto", mappedBy="impuestoTipoRel")
     */
    private $impuestosImpuestoTipoRel;

}
