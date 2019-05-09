<?php


namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * class RhuCargo
 * @ORM\Table(name="RhuCargo")
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuCargoRepository")
 */
class RhuCargo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cargo_pk", type="string", length=10)
     */
    private $codigoCargoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="RhuEmpleado", mappedBy="cargoRel")
     */
    protected $empleadosCargoRel;

    /**
     * @return mixed
     */
    public function getCodigoCargoPk()
    {
        return $this->codigoCargoPk;
    }

    /**
     * @param mixed $codigoCargoPk
     */
    public function setCodigoCargoPk($codigoCargoPk): void
    {
        $this->codigoCargoPk = $codigoCargoPk;
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
    public function getEmpleadosCargoRel()
    {
        return $this->empleadosCargoRel;
    }

    /**
     * @param mixed $empleadosCargoRel
     */
    public function setEmpleadosCargoRel($empleadosCargoRel): void
    {
        $this->empleadosCargoRel = $empleadosCargoRel;
    }

}