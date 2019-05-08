<?php


namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrato
 *
 * @ORM\Table(name="RhuContrato")
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
     * @ORM\Column(name="codigo_contrato_motivo_fk", type="string", length=10, nullable=true)
     */
    private $codigoContratoMotivoFk;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="codigo_tiempo_fk", type="string", length=10, nullable=true)
     */
    private $codigoTiempoFk;

    /**
     * @ORM\Column(name="factor_horas_dia", options={"default" : 0 }, type="integer", nullable=true)
     */
    private $factorHorasDia = 0;

    /**
     * @ORM\Column(name="codigo_pension_fk", type="string", length=10, nullable=true)
     */
    private $codigoPensionFk;

    /**
     * @ORM\Column(name="codigo_salud_fk", type="string", length=10, nullable=true)
     */
    private $codigoSaludFk;

    /**
     * @ORM\Column(name="codigo_empleado_fk", type="integer")
     */
    private $codigoEmpleadoFk;

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
     * @ORM\Column(name="indefinido",options={"default": false}, type="boolean")
     */
    private $indefinido = false;

    /**
     * @ORM\Column(name="comentario_terminacion", type="string", length=2000, nullable=true)
     */
    private $comentarioTerminacion;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=10, nullable=true)
     */
    private $codigoGrupoFk;

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
     * @ORM\Column(name="codigo_tipo_cotizante_fk", type="string", length=10, nullable=true)
     */
    private $codigoTipoCotizanteFk;

    /**
     * @ORM\Column(name="codigo_subtipo_cotizante_fk", type="string", length=10, nullable=true)
     */
    private $codigoSubtipoCotizanteFk;

    /**
     * @ORM\Column(name="salario_integral", type="boolean",options={"default":false})
     */
    private $salarioIntegral = false;

    /**
     * @ORM\Column(name="costo_tipo_fk", type="string", length=10, nullable=true)
     */
    private $costoTipoFk = false;

    /**
     * @ORM\Column(name="codigo_entidad_salud_fk", type="integer", nullable=true)
     */
    private $codigoEntidadSaludFk;

    /**
     * @ORM\Column(name="codigo_entidad_pension_fk", type="integer", nullable=true)
     */
    private $codigoEntidadPensionFk;

    /**
     * @ORM\Column(name="codigo_entidad_cesantia_fk", type="integer", nullable=true)
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
     * @ORM\Column(name="codigo_costo_clase_fk", type="string", length=10, nullable=true)
     */
    private $codigoCostoClaseFk;

    /**
     * @ORM\Column(name="codigo_costo_grupo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCostoGrupoFk;

    /**
     * @ORM\Column(name="codigo_costo_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCostoTipoFk;

    /**
     * @ORM\Column(name="codigo_centro_trabajo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCentroTrabajoFk;

    /**
     * @ORM\Column(name="codigo_sucursal_fk", type="string", length=10, nullable=true)
     */
    private $codigoSucursalFk;

    /**
     * @ORM\Column(name="auxilio_transporte", type="boolean",options={"default":false})
     */
    private $auxilioTransporte = false;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="contratosEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk",referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContratoTipo", inversedBy="contratosContratoTipoRel")
     * @ORM\JoinColumn(name="codigo_contrato_tipo_fk",referencedColumnName="codigo_contrato_tipo_pk")
     */
    protected $contratoTipoRel;

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
    public function getCodigoContratoMotivoFk()
    {
        return $this->codigoContratoMotivoFk;
    }

    /**
     * @param mixed $codigoContratoMotivoFk
     */
    public function setCodigoContratoMotivoFk($codigoContratoMotivoFk): void
    {
        $this->codigoContratoMotivoFk = $codigoContratoMotivoFk;
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
    public function getCodigoTiempoFk()
    {
        return $this->codigoTiempoFk;
    }

    /**
     * @param mixed $codigoTiempoFk
     */
    public function setCodigoTiempoFk($codigoTiempoFk): void
    {
        $this->codigoTiempoFk = $codigoTiempoFk;
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
    public function getCodigoSaludFk()
    {
        return $this->codigoSaludFk;
    }

    /**
     * @param mixed $codigoSaludFk
     */
    public function setCodigoSaludFk($codigoSaludFk): void
    {
        $this->codigoSaludFk = $codigoSaludFk;
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
    public function getCodigoTipoCotizanteFk()
    {
        return $this->codigoTipoCotizanteFk;
    }

    /**
     * @param mixed $codigoTipoCotizanteFk
     */
    public function setCodigoTipoCotizanteFk($codigoTipoCotizanteFk): void
    {
        $this->codigoTipoCotizanteFk = $codigoTipoCotizanteFk;
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
    public function getCostoTipoFk()
    {
        return $this->costoTipoFk;
    }

    /**
     * @param mixed $costoTipoFk
     */
    public function setCostoTipoFk($costoTipoFk): void
    {
        $this->costoTipoFk = $costoTipoFk;
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
    public function getCodigoCostoClaseFk()
    {
        return $this->codigoCostoClaseFk;
    }

    /**
     * @param mixed $codigoCostoClaseFk
     */
    public function setCodigoCostoClaseFk($codigoCostoClaseFk): void
    {
        $this->codigoCostoClaseFk = $codigoCostoClaseFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCostoGrupoFk()
    {
        return $this->codigoCostoGrupoFk;
    }

    /**
     * @param mixed $codigoCostoGrupoFk
     */
    public function setCodigoCostoGrupoFk($codigoCostoGrupoFk): void
    {
        $this->codigoCostoGrupoFk = $codigoCostoGrupoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCostoTipoFk()
    {
        return $this->codigoCostoTipoFk;
    }

    /**
     * @param mixed $codigoCostoTipoFk
     */
    public function setCodigoCostoTipoFk($codigoCostoTipoFk): void
    {
        $this->codigoCostoTipoFk = $codigoCostoTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCentroTrabajoFk()
    {
        return $this->codigoCentroTrabajoFk;
    }

    /**
     * @param mixed $codigoCentroTrabajoFk
     */
    public function setCodigoCentroTrabajoFk($codigoCentroTrabajoFk): void
    {
        $this->codigoCentroTrabajoFk = $codigoCentroTrabajoFk;
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


}