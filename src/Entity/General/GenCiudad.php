<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\General\GenCiudadRepository")
 */
class GenCiudad
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
     * @ORM\ManyToOne(targetEntity="GenDepartamento", inversedBy="ciudadesRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    protected $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\GenTercero", mappedBy="ciudadRel")
     */
    private $ciudadTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadRel")
     */
    protected $EmpleadosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadExpedicionRel")
     */
    protected $rhuEmpleadosCiudadExpedicionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadNacimientoRel")
     */
    protected $EmpleadosCiudadNacimientoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuContrato", mappedBy="ciudadContratoRel")
     */
    protected $rhuContratosCiudadContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuContrato", mappedBy="ciudadLaboraRel")
     */
    protected $rhuContratosCiudadLaboraRel;

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
    public function getEmpleadosCiudadRel()
    {
        return $this->EmpleadosCiudadRel;
    }

    /**
     * @param mixed $EmpleadosCiudadRel
     */
    public function setEmpleadosCiudadRel($EmpleadosCiudadRel): void
    {
        $this->EmpleadosCiudadRel = $EmpleadosCiudadRel;
    }

    /**
     * @return mixed
     */
    public function getRhuEmpleadosCiudadExpedicionRel()
    {
        return $this->rhuEmpleadosCiudadExpedicionRel;
    }

    /**
     * @param mixed $rhuEmpleadosCiudadExpedicionRel
     */
    public function setRhuEmpleadosCiudadExpedicionRel($rhuEmpleadosCiudadExpedicionRel): void
    {
        $this->rhuEmpleadosCiudadExpedicionRel = $rhuEmpleadosCiudadExpedicionRel;
    }

    /**
     * @return mixed
     */
    public function getEmpleadosCiudadNacimientoRel()
    {
        return $this->EmpleadosCiudadNacimientoRel;
    }

    /**
     * @param mixed $EmpleadosCiudadNacimientoRel
     */
    public function setEmpleadosCiudadNacimientoRel($EmpleadosCiudadNacimientoRel): void
    {
        $this->EmpleadosCiudadNacimientoRel = $EmpleadosCiudadNacimientoRel;
    }

    /**
     * @return mixed
     */
    public function getRhuContratosCiudadContratoRel()
    {
        return $this->rhuContratosCiudadContratoRel;
    }

    /**
     * @param mixed $rhuContratosCiudadContratoRel
     */
    public function setRhuContratosCiudadContratoRel($rhuContratosCiudadContratoRel): void
    {
        $this->rhuContratosCiudadContratoRel = $rhuContratosCiudadContratoRel;
    }

    /**
     * @return mixed
     */
    public function getRhuContratosCiudadLaboraRel()
    {
        return $this->rhuContratosCiudadLaboraRel;
    }

    /**
     * @param mixed $rhuContratosCiudadLaboraRel
     */
    public function setRhuContratosCiudadLaboraRel($rhuContratosCiudadLaboraRel): void
    {
        $this->rhuContratosCiudadLaboraRel = $rhuContratosCiudadLaboraRel;
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



}
