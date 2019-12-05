<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuProgramacionDetalle
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuProgramacionDetalleRepository")
 */
class RhuProgramacionDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_programacion_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoProgramacionDetallePk;

    /**
     * @ORM\Column(name="codigo_programacion_fk", type="integer", nullable=true)
     */
    private $codigoProgramacionFk;

    /**
     * @ORM\Column(name="codigo_empleado_fk", type="integer", nullable=true)
     */
    private $codigoEmpleadoFk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="dias", type="integer")
     */
    private $dias = 0;

    /**
     * Para el auxilio de transporte
     * @ORM\Column(name="dias_transporte", type="integer")
     */
    private $diasTransporte = 0;

    /**
     * @ORM\Column(name="vr_salario", type="float")
     */
    private $vrSalario = 0;

    /**
     * @ORM\Column(name="vr_neto", type="float", nullable=true)
     */
    private $vrNeto = 0;

    /**
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="fecha_desde_contrato", type="date", nullable=true)
     */
    private $fechaDesdeContrato;

    /**
     * @ORM\Column(name="fecha_hasta_contrato", type="date", nullable=true)
     */
    private $fechaHastaContrato;

    /**
     * @ORM\Column(name="horas_diurnas", type="float")
     */
    private $horasDiurnas = 0;

    /**
     * @ORM\Column(name="horas_nocturnas", type="float")
     */
    private $horasNocturnas = 0;

    /**
     * @ORM\Column(name="horas_festivas_diurnas", type="float")
     */
    private $horasFestivasDiurnas = 0;

    /**
     * @ORM\Column(name="horas_festivas_nocturnas", type="float")
     */
    private $horasFestivasNocturnas = 0;

    /**
     * @ORM\Column(name="horas_extras_ordinarias_diurnas", type="float")
     */
    private $horasExtrasOrdinariasDiurnas = 0;

    /**
     * @ORM\Column(name="horas_extras_ordinarias_nocturnas", type="float")
     */
    private $horasExtrasOrdinariasNocturnas = 0;

    /**
     * @ORM\Column(name="horas_extras_festivas_diurnas", type="float")
     */
    private $horasExtrasFestivasDiurnas = 0;

    /**
     * @ORM\Column(name="horas_extras_festivas_nocturnas", type="float")
     */
    private $horasExtrasFestivasNocturnas = 0;

    /**
     * @ORM\Column(name="horas_recargo_nocturno", type="float")
     */
    private $horasRecargoNocturno = 0;

    /**
     * @ORM\Column(name="horas_recargo_festivo_diurno", type="float")
     */
    private $horasRecargoFestivoDiurno = 0;

    /**
     * @ORM\Column(name="horas_recargo_festivo_nocturno", type="float")
     */
    private $horasRecargoFestivoNocturno = 0;

    /**
     * @ORM\Column(name="dias_licencia", type="integer")
     */
    private $diasLicencia = 0;

    /**
     * @ORM\Column(name="factor_dia", type="integer")
     */
    private $factorDia = 0;

    /**
     * @ORM\Column(name="dias_incapacidad", type="integer")
     */
    private $diasIncapacidad = 0;

    /**
     * @ORM\Column(name="dias_vacacion", type="integer")
     */
    private $diasVacacion = 0;

    /**
     * @ORM\Column(name="ibc_vacacion", type="float")
     */
    private $ibcVacacion = 0;

    /**
     * @ORM\Column(name="descuento_salud", options={"default": true}, type="boolean", nullable=true)
     */
    private $descuentoSalud = true;

    /**
     * @ORM\Column(name="descuento_pension", options={"default": true}, type="boolean", nullable=true)
     */
    private $descuentoPension = true;

    /**
     * @ORM\Column(name="pago_auxilio_transporte", options={"default": true}, type="boolean", nullable=true)
     */
    private $pagoAuxilioTransporte = true;

    /**
     * @ORM\Column(name="vr_ibc_acumulado", type="float", options={"default": 0})
     */
    private $vrIbcAcumulado = 0;

    /**
     * @ORM\Column(name="vr_deduccion_fondo_pension_anterior", type="float", options={"default": 0})
     */
    private $vrDeduccionFondoPensionAnterior = 0;

    /**
     * @ORM\ManyToOne(targetEntity="RhuProgramacion", inversedBy="programacionesDetallesProgramacionRel")
     * @ORM\JoinColumn(name="codigo_programacion_fk", referencedColumnName="codigo_programacion_pk")
     */
    protected $programacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="programacionesPagosDetallesEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk", referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContrato", inversedBy="programacionesDetallesContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    protected $contratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPago", mappedBy="programacionDetalleRel")
     */
    protected $pagosProgramacionDetalleRel;

    /**
     * @return mixed
     */
    public function getCodigoProgramacionDetallePk()
    {
        return $this->codigoProgramacionDetallePk;
    }

    /**
     * @param mixed $codigoProgramacionDetallePk
     */
    public function setCodigoProgramacionDetallePk($codigoProgramacionDetallePk): void
    {
        $this->codigoProgramacionDetallePk = $codigoProgramacionDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoProgramacionFk()
    {
        return $this->codigoProgramacionFk;
    }

    /**
     * @param mixed $codigoProgramacionFk
     */
    public function setCodigoProgramacionFk($codigoProgramacionFk): void
    {
        $this->codigoProgramacionFk = $codigoProgramacionFk;
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
    public function getCodigoContratoFk()
    {
        return $this->codigoContratoFk;
    }

    /**
     * @param mixed $codigoContratoFk
     */
    public function setCodigoContratoFk($codigoContratoFk): void
    {
        $this->codigoContratoFk = $codigoContratoFk;
    }

    /**
     * @return int
     */
    public function getDias(): int
    {
        return $this->dias;
    }

    /**
     * @param int $dias
     */
    public function setDias(int $dias): void
    {
        $this->dias = $dias;
    }

    /**
     * @return int
     */
    public function getDiasTransporte(): int
    {
        return $this->diasTransporte;
    }

    /**
     * @param int $diasTransporte
     */
    public function setDiasTransporte(int $diasTransporte): void
    {
        $this->diasTransporte = $diasTransporte;
    }

    /**
     * @return int
     */
    public function getVrSalario(): int
    {
        return $this->vrSalario;
    }

    /**
     * @param int $vrSalario
     */
    public function setVrSalario(int $vrSalario): void
    {
        $this->vrSalario = $vrSalario;
    }

    /**
     * @return int
     */
    public function getVrNeto(): int
    {
        return $this->vrNeto;
    }

    /**
     * @param int $vrNeto
     */
    public function setVrNeto(int $vrNeto): void
    {
        $this->vrNeto = $vrNeto;
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
    public function getFechaDesdeContrato()
    {
        return $this->fechaDesdeContrato;
    }

    /**
     * @param mixed $fechaDesdeContrato
     */
    public function setFechaDesdeContrato($fechaDesdeContrato): void
    {
        $this->fechaDesdeContrato = $fechaDesdeContrato;
    }

    /**
     * @return mixed
     */
    public function getFechaHastaContrato()
    {
        return $this->fechaHastaContrato;
    }

    /**
     * @param mixed $fechaHastaContrato
     */
    public function setFechaHastaContrato($fechaHastaContrato): void
    {
        $this->fechaHastaContrato = $fechaHastaContrato;
    }

    /**
     * @return int
     */
    public function getHorasDiurnas(): int
    {
        return $this->horasDiurnas;
    }

    /**
     * @param int $horasDiurnas
     */
    public function setHorasDiurnas(int $horasDiurnas): void
    {
        $this->horasDiurnas = $horasDiurnas;
    }

    /**
     * @return int
     */
    public function getHorasNocturnas(): int
    {
        return $this->horasNocturnas;
    }

    /**
     * @param int $horasNocturnas
     */
    public function setHorasNocturnas(int $horasNocturnas): void
    {
        $this->horasNocturnas = $horasNocturnas;
    }

    /**
     * @return int
     */
    public function getHorasFestivasDiurnas(): int
    {
        return $this->horasFestivasDiurnas;
    }

    /**
     * @param int $horasFestivasDiurnas
     */
    public function setHorasFestivasDiurnas(int $horasFestivasDiurnas): void
    {
        $this->horasFestivasDiurnas = $horasFestivasDiurnas;
    }

    /**
     * @return int
     */
    public function getHorasFestivasNocturnas(): int
    {
        return $this->horasFestivasNocturnas;
    }

    /**
     * @param int $horasFestivasNocturnas
     */
    public function setHorasFestivasNocturnas(int $horasFestivasNocturnas): void
    {
        $this->horasFestivasNocturnas = $horasFestivasNocturnas;
    }

    /**
     * @return int
     */
    public function getHorasExtrasOrdinariasDiurnas(): int
    {
        return $this->horasExtrasOrdinariasDiurnas;
    }

    /**
     * @param int $horasExtrasOrdinariasDiurnas
     */
    public function setHorasExtrasOrdinariasDiurnas(int $horasExtrasOrdinariasDiurnas): void
    {
        $this->horasExtrasOrdinariasDiurnas = $horasExtrasOrdinariasDiurnas;
    }

    /**
     * @return int
     */
    public function getHorasExtrasOrdinariasNocturnas(): int
    {
        return $this->horasExtrasOrdinariasNocturnas;
    }

    /**
     * @param int $horasExtrasOrdinariasNocturnas
     */
    public function setHorasExtrasOrdinariasNocturnas(int $horasExtrasOrdinariasNocturnas): void
    {
        $this->horasExtrasOrdinariasNocturnas = $horasExtrasOrdinariasNocturnas;
    }

    /**
     * @return int
     */
    public function getHorasExtrasFestivasDiurnas(): int
    {
        return $this->horasExtrasFestivasDiurnas;
    }

    /**
     * @param int $horasExtrasFestivasDiurnas
     */
    public function setHorasExtrasFestivasDiurnas(int $horasExtrasFestivasDiurnas): void
    {
        $this->horasExtrasFestivasDiurnas = $horasExtrasFestivasDiurnas;
    }

    /**
     * @return int
     */
    public function getHorasExtrasFestivasNocturnas(): int
    {
        return $this->horasExtrasFestivasNocturnas;
    }

    /**
     * @param int $horasExtrasFestivasNocturnas
     */
    public function setHorasExtrasFestivasNocturnas(int $horasExtrasFestivasNocturnas): void
    {
        $this->horasExtrasFestivasNocturnas = $horasExtrasFestivasNocturnas;
    }

    /**
     * @return int
     */
    public function getHorasRecargoNocturno(): int
    {
        return $this->horasRecargoNocturno;
    }

    /**
     * @param int $horasRecargoNocturno
     */
    public function setHorasRecargoNocturno(int $horasRecargoNocturno): void
    {
        $this->horasRecargoNocturno = $horasRecargoNocturno;
    }

    /**
     * @return int
     */
    public function getHorasRecargoFestivoDiurno(): int
    {
        return $this->horasRecargoFestivoDiurno;
    }

    /**
     * @param int $horasRecargoFestivoDiurno
     */
    public function setHorasRecargoFestivoDiurno(int $horasRecargoFestivoDiurno): void
    {
        $this->horasRecargoFestivoDiurno = $horasRecargoFestivoDiurno;
    }

    /**
     * @return int
     */
    public function getHorasRecargoFestivoNocturno(): int
    {
        return $this->horasRecargoFestivoNocturno;
    }

    /**
     * @param int $horasRecargoFestivoNocturno
     */
    public function setHorasRecargoFestivoNocturno(int $horasRecargoFestivoNocturno): void
    {
        $this->horasRecargoFestivoNocturno = $horasRecargoFestivoNocturno;
    }

    /**
     * @return int
     */
    public function getDiasLicencia(): int
    {
        return $this->diasLicencia;
    }

    /**
     * @param int $diasLicencia
     */
    public function setDiasLicencia(int $diasLicencia): void
    {
        $this->diasLicencia = $diasLicencia;
    }

    /**
     * @return int
     */
    public function getFactorDia(): int
    {
        return $this->factorDia;
    }

    /**
     * @param int $factorDia
     */
    public function setFactorDia(int $factorDia): void
    {
        $this->factorDia = $factorDia;
    }

    /**
     * @return int
     */
    public function getDiasIncapacidad(): int
    {
        return $this->diasIncapacidad;
    }

    /**
     * @param int $diasIncapacidad
     */
    public function setDiasIncapacidad(int $diasIncapacidad): void
    {
        $this->diasIncapacidad = $diasIncapacidad;
    }

    /**
     * @return int
     */
    public function getDiasVacacion(): int
    {
        return $this->diasVacacion;
    }

    /**
     * @param int $diasVacacion
     */
    public function setDiasVacacion(int $diasVacacion): void
    {
        $this->diasVacacion = $diasVacacion;
    }

    /**
     * @return int
     */
    public function getIbcVacacion(): int
    {
        return $this->ibcVacacion;
    }

    /**
     * @param int $ibcVacacion
     */
    public function setIbcVacacion(int $ibcVacacion): void
    {
        $this->ibcVacacion = $ibcVacacion;
    }

    /**
     * @return bool
     */
    public function isDescuentoSalud(): bool
    {
        return $this->descuentoSalud;
    }

    /**
     * @param bool $descuentoSalud
     */
    public function setDescuentoSalud(bool $descuentoSalud): void
    {
        $this->descuentoSalud = $descuentoSalud;
    }

    /**
     * @return bool
     */
    public function isDescuentoPension(): bool
    {
        return $this->descuentoPension;
    }

    /**
     * @param bool $descuentoPension
     */
    public function setDescuentoPension(bool $descuentoPension): void
    {
        $this->descuentoPension = $descuentoPension;
    }

    /**
     * @return bool
     */
    public function isPagoAuxilioTransporte(): bool
    {
        return $this->pagoAuxilioTransporte;
    }

    /**
     * @param bool $pagoAuxilioTransporte
     */
    public function setPagoAuxilioTransporte(bool $pagoAuxilioTransporte): void
    {
        $this->pagoAuxilioTransporte = $pagoAuxilioTransporte;
    }

    /**
     * @return int
     */
    public function getVrIbcAcumulado(): int
    {
        return $this->vrIbcAcumulado;
    }

    /**
     * @param int $vrIbcAcumulado
     */
    public function setVrIbcAcumulado(int $vrIbcAcumulado): void
    {
        $this->vrIbcAcumulado = $vrIbcAcumulado;
    }

    /**
     * @return int
     */
    public function getVrDeduccionFondoPensionAnterior(): int
    {
        return $this->vrDeduccionFondoPensionAnterior;
    }

    /**
     * @param int $vrDeduccionFondoPensionAnterior
     */
    public function setVrDeduccionFondoPensionAnterior(int $vrDeduccionFondoPensionAnterior): void
    {
        $this->vrDeduccionFondoPensionAnterior = $vrDeduccionFondoPensionAnterior;
    }

    /**
     * @return mixed
     */
    public function getProgramacionRel()
    {
        return $this->programacionRel;
    }

    /**
     * @param mixed $programacionRel
     */
    public function setProgramacionRel($programacionRel): void
    {
        $this->programacionRel = $programacionRel;
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
    public function getContratoRel()
    {
        return $this->contratoRel;
    }

    /**
     * @param mixed $contratoRel
     */
    public function setContratoRel($contratoRel): void
    {
        $this->contratoRel = $contratoRel;
    }

    /**
     * @return mixed
     */
    public function getPagosProgramacionDetalleRel()
    {
        return $this->pagosProgramacionDetalleRel;
    }

    /**
     * @param mixed $pagosProgramacionDetalleRel
     */
    public function setPagosProgramacionDetalleRel($pagosProgramacionDetalleRel): void
    {
        $this->pagosProgramacionDetalleRel = $pagosProgramacionDetalleRel;
    }


}
