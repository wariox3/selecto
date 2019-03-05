<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Centro
 *
 * @ORM\Table(name="matriz_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\MatrizDetalleRepository")
 */
class MatrizDetalle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoMatrizDetallePk;

    /**
     * @ORM\Column(name="codigo_matriz_fk", type="integer")
     */
    private $codigoMatrizFk;

    /**
     * @ORM\Column(name="codigo_norma_fk", type="integer")
     */
    private $codigoNormaFk;

    /**
     * @ORM\ManyToOne(targetEntity="Matriz", inversedBy="matricesDetallesMatrizRel")
     * @ORM\JoinColumn(name="codigo_matriz_fk", referencedColumnName="codigo_matriz_pk")
     */
    private $matrizRel;

    /**
     * @ORM\ManyToOne(targetEntity="Norma", inversedBy="matricesDetallesNormaRel")
     * @ORM\JoinColumn(name="codigo_norma_fk", referencedColumnName="codigo_norma_pk")
     */
    private $normaRel;

}
