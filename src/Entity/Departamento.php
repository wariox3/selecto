<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartamentoRepository")
 */
class Departamento
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
     * @ORM\Column(name="codigo_dane_mascara", type="string", length=5)
     */
    private $codigoDaneMascara;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pais", inversedBy="departamentosPaisRel")
     * @ORM\JoinColumn(name="codigo_pais_fk", referencedColumnName="codigo_pais_pk")
     */
    protected $paisRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ciudad", mappedBy="departamentoRel")
     */
    protected $ciudadesRel;

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
    public function getCodigoDaneMascara()
    {
        return $this->codigoDaneMascara;
    }

    /**
     * @param mixed $codigoDaneMascara
     */
    public function setCodigoDaneMascara($codigoDaneMascara): void
    {
        $this->codigoDaneMascara = $codigoDaneMascara;
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


}
