<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table(name="articulo")
 * @ORM\Entity(repositoryClass="App\Repository\ArticuloRepository")
 */
class Articulo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoArticuloPk;

    /**
     * @ORM\Column(name="codigo_norma_fk", type="integer", nullable=true)
     */
    private $codigoNormaFk;

    /**
     * @ORM\Column(name="obligacion", type="text", nullable=true)
     */
    private $obligacion;

    /**
     * @ORM\Column(name="verificable", type="boolean", nullable=true, options={"default" : false})
     */
    private $verificable = false;

    /**
     * @ORM\Column(name="estado_derogado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDerogado = false;

    /**
     * @ORM\Column(name="codigo_accion_fk", type="string", length=30, nullable=true)
     */
    private $codigoAccionFk;

}
