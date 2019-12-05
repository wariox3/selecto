<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;


/**
 *  RhuEntidad
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuEntidadRepository")
 */
class RhuEntidad
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_entidad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEntidadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=120, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="nit", type="string", length=80, nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="eps", type="boolean", nullable=true,options={"default":false})
     */
    private $eps = false;

    /**
     * @ORM\Column(name="arl", type="boolean", nullable=true,options={"default":false})
     */
    private $arl = false;

    /**
     * @ORM\Column(name="ccf", type="boolean", nullable=true,options={"default":false})
     */
    private $ccf = false;

    /**
     * @ORM\Column(name="ces", type="boolean", nullable=true,options={"default":false})
     */
    private $ces = false;

    /**
     * @ORM\Column(name="pen", type="boolean", nullable=true,options={"default":false})
     */
    private $pen = false;

    /**
     * @ORM\Column(name="codigo_interface", type="string", length=20, nullable=true)
     */
    private $codigoInterface;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="entidadSaludRel")
     */
    protected $contratosEntidadSaludRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="entidadPensionRel")
     */
    protected $contratosEntidadPensionRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="entidadCesantiaRel")
     */
    protected $contratosEntidadCesantiaRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="entidadCajaRel")
     */
    protected $contratosEntidadCajaRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuNovedad", mappedBy="entidadRel")
     */
    protected $novedadesEntidadRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPago", mappedBy="entidadSaludRel")
     */
    protected $pagosEntidadSaludRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPago", mappedBy="entidadPensionRel")
     */
    protected $pagosEntidadPensionRel;

    /**
     * @return mixed
     */
    public function getCodigoEntidadPk()
    {
        return $this->codigoEntidadPk;
    }

    /**
     * @param mixed $codigoEntidadPk
     */
    public function setCodigoEntidadPk($codigoEntidadPk): void
    {
        $this->codigoEntidadPk = $codigoEntidadPk;
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
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
    }

    /**
     * @return bool
     */
    public function isEps(): bool
    {
        return $this->eps;
    }

    /**
     * @param bool $eps
     */
    public function setEps(bool $eps): void
    {
        $this->eps = $eps;
    }

    /**
     * @return bool
     */
    public function isArl(): bool
    {
        return $this->arl;
    }

    /**
     * @param bool $arl
     */
    public function setArl(bool $arl): void
    {
        $this->arl = $arl;
    }

    /**
     * @return bool
     */
    public function isCcf(): bool
    {
        return $this->ccf;
    }

    /**
     * @param bool $ccf
     */
    public function setCcf(bool $ccf): void
    {
        $this->ccf = $ccf;
    }

    /**
     * @return bool
     */
    public function isCes(): bool
    {
        return $this->ces;
    }

    /**
     * @param bool $ces
     */
    public function setCes(bool $ces): void
    {
        $this->ces = $ces;
    }

    /**
     * @return bool
     */
    public function isPen(): bool
    {
        return $this->pen;
    }

    /**
     * @param bool $pen
     */
    public function setPen(bool $pen): void
    {
        $this->pen = $pen;
    }

    /**
     * @return mixed
     */
    public function getCodigoInterface()
    {
        return $this->codigoInterface;
    }

    /**
     * @param mixed $codigoInterface
     */
    public function setCodigoInterface($codigoInterface): void
    {
        $this->codigoInterface = $codigoInterface;
    }

    /**
     * @return mixed
     */
    public function getContratosEntidadSaludRel()
    {
        return $this->contratosEntidadSaludRel;
    }

    /**
     * @param mixed $contratosEntidadSaludRel
     */
    public function setContratosEntidadSaludRel($contratosEntidadSaludRel): void
    {
        $this->contratosEntidadSaludRel = $contratosEntidadSaludRel;
    }

    /**
     * @return mixed
     */
    public function getContratosEntidadPensionRel()
    {
        return $this->contratosEntidadPensionRel;
    }

    /**
     * @param mixed $contratosEntidadPensionRel
     */
    public function setContratosEntidadPensionRel($contratosEntidadPensionRel): void
    {
        $this->contratosEntidadPensionRel = $contratosEntidadPensionRel;
    }

    /**
     * @return mixed
     */
    public function getContratosEntidadCesantiaRel()
    {
        return $this->contratosEntidadCesantiaRel;
    }

    /**
     * @param mixed $contratosEntidadCesantiaRel
     */
    public function setContratosEntidadCesantiaRel($contratosEntidadCesantiaRel): void
    {
        $this->contratosEntidadCesantiaRel = $contratosEntidadCesantiaRel;
    }

    /**
     * @return mixed
     */
    public function getContratosEntidadCajaRel()
    {
        return $this->contratosEntidadCajaRel;
    }

    /**
     * @param mixed $contratosEntidadCajaRel
     */
    public function setContratosEntidadCajaRel($contratosEntidadCajaRel): void
    {
        $this->contratosEntidadCajaRel = $contratosEntidadCajaRel;
    }

    /**
     * @return mixed
     */
    public function getNovedadesEntidadRel()
    {
        return $this->novedadesEntidadRel;
    }

    /**
     * @param mixed $novedadesEntidadRel
     */
    public function setNovedadesEntidadRel($novedadesEntidadRel): void
    {
        $this->novedadesEntidadRel = $novedadesEntidadRel;
    }

    /**
     * @return mixed
     */
    public function getPagosEntidadSaludRel()
    {
        return $this->pagosEntidadSaludRel;
    }

    /**
     * @param mixed $pagosEntidadSaludRel
     */
    public function setPagosEntidadSaludRel($pagosEntidadSaludRel): void
    {
        $this->pagosEntidadSaludRel = $pagosEntidadSaludRel;
    }

    /**
     * @return mixed
     */
    public function getPagosEntidadPensionRel()
    {
        return $this->pagosEntidadPensionRel;
    }

    /**
     * @param mixed $pagosEntidadPensionRel
     */
    public function setPagosEntidadPensionRel($pagosEntidadPensionRel): void
    {
        $this->pagosEntidadPensionRel = $pagosEntidadPensionRel;
    }

}
