<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\CiudadRepository")
 */
class Ciudad
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCiudadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_departamento_fk", type="integer")
     */
    private $codigoDepartamentoFk;

    /**
     * @ORM\Column(name="codigo_dane", type="string", length=5)
     */
    private $codigoDane;

    /**
     * @ORM\Column(name="codigo_dane_mascara", type="string", length=5, nullable=true)
     */
    private $codigoDaneMascara;

    /**
     * @ORM\Column(name="codigo_dane_completo", type="string", length=10, nullable=true)
     */
    private $codigoDaneCompleto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="ciudadesRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    protected $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tercero", mappedBy="ciudadRel")
     */
    private $ciudadTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Empresa", mappedBy="ciudadRel")
     */
    protected $empresasCiudadRel;

    /**
     * @return mixed
     */
    public function getCodigoCiudadPk()
    {
        return $this->codigoCiudadPk;
    }

    /**
     * @param mixed $codigoCiudadPk
     */
    public function setCodigoCiudadPk($codigoCiudadPk): void
    {
        $this->codigoCiudadPk = $codigoCiudadPk;
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
    public function getCodigoDepartamentoFk()
    {
        return $this->codigoDepartamentoFk;
    }

    /**
     * @param mixed $codigoDepartamentoFk
     */
    public function setCodigoDepartamentoFk($codigoDepartamentoFk): void
    {
        $this->codigoDepartamentoFk = $codigoDepartamentoFk;
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
    public function getCodigoDaneCompleto()
    {
        return $this->codigoDaneCompleto;
    }

    /**
     * @param mixed $codigoDaneCompleto
     */
    public function setCodigoDaneCompleto($codigoDaneCompleto): void
    {
        $this->codigoDaneCompleto = $codigoDaneCompleto;
    }

    /**
     * @return mixed
     */
    public function getDepartamentoRel()
    {
        return $this->departamentoRel;
    }

    /**
     * @param mixed $departamentoRel
     */
    public function setDepartamentoRel($departamentoRel): void
    {
        $this->departamentoRel = $departamentoRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadTerceroRel()
    {
        return $this->ciudadTerceroRel;
    }

    /**
     * @param mixed $ciudadTerceroRel
     */
    public function setCiudadTerceroRel($ciudadTerceroRel): void
    {
        $this->ciudadTerceroRel = $ciudadTerceroRel;
    }

    /**
     * @return mixed
     */
    public function getEmpresasCiudadRel()
    {
        return $this->empresasCiudadRel;
    }

    /**
     * @param mixed $empresasCiudadRel
     */
    public function setEmpresasCiudadRel($empresasCiudadRel): void
    {
        $this->empresasCiudadRel = $empresasCiudadRel;
    }



}
