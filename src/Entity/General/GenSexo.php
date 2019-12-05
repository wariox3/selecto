<?php


namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenSexoRepository")
 */
class GenSexo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_sexo_pk", type="string", length=1, nullable=true)
     */
    private $codigoSexoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="sexoRel")
     */
    protected $EmpleadosSexoRel;

    /**
     * @return mixed
     */
    public function getCodigoSexoPk()
    {
        return $this->codigoSexoPk;
    }

    /**
     * @param mixed $codigoSexoPk
     */
    public function setCodigoSexoPk($codigoSexoPk): void
    {
        $this->codigoSexoPk = $codigoSexoPk;
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
    public function getEmpleadosSexoRel()
    {
        return $this->EmpleadosSexoRel;
    }

    /**
     * @param mixed $EmpleadosSexoRel
     */
    public function setEmpleadosSexoRel($EmpleadosSexoRel): void
    {
        $this->EmpleadosSexoRel = $EmpleadosSexoRel;
    }



}