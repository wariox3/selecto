<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RhuLiquidacion
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuLiquidacionRepository")
 */
class RhuLiquidacion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_liquidacion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoLiquidacionPk;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="numero", options={"default" : 0}, type="integer", nullable=true)
     */
    private $numero = 0;

    /**
     * @ORM\Column(name="codigo_empleado_fk", type="integer", nullable=true)
     */
    private $codigoEmpleadoFk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string", length=10, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="codigo_contrato_motivo_fk", type="string", length=10, nullable=true)
     */
    private $codigoContratoMotivoFk;

    /**
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="vr_cesantias", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrCesantias = 0;

    /**
     * @ORM\Column(name="vr_intereses_cesantias", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrInteresesCesantias = 0;

    /**
     * @ORM\Column(name="vr_prima", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrPrima = 0;

    /**
     * @ORM\Column(name="vr_vacacion", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrVacacion = 0;

    /**
     * @ORM\Column(name="vr_indemnizacion", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrIndemnizacion = 0;

    /**
     * @ORM\Column(name="dias_cesantias", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasCesantias = 0;

    /**
     * @ORM\Column(name="dias_cesantias_ausentismo", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasCesantiasAusentismo = 0;

    /**
     * @ORM\Column(name="dias_vacacion", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasVacacion = 0;

    /**
     * @ORM\Column(name="dias_vacacion_ausentismo", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasVacacionAusentismo = 0;

    /**
     * @ORM\Column(name="dias_prima", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasPrima = 0;

    /**
     * @ORM\Column(name="dias_prima_ausentismo", options={"default" : 0}, type="integer", nullable=true)
     */
    private $diasPrimaAusentismo = 0;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_prima", type="date", nullable=true)
     */
    private $fechaUltimoPagoPrima;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_vacacion", type="date", nullable=true)
     */
    private $fechaUltimoPagoVacacion;

    /**
     * @ORM\Column(name="fecha_ultimo_pago_cesantias", type="date", nullable=true)
     */
    private $fechaUltimoPagoCesantias;

    /**
     * @ORM\Column(name="estado_autorizado", options={"default" : false}, type="boolean", nullable=true)
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", options={"default" : false}, type="boolean", nullable=true)
     */
    private $estadoAnulado = false;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @return mixed
     */
    public function getCodigoLiquidacionPk()
    {
        return $this->codigoLiquidacionPk;
    }

    /**
     * @param mixed $codigoLiquidacionPk
     */
    public function setCodigoLiquidacionPk($codigoLiquidacionPk): void
    {
        $this->codigoLiquidacionPk = $codigoLiquidacionPk;
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
     * @return int
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
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
     * @return int
     */
    public function getVrCesantias(): int
    {
        return $this->vrCesantias;
    }

    /**
     * @param int $vrCesantias
     */
    public function setVrCesantias(int $vrCesantias): void
    {
        $this->vrCesantias = $vrCesantias;
    }

    /**
     * @return int
     */
    public function getVrInteresesCesantias(): int
    {
        return $this->vrInteresesCesantias;
    }

    /**
     * @param int $vrInteresesCesantias
     */
    public function setVrInteresesCesantias(int $vrInteresesCesantias): void
    {
        $this->vrInteresesCesantias = $vrInteresesCesantias;
    }

    /**
     * @return int
     */
    public function getVrPrima(): int
    {
        return $this->vrPrima;
    }

    /**
     * @param int $vrPrima
     */
    public function setVrPrima(int $vrPrima): void
    {
        $this->vrPrima = $vrPrima;
    }

    /**
     * @return int
     */
    public function getVrVacacion(): int
    {
        return $this->vrVacacion;
    }

    /**
     * @param int $vrVacacion
     */
    public function setVrVacacion(int $vrVacacion): void
    {
        $this->vrVacacion = $vrVacacion;
    }

    /**
     * @return int
     */
    public function getVrIndemnizacion(): int
    {
        return $this->vrIndemnizacion;
    }

    /**
     * @param int $vrIndemnizacion
     */
    public function setVrIndemnizacion(int $vrIndemnizacion): void
    {
        $this->vrIndemnizacion = $vrIndemnizacion;
    }

    /**
     * @return int
     */
    public function getDiasCesantias(): int
    {
        return $this->diasCesantias;
    }

    /**
     * @param int $diasCesantias
     */
    public function setDiasCesantias(int $diasCesantias): void
    {
        $this->diasCesantias = $diasCesantias;
    }

    /**
     * @return int
     */
    public function getDiasCesantiasAusentismo(): int
    {
        return $this->diasCesantiasAusentismo;
    }

    /**
     * @param int $diasCesantiasAusentismo
     */
    public function setDiasCesantiasAusentismo(int $diasCesantiasAusentismo): void
    {
        $this->diasCesantiasAusentismo = $diasCesantiasAusentismo;
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
    public function getDiasVacacionAusentismo(): int
    {
        return $this->diasVacacionAusentismo;
    }

    /**
     * @param int $diasVacacionAusentismo
     */
    public function setDiasVacacionAusentismo(int $diasVacacionAusentismo): void
    {
        $this->diasVacacionAusentismo = $diasVacacionAusentismo;
    }

    /**
     * @return int
     */
    public function getDiasPrima(): int
    {
        return $this->diasPrima;
    }

    /**
     * @param int $diasPrima
     */
    public function setDiasPrima(int $diasPrima): void
    {
        $this->diasPrima = $diasPrima;
    }

    /**
     * @return int
     */
    public function getDiasPrimaAusentismo(): int
    {
        return $this->diasPrimaAusentismo;
    }

    /**
     * @param int $diasPrimaAusentismo
     */
    public function setDiasPrimaAusentismo(int $diasPrimaAusentismo): void
    {
        $this->diasPrimaAusentismo = $diasPrimaAusentismo;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPagoPrima()
    {
        return $this->fechaUltimoPagoPrima;
    }

    /**
     * @param mixed $fechaUltimoPagoPrima
     */
    public function setFechaUltimoPagoPrima($fechaUltimoPagoPrima): void
    {
        $this->fechaUltimoPagoPrima = $fechaUltimoPagoPrima;
    }

    /**
     * @return mixed
     */
    public function getFechaUltimoPagoVacacion()
    {
        return $this->fechaUltimoPagoVacacion;
    }

    /**
     * @param mixed $fechaUltimoPagoVacacion
     */
    public function setFechaUltimoPagoVacacion($fechaUltimoPagoVacacion): void
    {
        $this->fechaUltimoPagoVacacion = $fechaUltimoPagoVacacion;
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
     * @return bool
     */
    public function getEstadoAutorizado(): bool
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param bool $estadoAutorizado
     */
    public function setEstadoAutorizado(bool $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return bool
     */
    public function getEstadoAprobado(): bool
    {
        return $this->estadoAprobado;
    }

    /**
     * @param bool $estadoAprobado
     */
    public function setEstadoAprobado(bool $estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return bool
     */
    public function getEstadoAnulado(): bool
    {
        return $this->estadoAnulado;
    }

    /**
     * @param bool $estadoAnulado
     */
    public function setEstadoAnulado(bool $estadoAnulado): void
    {
        $this->estadoAnulado = $estadoAnulado;
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


}


