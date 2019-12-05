<?php

namespace App\Entity\RecursoHumano;

use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\ORM\Mapping as ORM;

/**
 *  RhuConcepto
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuConceptoRepository")
 */
class RhuConcepto
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_concepto_pk", type="string", length=10)
     */
    private $codigoConceptoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=80, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="porcentaje", type="float", options={"default":0} , nullable=true)
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="genera_ingreso_base_prestacion" ,options={"default":false} ,type="boolean", nullable=true)
     */
    private $generaIngresoBasePrestacion = false;

    /**
     * @ORM\Column(name="genera_ingreso_base_cotizacion",options={"default":false} , type="boolean", nullable=true)
     */
    private $generaIngresoBaseCotizacion = false;

    /**
     * @ORM\Column(name="operacion", type="integer",options={"default":0} , nullable=true)
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="adicional",options={"default":false} , type="boolean", nullable=true)
     */
    private $adicional = false;

    /**
     * BON=Bonificacion, DES=Descuento, COM=Comision
     * @ORM\Column(name="adicional_tipo", type="string", length=3, nullable=true)
     */
    private $adicionalTipo;

    /**
     * @ORM\Column(name="auxilio_transporte",options={"default":false} , type="boolean", nullable=true)
     */
    private $auxilioTransporte = false;

    /**
     * @ORM\Column(name="incapacidad",options={"default":false} , type="boolean", nullable=true)
     */
    private $incapacidad = false;

    /**
     * @ORM\Column(name="incapacidad_entidad",options={"default":false} , type="boolean", nullable=true)
     */
    private $incapacidadEntidad = false;

    /**
     * @ORM\Column(name="pension",options={"default":false} , type="boolean", nullable=true)
     */
    private $pension = false;

    /**
     * @ORM\Column(name="salud",options={"default":false} , type="boolean", nullable=true)
     */
    private $salud = false;

    /**
     * @ORM\Column(name="vacacion",options={"default":false} , type="boolean", nullable=true)
     */
    private $vacacion = false;

    /**
     * @ORM\Column(name="comision",options={"default":false} , type="boolean", nullable=true)
     */
    private $comision = false;

    /**
     * @ORM\Column(name="cesantia",options={"default":false} , type="boolean", nullable=true)
     */
    private $cesantia = false;

    /**
     * @ORM\Column(name="numero_dian", type="integer", nullable=true)
     */
    private $numeroDian;

    /**
     * @ORM\Column(name="recargo_nocturno",options={"default":false} ,type="boolean", nullable=true)
     */
    private $recargoNocturno = false;

    /**
     * @ORM\Column(name="fondo_solidaridad_pensional",options={"default":false} , type="boolean", nullable=true)
     */
    private $fondoSolidaridadPensional = false;

    /**
     * @ORM\OneToMany(targetEntity="RhuNovedadTipo", mappedBy="conceptoRel")
     */
    protected $novedadesConceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuCreditoTipo", mappedBy="conceptoRel")
     */
    protected $creditosTiposConceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPagoDetalle", mappedBy="conceptoRel")
     */
    protected $pagosDetallesConceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuSalud", mappedBy="conceptoRel")
     */
    protected $saludesConceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuAdicional", mappedBy="conceptoRel")
     */
    protected $adicionalesConceptoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuConceptoHora", mappedBy="conceptoRel")
     */
    protected $conceptosHorasConceptoRel;

    /**
     * @return mixed
     */
    public function getCodigoConceptoPk()
    {
        return $this->codigoConceptoPk;
    }

    /**
     * @param mixed $codigoConceptoPk
     */
    public function setCodigoConceptoPk($codigoConceptoPk): void
    {
        $this->codigoConceptoPk = $codigoConceptoPk;
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
    public function getPorcentaje(): int
    {
        return $this->porcentaje;
    }

    /**
     * @param int $porcentaje
     */
    public function setPorcentaje(int $porcentaje): void
    {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return bool
     */
    public function isGeneraIngresoBasePrestacion(): bool
    {
        return $this->generaIngresoBasePrestacion;
    }

    /**
     * @param bool $generaIngresoBasePrestacion
     */
    public function setGeneraIngresoBasePrestacion(bool $generaIngresoBasePrestacion): void
    {
        $this->generaIngresoBasePrestacion = $generaIngresoBasePrestacion;
    }

    /**
     * @return bool
     */
    public function isGeneraIngresoBaseCotizacion(): bool
    {
        return $this->generaIngresoBaseCotizacion;
    }

    /**
     * @param bool $generaIngresoBaseCotizacion
     */
    public function setGeneraIngresoBaseCotizacion(bool $generaIngresoBaseCotizacion): void
    {
        $this->generaIngresoBaseCotizacion = $generaIngresoBaseCotizacion;
    }

    /**
     * @return int
     */
    public function getOperacion(): int
    {
        return $this->operacion;
    }

    /**
     * @param int $operacion
     */
    public function setOperacion(int $operacion): void
    {
        $this->operacion = $operacion;
    }

    /**
     * @return bool
     */
    public function isAdicional(): bool
    {
        return $this->adicional;
    }

    /**
     * @param bool $adicional
     */
    public function setAdicional(bool $adicional): void
    {
        $this->adicional = $adicional;
    }

    /**
     * @return mixed
     */
    public function getAdicionalTipo()
    {
        return $this->adicionalTipo;
    }

    /**
     * @param mixed $adicionalTipo
     */
    public function setAdicionalTipo($adicionalTipo): void
    {
        $this->adicionalTipo = $adicionalTipo;
    }

    /**
     * @return bool
     */
    public function isAuxilioTransporte(): bool
    {
        return $this->auxilioTransporte;
    }

    /**
     * @param bool $auxilioTransporte
     */
    public function setAuxilioTransporte(bool $auxilioTransporte): void
    {
        $this->auxilioTransporte = $auxilioTransporte;
    }

    /**
     * @return bool
     */
    public function isIncapacidad(): bool
    {
        return $this->incapacidad;
    }

    /**
     * @param bool $incapacidad
     */
    public function setIncapacidad(bool $incapacidad): void
    {
        $this->incapacidad = $incapacidad;
    }

    /**
     * @return bool
     */
    public function isIncapacidadEntidad(): bool
    {
        return $this->incapacidadEntidad;
    }

    /**
     * @param bool $incapacidadEntidad
     */
    public function setIncapacidadEntidad(bool $incapacidadEntidad): void
    {
        $this->incapacidadEntidad = $incapacidadEntidad;
    }

    /**
     * @return bool
     */
    public function isPension(): bool
    {
        return $this->pension;
    }

    /**
     * @param bool $pension
     */
    public function setPension(bool $pension): void
    {
        $this->pension = $pension;
    }

    /**
     * @return bool
     */
    public function isSalud(): bool
    {
        return $this->salud;
    }

    /**
     * @param bool $salud
     */
    public function setSalud(bool $salud): void
    {
        $this->salud = $salud;
    }

    /**
     * @return bool
     */
    public function isVacacion(): bool
    {
        return $this->vacacion;
    }

    /**
     * @param bool $vacacion
     */
    public function setVacacion(bool $vacacion): void
    {
        $this->vacacion = $vacacion;
    }

    /**
     * @return bool
     */
    public function isComision(): bool
    {
        return $this->comision;
    }

    /**
     * @param bool $comision
     */
    public function setComision(bool $comision): void
    {
        $this->comision = $comision;
    }

    /**
     * @return bool
     */
    public function isCesantia(): bool
    {
        return $this->cesantia;
    }

    /**
     * @param bool $cesantia
     */
    public function setCesantia(bool $cesantia): void
    {
        $this->cesantia = $cesantia;
    }

    /**
     * @return mixed
     */
    public function getNumeroDian()
    {
        return $this->numeroDian;
    }

    /**
     * @param mixed $numeroDian
     */
    public function setNumeroDian($numeroDian): void
    {
        $this->numeroDian = $numeroDian;
    }

    /**
     * @return bool
     */
    public function isRecargoNocturno(): bool
    {
        return $this->recargoNocturno;
    }

    /**
     * @param bool $recargoNocturno
     */
    public function setRecargoNocturno(bool $recargoNocturno): void
    {
        $this->recargoNocturno = $recargoNocturno;
    }

    /**
     * @return bool
     */
    public function isFondoSolidaridadPensional(): bool
    {
        return $this->fondoSolidaridadPensional;
    }

    /**
     * @param bool $fondoSolidaridadPensional
     */
    public function setFondoSolidaridadPensional(bool $fondoSolidaridadPensional): void
    {
        $this->fondoSolidaridadPensional = $fondoSolidaridadPensional;
    }

    /**
     * @return mixed
     */
    public function getNovedadesConceptoRel()
    {
        return $this->novedadesConceptoRel;
    }

    /**
     * @param mixed $novedadesConceptoRel
     */
    public function setNovedadesConceptoRel($novedadesConceptoRel): void
    {
        $this->novedadesConceptoRel = $novedadesConceptoRel;
    }

    /**
     * @return mixed
     */
    public function getCreditosTiposConceptoRel()
    {
        return $this->creditosTiposConceptoRel;
    }

    /**
     * @param mixed $creditosTiposConceptoRel
     */
    public function setCreditosTiposConceptoRel($creditosTiposConceptoRel): void
    {
        $this->creditosTiposConceptoRel = $creditosTiposConceptoRel;
    }

    /**
     * @return mixed
     */
    public function getPagosDetallesConceptoRel()
    {
        return $this->pagosDetallesConceptoRel;
    }

    /**
     * @param mixed $pagosDetallesConceptoRel
     */
    public function setPagosDetallesConceptoRel($pagosDetallesConceptoRel): void
    {
        $this->pagosDetallesConceptoRel = $pagosDetallesConceptoRel;
    }

    /**
     * @return mixed
     */
    public function getSaludesConceptoRel()
    {
        return $this->saludesConceptoRel;
    }

    /**
     * @param mixed $saludesConceptoRel
     */
    public function setSaludesConceptoRel($saludesConceptoRel): void
    {
        $this->saludesConceptoRel = $saludesConceptoRel;
    }

    /**
     * @return mixed
     */
    public function getAdicionalesConceptoRel()
    {
        return $this->adicionalesConceptoRel;
    }

    /**
     * @param mixed $adicionalesConceptoRel
     */
    public function setAdicionalesConceptoRel($adicionalesConceptoRel): void
    {
        $this->adicionalesConceptoRel = $adicionalesConceptoRel;
    }

    /**
     * @return mixed
     */
    public function getConceptosHorasConceptoRel()
    {
        return $this->conceptosHorasConceptoRel;
    }

    /**
     * @param mixed $conceptosHorasConceptoRel
     */
    public function setConceptosHorasConceptoRel($conceptosHorasConceptoRel): void
    {
        $this->conceptosHorasConceptoRel = $conceptosHorasConceptoRel;
    }



}