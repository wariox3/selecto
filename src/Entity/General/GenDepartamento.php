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

    /**
     * @return mixed
     */
    public function getCodigoDepartamentoPk()
    {
        return $this->codigoDepartamentoPk;
    }

    /**
     * @param mixed $codigoDepartamentoPk
     */
    public function setCodigoDepartamentoPk($codigoDepartamentoPk): void
    {
        $this->codigoDepartamentoPk = $codigoDepartamentoPk;
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
    public function getCodigoPaisFk()
    {
        return $this->codigoPaisFk;
    }

    /**
     * @param mixed $codigoPaisFk
     */
    public function setCodigoPaisFk($codigoPaisFk): void
    {
        $this->codigoPaisFk = $codigoPaisFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoDane()
    {
        return $this->codigoDane;
    }

    /**
     * @param mixed $codigoDane
     */
    public function setCodigoDane($codigoDane): void
    {
        $this->codigoDane = $codigoDane;
    }

    /**
     * @return mixed
     */
    public function getCiudadesRel()
    {
        return $this->ciudadesRel;
    }

    /**
     * @param mixed $ciudadesRel
     */
    public function setCiudadesRel($ciudadesRel): void
    {
        $this->ciudadesRel = $ciudadesRel;
    }

    /**
     * @return mixed
     */
    public function getPaisRel()
    {
        return $this->paisRel;
    }

    /**
     * @param mixed $paisRel
     */
    public function setPaisRel($paisRel): void
    {
        $this->paisRel = $paisRel;
    }



}
