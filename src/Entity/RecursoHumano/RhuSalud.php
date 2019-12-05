<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuSalud
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuSaludRepository")
 */
class RhuSalud
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_salud_pk", type="string", length=10)
     */
    private $codigoSaludPk;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */    
    private $nombre;      

    /**
     * @ORM\Column(name="porcentaje_empleado", type="float")
     */    
    private $porcentajeEmpleado = 0;

    /**
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden = 0;
    
    /**
     * @ORM\Column(name="porcentaje_empleador", type="float")
     */    
    private $porcentajeEmpleador = 0;

    /**
     * @ORM\Column(name="codigo_concepto_fk", type="string", length=10, nullable=true)
     */
    private $codigoConceptoFk;

    /**
     * @ORM\ManyToOne(targetEntity="RhuConcepto", inversedBy="saludesConceptoRel")
     * @ORM\JoinColumn(name="codigo_concepto_fk", referencedColumnName="codigo_concepto_pk")
     */
    protected $conceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="saludRel")
     */
    protected $contratosSaludRel;

    /**
     * @return mixed
     */
    public function getCodigoSaludPk()
    {
        return $this->codigoSaludPk;
    }

    /**
     * @param mixed $codigoSaludPk
     */
    public function setCodigoSaludPk($codigoSaludPk): void
    {
        $this->codigoSaludPk = $codigoSaludPk;
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
     * @return int
     */
    public function getPorcentajeEmpleado(): int
    {
        return $this->porcentajeEmpleado;
    }

    /**
     * @param int $porcentajeEmpleado
     */
    public function setPorcentajeEmpleado(int $porcentajeEmpleado): void
    {
        $this->porcentajeEmpleado = $porcentajeEmpleado;
    }

    /**
     * @return int
     */
    public function getOrden(): int
    {
        return $this->orden;
    }

    /**
     * @param int $orden
     */
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }

    /**
     * @return int
     */
    public function getPorcentajeEmpleador(): int
    {
        return $this->porcentajeEmpleador;
    }

    /**
     * @param int $porcentajeEmpleador
     */
    public function setPorcentajeEmpleador(int $porcentajeEmpleador): void
    {
        $this->porcentajeEmpleador = $porcentajeEmpleador;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoFk()
    {
        return $this->codigoConceptoFk;
    }

    /**
     * @param mixed $codigoConceptoFk
     */
    public function setCodigoConceptoFk($codigoConceptoFk): void
    {
        $this->codigoConceptoFk = $codigoConceptoFk;
    }

    /**
     * @return mixed
     */
    public function getConceptoRel()
    {
        return $this->conceptoRel;
    }

    /**
     * @param mixed $conceptoRel
     */
    public function setConceptoRel($conceptoRel): void
    {
        $this->conceptoRel = $conceptoRel;
    }

    /**
     * @return mixed
     */
    public function getContratosSaludRel()
    {
        return $this->contratosSaludRel;
    }

    /**
     * @param mixed $contratosSaludRel
     */
    public function setContratosSaludRel($contratosSaludRel): void
    {
        $this->contratosSaludRel = $contratosSaludRel;
    }

}
