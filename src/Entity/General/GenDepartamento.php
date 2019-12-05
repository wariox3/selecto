<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenDepartamentoRepository")
 */
class GenDepartamento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_departamento_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDepartamentoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_pais_fk", type="integer")
     */
    private $codigoPaisFk;

    /**
     * @ORM\Column(name="codigo_dane", type="string", length=5)
     */
    private $codigoDane;

    /**
     * @ORM\OneToMany(targetEntity="GenCiudad", mappedBy="departamentoRel")
     */
    protected $ciudadesRel;

    /**
     * @ORM\ManyToOne(targetEntity="GenPais", inversedBy="departamentosPaisRel")
     * @ORM\JoinColumn(name="codigo_pais_fk", referencedColumnName="codigo_pais_pk")
     */
    protected $paisRel;

}
