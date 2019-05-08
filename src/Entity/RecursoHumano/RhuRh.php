<?php


namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RH
 *
 * @ORM\Table(name="RhuRh")
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuRhRepository")
 */
class RhuRh
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_rh_pk", type="string", length=10)
     */
    private $codigoRhPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="rhRel")
     */
    protected $empleadosRhRel;

    /**
     * @return mixed
     */
    public function getCodigoRhPk()
    {
        return $this->codigoRhPk;
    }

    /**
     * @param mixed $codigoRhPk
     */
    public function setCodigoRhPk($codigoRhPk): void
    {
        $this->codigoRhPk = $codigoRhPk;
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
    public function getEmpleadosRhRel()
    {
        return $this->empleadosRhRel;
    }

    /**
     * @param mixed $empleadosRhRel
     */
    public function setEmpleadosRhRel($empleadosRhRel): void
    {
        $this->empleadosRhRel = $empleadosRhRel;
    }


}