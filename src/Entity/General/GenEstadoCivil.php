<?php


namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenEstadoCivilRepository")
 */
class GenEstadoCivil
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_estado_civil_pk", type="string", length=10, nullable=true)
     */
    private $codigoEstadoCivilPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="estadoCivilRel")
     */
    protected $EmpleadosEstadoCivilRel;


}