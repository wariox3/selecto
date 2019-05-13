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

    /**
     * @return mixed
     */
    public function getCodigoEstadoCivilPk()
    {
        return $this->codigoEstadoCivilPk;
    }

    /**
     * @param mixed $codigoEstadoCivilPk
     */
    public function setCodigoEstadoCivilPk($codigoEstadoCivilPk): void
    {
        $this->codigoEstadoCivilPk = $codigoEstadoCivilPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getEmpleadosEstadoCivilRel()
    {
        return $this->EmpleadosEstadoCivilRel;
    }

    /**
     * @param mixed $EmpleadosEstadoCivilRel
     */
    public function setEmpleadosEstadoCivilRel($EmpleadosEstadoCivilRel): void
    {
        $this->EmpleadosEstadoCivilRel = $EmpleadosEstadoCivilRel;
    }


}