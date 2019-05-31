<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 *  RhuContrato
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuContratoRepository")
 */
class RhuContrato
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoContratoPk;

    /**
     * @ORM\Column(name="codigo_contrato_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoContratoTipoFk;

    /**
     * @ORM\Column(name="codigo_contrato_clase_fk", type="string", length=10, nullable=true)
     */
    private $codigoContratoClaseFk;

    /**
     * @ORM\Column(name="codigo_clasificacion_riesgo_fk", type="string", length=10, nullable=true)
     */
    private $codigoClasificacionRiesgoFk;

    /**
     * @ORM\Column(name="factor_horas_dia", options={"default" : 0 }, type="integer", nullable=true)
     */
    private $factorHorasDia = 0;

    /**
     * @ORM\Column(name="codigo_empleado_fk", type="integer")
     */
    private $codigoEmpleadoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="tipo_salario", type="string", length=30, nullable=true)
     */
    private $tipoSalario;

    /**
     * @ORM\Column(name="tiempo", type="string", length=30, nullable=true)
     */
    private $tiempo;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="numero", type="string", length=30, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(name="codigo_cargo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCargoFk;

    /**
     * @ORM\Column(name="cargo_descripcion", type="string", length=60, nullable=true)
     */
    private $cargoDescripcion;

    /**
     * @ORM\Column(name="vr_salario", options={"default":0},type="float", nullable=true)
     */
    private $vrSalario = 0;

    /**
     * @ORM\Column(name="vr_adicional", options={"default":0},type="float", nullable=true)
     */
    private $vrAdicional = 0;

    /**
     * @ORM\Column(name="vr_adicional_prestacional", options={"default":0},type="float", nullable=true)
     */
    private $vrAdicionalPrestacional = 0;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean",options={"default":false})
     */
    private $estadoTerminado = false;

    /**
     * @ORM\Column(name="comentario_terminacion", type="string", length=2000, nullable=true)
     */
    private $comentarioTerminacion;

    /**
     * @ORM\Column(name="comentario_contrato", type="string", length=2000, nullable=true)
     */
    private $comentarioContrato;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_cesantias", type="date", nullable=true)
     */
    private $fechaUltimoPagoCesantias;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_vacaciones", type="date", nullable=true)
     */
    private $fechaUltimoPagoVacaciones;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_primas", type="date", nullable=true)
     */
    private $fechaUltimoPagoPrimas;

    /**
     * @ORM\Column(name="fecha_ultimo_pago", type="date", nullable=true)
     */
    private $fechaUltimoPago;

    /**
     * @ORM\Column(name="codigo_subtipo_cotizante_fk", type="string", length=10, nullable=true)
     */
    private $codigoSubtipoCotizanteFk;

    /**
     * @ORM\Column(name="salario_integral", type="boolean",options={"default":false})
     */
    private $salarioIntegral = false;

    /**
     * @ORM\Column(name="codigo_entidad_salud_fk", type="integer", nullable=true)
     */
    private $codigoEntidadSaludFk;

    /**
     * @ORM\Column(name="codigo_entidad_censantia_fk", type="integer", nullable=true)
     */
    private $codigoEntidadCesantiaFk;

    /**
     * @ORM\Column(name="codigo_entidad_caja_fk", type="integer", nullable=true)
     */
    private $codigoEntidadCajaFk;

    /**
     * @ORM\Column(name="codigo_ciudad_contrato_fk", type="integer", nullable=true)
     */
    private $codigoCiudadContratoFk;

    /**
     * @ORM\Column(name="codigo_ciudad_labora_fk", type="integer", nullable=true)
     */
    private $codigoCiudadLaboraFk;

    /**
     * @ORM\Column(name="codigo_sucursal_fk", type="string", length=30, nullable=true)
     */
    private $codigoSucursalFk;

    /**
     * @ORM\Column(name="auxilio_transporte", type="boolean",options={"default":false})
     */
    private $auxilioTransporte = false;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=10, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="codigo_entidad_pension_fk", type="integer", nullable=true)
     */
    private $codigoEntidadPensionFk;

    /**
     * @ORM\Column(name="codigo_pension_fk", type="string", length=10, nullable=true)
     */
    private $codigoPensionFk;

    /**
     * @ORM\Column(name="indefinido",options={"default": false}, type="boolean")
     */
    private $indefinido = false;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="contratosEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk",referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuTiempo", inversedBy="contratosTiempoRel")
     * @ORM\JoinColumn(name="codigo_tiempo_fk",referencedColumnName="codigo_tiempo_pk")
     */
    protected $tiempoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContratoClase", inversedBy="contratosContratoClaseRel")
     * @ORM\JoinColumn(name="codigo_contrato_clase_fk",referencedColumnName="codigo_contrato_clase_pk")
     */
    protected $contratoClaseRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContratoTipo", inversedBy="contratosContratoTipoRel")
     * @ORM\JoinColumn(name="codigo_contrato_tipo_fk",referencedColumnName="codigo_contrato_tipo_pk")
     */
    protected $contratoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuClasificacionRiesgo", inversedBy="contratosClasificacionRiesgoRel")
     * @ORM\JoinColumn(name="codigo_clasificacion_riesgo_fk",referencedColumnName="codigo_clasificacion_riesgo_pk")
     */
    protected $clasificacionRiesgoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuSalud", inversedBy="contratosSaludRel")
     * @ORM\JoinColumn(name="codigo_salud_fk",referencedColumnName="codigo_salud_pk")
     */
    protected $saludRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCargo", inversedBy="contratosCargoRel")
     * @ORM\JoinColumn(name="codigo_cargo_fk",referencedColumnName="codigo_cargo_pk")
     */
    protected $cargoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuGrupo", inversedBy="contratosGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk",referencedColumnName="codigo_grupo_pk")
     */
    protected $grupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadCesantiaRel")
     * @ORM\JoinColumn(name="codigo_entidad_censantia_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadCesantiaRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadCajaRel")
     * @ORM\JoinColumn(name="codigo_entidad_caja_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadCajaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="rhuContratosCiudadContratoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_contrato_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadContratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadSaludRel")
     * @ORM\JoinColumn(name="codigo_entidad_salud_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadSaludRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadPensionRel")
     * @ORM\JoinColumn(name="codigo_entidad_pension_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadPensionRel;


    /**
     * @ORM\ManyToOne(targetEntity="RhuPension", inversedBy="contratosPensionRel")
     * @ORM\JoinColumn(name="codigo_pension_fk",referencedColumnName="codigo_pension_pk")
     */
    protected $pensionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="rhuContratosCiudadLaboraRel")
     * @ORM\JoinColumn(name="codigo_ciudad_labora_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadLaboraRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuSucursal", inversedBy="contratosSucursalRel")
     * @ORM\JoinColumn(name="codigo_sucursal_fk",referencedColumnName="codigo_sucursal_pk")
     */
    protected $sucursalRel;
    /**
     * @ORM\OneToMany(targetEntity="RhuProgramacionDetalle", mappedBy="contratoRel")
     */
    protected $programacionesDetallesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuNovedad", mappedBy="contratoRel")
     */
    protected $novedadesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuCredito", mappedBy="contratoRel")
     */
    protected $creditosContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuVacacion", mappedBy="contratoRel")
     */
    protected $vacacionesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPago", mappedBy="contratoRel")
     */
    protected $pagosContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuAdicional", mappedBy="contratoRel")
     */
    protected $adicionalesContratoRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoPk()
    {
        return $this->codigoContratoPk;
    }

    /**
     * @param mixed $codigoContratoPk
     */
    public function setCodigoContratoPk($codigoContratoPk): void
    {
        $this->codigoContratoPk = $codigoContratoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoContratoTipoFk()
    {
        return $this->codigoContratoTipoFk;
    }

    /**
     * @param mixed $codigoContratoTipoFk
     */
    public function setCodigoContratoTipoFk($codigoContratoTipoFk): void
    {
        $this->codigoContratoTipoFk = $codigoContratoTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoContratoClaseFk()
    {
        return $this->codigoContratoClaseFk;
    }

    /**
     * @param mixed $codigoContratoClaseFk
     */
    public function setCodigoContratoClaseFk($codigoContratoClaseFk): void
    {
        $this->codigoContratoClaseFk = $codigoContratoClaseFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoClasificacionRiesgoFk()
    {
        return $this->codigoClasificacionRiesgoFk;
    }

    /**
     * @param mixed $codigoClasificacionRiesgoFk
     */
    public function setCodigoClasificacionRiesgoFk($codigoClasificacionRiesgoFk): void
    {
        $this->codigoClasificacionRiesgoFk = $codigoClasificacionRiesgoFk;
    }

    /**
     * @return mixed
     */
    public function getFactorHorasDia()
    {
        return $this->factorHorasDia;
    }

    /**
     * @param mixed $factorHorasDia
     */
    public function setFactorHorasDia($factorHorasDia): void
    {
        $this->factorHorasDia = $factorHorasDia;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpleadoFk()
    {
        return $this->codigoEmpleadoFk;
    }

    /**
     * @param mixed $codigoEmpleadoFk
     */
    public function setCodigoEmpleadoFk($codigoEmpleadoFk): void
    {
        $this->codigoEmpleadoFk = $codigoEmpleadoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return mixed
     */
    public function getTipoSalario()
    {
        return $this->tipoSalario;
    }

    /**
     * @param mixed $tipoSalario
     */
    public function setTipoSalario($tipoSalario): void
    {
        $this->tipoSalario = $tipoSalario;
    }

    /**
     * @return mixed
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * @param mixed $tiempo
     */
    public function setTiempo($tiempo): void
    {
        $this->tiempo = $tiempo;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde): void
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getCodigoCargoFk()
    {
        return $this->codigoCargoFk;
    }

    /**
     * @param mixed $codigoCargoFk
     */
    public function setCodigoCargoFk($codigoCargoFk): void
    {
        $this->codigoCargoFk = $codigoCargoFk;
    }

    /**
     * @return mixed
     */
    public function getCargoDescripcion()
    {
        return $this->cargoDescripcion;
    }

    /**
     * @param mixed $cargoDescripcion
     */
    public function setCargoDescripcion($cargoDescripcion): void
    {
        $this->cargoDescripcion = $cargoDescripcion;
    }

    /**
     * @return mixed
     */
    public function getVrSalario()
    {
        return $this->vrSalario;
    }

    /**
     * @param mixed $vrSalario
     */
    public function setVrSalario($vrSalario): void
    {
        $this->vrSalario = $vrSalario;
    }

    /**
     * @return mixed
     */
    public function getVrAdicional()
    {
        return $this->vrAdicional;
    }

    /**
     * @param mixed $vrAdicional
     */
    public function setVrAdicional($vrAdicional): void
    {
        $this->vrAdicional = $vrAdicional;
    }

    /**
     * @return mixed
     */
    public function getVrAdicionalPrestacional()
    {
        return $this->vrAdicionalPrestacional;
    }

    /**
     * @param mixed $vrAdicionalPrestacional
     */
    public function setVrAdicionalPrestacional($vrAdicionalPrestacional): void
    {
        $this->vrAdicionalPrestacional = $vrAdicionalPrestacional;
    }

    /**
     * @return mixed
     */
    public function getEstadoTerminado()
    {
        return $this->estadoTerminado;
    }

    /**
     * @param mixed $estadoTerminado
     */
    public function setEstadoTerminado($estadoTerminado): void
    {
        $this->estadoTerminado = $estadoTerminado;
    }

    /**
     * @return mixed
     */
    public function getComentarioTerminacion()
    {
        return $this->comentarioTerminacion;
    }

    /**
     * @param mixed $comentarioTerminacion
     */
    public function setComentarioTerminacion($comentarioTerminacion): void
    {
        $this->comentarioTerminacion = $comentarioTerminacion;
    }

    /**
     * @return mixed
     */
    public function getComentarioContrato()
    {
        return $this->comentarioContrato;
    }

    /**
     * @param mixed $comentarioContrato
     */
    public function setComentarioContrato($comentarioContrato): void
    {
        $this->comentarioContrato = $comentarioContrato;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPagoCesantias()
    {
        return $this->fechaUltimoPagoCesantias;
    }

    /**
     * @param mixed $fechaUltimoPagoCesantias
     */
    public function setFechaUltimoPagoCesantias($fechaUltimoPagoCesantias): void
    {
        $this->fechaUltimoPagoCesantias = $fechaUltimoPagoCesantias;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPagoVacaciones()
    {
        return $this->fechaUltimoPagoVacaciones;
    }

    /**
     * @param mixed $fechaUltimoPagoVacaciones
     */
    public function setFechaUltimoPagoVacaciones($fechaUltimoPagoVacaciones): void
    {
        $this->fechaUltimoPagoVacaciones = $fechaUltimoPagoVacaciones;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPagoPrimas()
    {
        return $this->fechaUltimoPagoPrimas;
    }

    /**
     * @param mixed $fechaUltimoPagoPrimas
     */
    public function setFechaUltimoPagoPrimas($fechaUltimoPagoPrimas): void
    {
        $this->fechaUltimoPagoPrimas = $fechaUltimoPagoPrimas;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPago()
    {
        return $this->fechaUltimoPago;
    }

    /**
     * @param mixed $fechaUltimoPago
     */
    public function setFechaUltimoPago($fechaUltimoPago): void
    {
        $this->fechaUltimoPago = $fechaUltimoPago;
    }

    /**
     * @return mixed
     */
    public function getCodigoSubtipoCotizanteFk()
    {
        return $this->codigoSubtipoCotizanteFk;
    }

    /**
     * @param mixed $codigoSubtipoCotizanteFk
     */
    public function setCodigoSubtipoCotizanteFk($codigoSubtipoCotizanteFk): void
    {
        $this->codigoSubtipoCotizanteFk = $codigoSubtipoCotizanteFk;
    }

    /**
     * @return mixed
     */
    public function getSalarioIntegral()
    {
        return $this->salarioIntegral;
    }

    /**
     * @param mixed $salarioIntegral
     */
    public function setSalarioIntegral($salarioIntegral): void
    {
        $this->salarioIntegral = $salarioIntegral;
    }

    /**
     * @return mixed
     */
    public function getCodigoEntidadSaludFk()
    {
        return $this->codigoEntidadSaludFk;
    }

    /**
     * @param mixed $codigoEntidadSaludFk
     */
    public function setCodigoEntidadSaludFk($codigoEntidadSaludFk): void
    {
        $this->codigoEntidadSaludFk = $codigoEntidadSaludFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEntidadCesantiaFk()
    {
        return $this->codigoEntidadCesantiaFk;
    }

    /**
     * @param mixed $codigoEntidadCesantiaFk
     */
    public function setCodigoEntidadCesantiaFk($codigoEntidadCesantiaFk): void
    {
        $this->codigoEntidadCesantiaFk = $codigoEntidadCesantiaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEntidadCajaFk()
    {
        return $this->codigoEntidadCajaFk;
    }

    /**
     * @param mixed $codigoEntidadCajaFk
     */
    public function setCodigoEntidadCajaFk($codigoEntidadCajaFk): void
    {
        $this->codigoEntidadCajaFk = $codigoEntidadCajaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadContratoFk()
    {
        return $this->codigoCiudadContratoFk;
    }

    /**
     * @param mixed $codigoCiudadContratoFk
     */
    public function setCodigoCiudadContratoFk($codigoCiudadContratoFk): void
    {
        $this->codigoCiudadContratoFk = $codigoCiudadContratoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadLaboraFk()
    {
        return $this->codigoCiudadLaboraFk;
    }

    /**
     * @param mixed $codigoCiudadLaboraFk
     */
    public function setCodigoCiudadLaboraFk($codigoCiudadLaboraFk): void
    {
        $this->codigoCiudadLaboraFk = $codigoCiudadLaboraFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoSucursalFk()
    {
        return $this->codigoSucursalFk;
    }

    /**
     * @param mixed $codigoSucursalFk
     */
    public function setCodigoSucursalFk($codigoSucursalFk): void
    {
        $this->codigoSucursalFk = $codigoSucursalFk;
    }

    /**
     * @return mixed
     */
    public function getAuxilioTransporte()
    {
        return $this->auxilioTransporte;
    }

    /**
     * @param mixed $auxilioTransporte
     */
    public function setAuxilioTransporte($auxilioTransporte): void
    {
        $this->auxilioTransporte = $auxilioTransporte;
    }

    /**
     * @return mixed
     */
    public function getCodigoGrupoFk()
    {
        return $this->codigoGrupoFk;
    }

    /**
     * @param mixed $codigoGrupoFk
     */
    public function setCodigoGrupoFk($codigoGrupoFk): void
    {
        $this->codigoGrupoFk = $codigoGrupoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEntidadPensionFk()
    {
        return $this->codigoEntidadPensionFk;
    }

    /**
     * @param mixed $codigoEntidadPensionFk
     */
    public function setCodigoEntidadPensionFk($codigoEntidadPensionFk): void
    {
        $this->codigoEntidadPensionFk = $codigoEntidadPensionFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPensionFk()
    {
        return $this->codigoPensionFk;
    }

    /**
     * @param mixed $codigoPensionFk
     */
    public function setCodigoPensionFk($codigoPensionFk): void
    {
        $this->codigoPensionFk = $codigoPensionFk;
    }

    /**
     * @return mixed
     */
    public function getIndefinido()
    {
        return $this->indefinido;
    }

    /**
     * @param mixed $indefinido
     */
    public function setIndefinido($indefinido): void
    {
        $this->indefinido = $indefinido;
    }

    /**
     * @return mixed
     */
    public function getEmpleadoRel()
    {
        return $this->empleadoRel;
    }

    /**
     * @param mixed $empleadoRel
     */
    public function setEmpleadoRel($empleadoRel): void
    {
        $this->empleadoRel = $empleadoRel;
    }

    /**
     * @return mixed
     */
    public function getTiempoRel()
    {
        return $this->tiempoRel;
    }

    /**
     * @param mixed $tiempoRel
     */
    public function setTiempoRel($tiempoRel): void
    {
        $this->tiempoRel = $tiempoRel;
    }

    /**
     * @return mixed
     */
    public function getContratoClaseRel()
    {
        return $this->contratoClaseRel;
    }

    /**
     * @param mixed $contratoClaseRel
     */
    public function setContratoClaseRel($contratoClaseRel): void
    {
        $this->contratoClaseRel = $contratoClaseRel;
    }

    /**
     * @return mixed
     */
    public function getContratoTipoRel()
    {
        return $this->contratoTipoRel;
    }

    /**
     * @param mixed $contratoTipoRel
     */
    public function setContratoTipoRel($contratoTipoRel): void
    {
        $this->contratoTipoRel = $contratoTipoRel;
    }

    /**
     * @return mixed
     */
    public function getClasificacionRiesgoRel()
    {
        return $this->clasificacionRiesgoRel;
    }

    /**
     * @param mixed $clasificacionRiesgoRel
     */
    public function setClasificacionRiesgoRel($clasificacionRiesgoRel): void
    {
        $this->clasificacionRiesgoRel = $clasificacionRiesgoRel;
    }

    /**
     * @return mixed
     */
    public function getSaludRel()
    {
        return $this->saludRel;
    }

    /**
     * @param mixed $saludRel
     */
    public function setSaludRel($saludRel): void
    {
        $this->saludRel = $saludRel;
    }

    /**
     * @return mixed
     */
    public function getCargoRel()
    {
        return $this->cargoRel;
    }

    /**
     * @param mixed $cargoRel
     */
    public function setCargoRel($cargoRel): void
    {
        $this->cargoRel = $cargoRel;
    }

    /**
     * @return mixed
     */
    public function getGrupoRel()
    {
        return $this->grupoRel;
    }

    /**
     * @param mixed $grupoRel
     */
    public function setGrupoRel($grupoRel): void
    {
        $this->grupoRel = $grupoRel;
    }

    /**
     * @return mixed
     */
    public function getEntidadCesantiaRel()
    {
        return $this->entidadCesantiaRel;
    }

    /**
     * @param mixed $entidadCesantiaRel
     */
    public function setEntidadCesantiaRel($entidadCesantiaRel): void
    {
        $this->entidadCesantiaRel = $entidadCesantiaRel;
    }

    /**
     * @return mixed
     */
    public function getEntidadCajaRel()
    {
        return $this->entidadCajaRel;
    }

    /**
     * @param mixed $entidadCajaRel
     */
    public function setEntidadCajaRel($entidadCajaRel): void
    {
        $this->entidadCajaRel = $entidadCajaRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadContratoRel()
    {
        return $this->ciudadContratoRel;
    }

    /**
     * @param mixed $ciudadContratoRel
     */
    public function setCiudadContratoRel($ciudadContratoRel): void
    {
        $this->ciudadContratoRel = $ciudadContratoRel;
    }

    /**
     * @return mixed
     */
    public function getEntidadSaludRel()
    {
        return $this->entidadSaludRel;
    }

    /**
     * @param mixed $entidadSaludRel
     */
    public function setEntidadSaludRel($entidadSaludRel): void
    {
        $this->entidadSaludRel = $entidadSaludRel;
    }

    /**
     * @return mixed
     */
    public function getEntidadPensionRel()
    {
        return $this->entidadPensionRel;
    }

    /**
     * @param mixed $entidadPensionRel
     */
    public function setEntidadPensionRel($entidadPensionRel): void
    {
        $this->entidadPensionRel = $entidadPensionRel;
    }

    /**
     * @return mixed
     */
    public function getPensionRel()
    {
        return $this->pensionRel;
    }

    /**
     * @param mixed $pensionRel
     */
    public function setPensionRel($pensionRel): void
    {
        $this->pensionRel = $pensionRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadLaboraRel()
    {
        return $this->ciudadLaboraRel;
    }

    /**
     * @param mixed $ciudadLaboraRel
     */
    public function setCiudadLaboraRel($ciudadLaboraRel): void
    {
        $this->ciudadLaboraRel = $ciudadLaboraRel;
    }

    /**
     * @return mixed
     */
    public function getSucursalRel()
    {
        return $this->sucursalRel;
    }

    /**
     * @param mixed $sucursalRel
     */
    public function setSucursalRel($sucursalRel): void
    {
        $this->sucursalRel = $sucursalRel;
    }

    /**
     * @return mixed
     */
    public function getProgramacionesDetallesContratoRel()
    {
        return $this->programacionesDetallesContratoRel;
    }

    /**
     * @param mixed $programacionesDetallesContratoRel
     */
    public function setProgramacionesDetallesContratoRel($programacionesDetallesContratoRel): void
    {
        $this->programacionesDetallesContratoRel = $programacionesDetallesContratoRel;
    }

    /**
     * @return mixed
     */
    public function getNovedadesContratoRel()
    {
        return $this->novedadesContratoRel;
    }

    /**
     * @param mixed $novedadesContratoRel
     */
    public function setNovedadesContratoRel($novedadesContratoRel): void
    {
        $this->novedadesContratoRel = $novedadesContratoRel;
    }

    /**
     * @return mixed
     */
    public function getCreditosContratoRel()
    {
        return $this->creditosContratoRel;
    }

    /**
     * @param mixed $creditosContratoRel
     */
    public function setCreditosContratoRel($creditosContratoRel): void
    {
        $this->creditosContratoRel = $creditosContratoRel;
    }

    /**
     * @return mixed
     */
    public function getVacacionesContratoRel()
    {
        return $this->vacacionesContratoRel;
    }

    /**
     * @param mixed $vacacionesContratoRel
     */
    public function setVacacionesContratoRel($vacacionesContratoRel): void
    {
        $this->vacacionesContratoRel = $vacacionesContratoRel;
    }

    /**
     * @return mixed
     */
    public function getPagosContratoRel()
    {
        return $this->pagosContratoRel;
    }

    /**
     * @param mixed $pagosContratoRel
     */
    public function setPagosContratoRel($pagosContratoRel): void
    {
        $this->pagosContratoRel = $pagosContratoRel;
    }

    /**
     * @return mixed
     */
    public function getAdicionalesContratoRel()
    {
        return $this->adicionalesContratoRel;
    }

    /**
     * @param mixed $adicionalesContratoRel
     */
    public function setAdicionalesContratoRel($adicionalesContratoRel): void
    {
        $this->adicionalesContratoRel = $adicionalesContratoRel;
    }


}