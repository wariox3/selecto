<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuVacacion
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuVacacionRepository")
 */
class RhuVacacion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_vacacion_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoVacacionPk;

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
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="fecha", type="date",nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_contabilidad", type="date", nullable=true)
     */
    private $fechaContabilidad;

    /**
     * @ORM\Column(name="numero", options={"default": 0},type="integer",nullable=true)
     */
    private $numero = 0;

    /**
     * @ORM\Column(name="fecha_desde_periodo", type="date",nullable=true)
     */
    private $fechaDesdePeriodo;

    /**
     * @ORM\Column(name="fecha_hasta_periodo", type="date",nullable=true)
     */
    private $fechaHastaPeriodo;

    /**
     * @ORM\Column(name="fecha_desde_disfrute", type="date",nullable=true)
     */
    private $fechaDesdeDisfrute;

    /**
     * @ORM\Column(name="fecha_hasta_disfrute", type="date",nullable=true)
     */
    private $fechaHastaDisfrute;

    /**
     * @ORM\Column(name="fecha_inicio_labor", type="date", nullable=true)
     */
    private $fechaInicioLabor;

    /**
     * @ORM\Column(name="vr_salud",options={"default": 0}, type="float",nullable=true)
     */
    private $vrSalud = 0;

    /**
     * @ORM\Column(name="vr_pension",options={"default": 0}, type="float",nullable=true)
     */
    private $vrPension = 0;

    /**
     * @ORM\Column(name="vr_fondo_solidaridad",options={"default": 0}, type="float", nullable=true)
     */
    private $vrFondoSolidaridad = 0;

    /**
     * @ORM\Column(name="vr_ibc", options={"default": 0}, type="float",nullable=true)
     */
    private $vrIbc = 0;

    /**
     * @ORM\Column(name="vr_deduccion",options={"default": 0}, type="float",nullable=true)
     */
    private $vrDeduccion = 0;

    /**
     * @ORM\Column(name="vr_bonificacion",options={"default": 0}, type="float",nullable=true)
     */
    private $vrBonificacion = 0;

    /**
     * @ORM\Column(name="vr_valor",options={"default": 0}, type="float",nullable=true)
     */
    private $vrValor = 0;

    /**
     * @ORM\Column(name="vr_disfrute",options={"default": 0}, type="float", nullable=true)
     */
    private $vrDisfrute = 0;

    /**
     * @ORM\Column(name="vr_dinero",options={"default": 0}, type="float", nullable=true)
     */
    private $vrDinero = 0;

    /**
     * @ORM\Column(name="vr_total",options={"default": 0}, type="float", nullable=true)
     */
    private $vrTotal = 0;

    /**
     * @ORM\Column(name="dias",options={"default": 0}, type="integer",nullable=true)
     */
    private $dias = 0;

    /**
     * @ORM\Column(name="dias_disfrutados", options={"default": 0}, type="integer",nullable=true)
     */
    private $diasDisfrutados = 0;

    /**
     * @ORM\Column(name="dias_ausentismo", options={"default": 0}, type="integer", nullable=true)
     */
    private $diasAusentismo = 0;

    /**
     * @ORM\Column(name="dias_pagados", options={"default": 0}, type="integer",nullable=true)
     */
    private $diasPagados = 0;

    /**
     * @ORM\Column(name="dias_disfrutados_reales", options={"default": 0}, type="integer",nullable=true)
     */
    private $diasDisfrutadosReales = 0;

    /**
     * @ORM\Column(name="dias_periodo", options={"default": 0}, type="integer",nullable=true)
     */
    private $diasPeriodo = 0;

    /**
     * @ORM\Column(name="meses_periodo", options={"default": 0}, type="float",nullable=true)
     */
    private $mesesPeriodo = 0;

    /**
     * @ORM\Column(name="comentarios", type="string", length=200, nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\Column(name="vr_salario_actual", options={"default": 0}, type="float",nullable=true)
     */
    private $vrSalarioActual = 0;

    /**
     * @ORM\Column(name="vr_salario_promedio", options={"default": 0}, type="float",nullable=true)
     */
    private $vrSalarioPromedio = 0;

    /**
     * @ORM\Column(name="vr_salario_promedio_propuesto", options={"default": 0}, type="float",nullable=true)

     */
    private $vrSalarioPromedioPropuesto = 0;

    /**
     * @ORM\Column(name="vr_disfrute_propuesto", options={"default": 0}, type="float", nullable=true)
     */
    private $vrDisfrutePropuesto = 0;


    /**
     * @ORM\Column(name="vr_salario_promedio_propuesto_pagado", options={"default": 0}, type="float", nullable=true)
     */
    private $vrSalarioPromedioPropuestoPagado = 0;

    /**
     * @ORM\Column(name="vr_salud_propuesto", options={"default": 0}, type="float", nullable=true)
     */
    private $vrSaludPropuesto = 0;

    /**
     * @ORM\Column(name="vr_pension_propuesto", options={"default": 0}, type="float", nullable=true)
     */
    private $vrPensionPropuesto = 0;

    /**
     * @ORM\Column(name="dias_ausentismo_propuesto", options={"default": 0}, type="integer", nullable=true)
     */
    private $diasAusentismoPropuesto = 0;

    /**
     * @ORM\Column(name="vr_bruto", options={"default": 0}, type="float",nullable=true)
     */
    private $vrBruto = 0;

    /**
     * @ORM\Column(name="estado_pago_generado", options={"default": false}, type="boolean",nullable=true)
     */
    private $estadoPagoGenerado = false;

    /**
     * @ORM\Column(name="estado_pago_banco", options={"default": false}, type="boolean",nullable=true)
     */
    private $estadoPagoBanco = false;

    /**
     * @ORM\Column(name="estado_contabilizado", options={"default": false}, type="boolean",nullable=true)
     */
    private $estadoContabilizado = false;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", options={"default": false}, type="boolean",nullable=true)
     */
    private $estadoAnulado = false;

    /**
     * @ORM\Column(name="estado_pagado", options={"default": false}, type="boolean",nullable=true)
     */
    private $estadoPagado = false;

    /**
     * @ORM\Column(name="estado_liquidado", options={"default": false}, type="boolean", nullable=true)
     */
    private $estadoLiquidado = false;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="vr_recargo_nocturno_inicial", options={"default": 0}, type="float",nullable=true)
     */
    private $vrRecargoNocturnoInicial = 0;

    /**
     * @ORM\Column(name="vr_recargo_nocturno", options={"default": 0}, type="float",nullable=true)
     */
    private $vrRecargoNocturno = 0;

    /**
     * @ORM\Column(name="vr_promedio_recargo_nocturno", options={"default": 0}, type="float",nullable=true)
     */
    private $vrPromedioRecargoNocturno = 0;

    /**
     * @ORM\Column(name="vr_ibc_promedio", options={"default": 0}, type="float",nullable=true)
     */
    private $vrIbcPromedio = 0;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContrato", inversedBy="vacacionesContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    protected $contratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="vacacionesEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk", referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuGrupo", inversedBy="vacacionesGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    protected $grupoRel;

    /**
     * @return mixed
     */
    public function getCodigoVacacionPk()
    {
        return $this->codigoVacacionPk;
    }

    /**
     * @param mixed $codigoVacacionPk
     */
    public function setCodigoVacacionPk($codigoVacacionPk): void
    {
        $this->codigoVacacionPk = $codigoVacacionPk;
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
    public function getFechaContabilidad()
    {
        return $this->fechaContabilidad;
    }

    /**
     * @param mixed $fechaContabilidad
     */
    public function setFechaContabilidad($fechaContabilidad): void
    {
        $this->fechaContabilidad = $fechaContabilidad;
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
    public function getFechaDesdePeriodo()
    {
        return $this->fechaDesdePeriodo;
    }

    /**
     * @param mixed $fechaDesdePeriodo
     */
    public function setFechaDesdePeriodo($fechaDesdePeriodo): void
    {
        $this->fechaDesdePeriodo = $fechaDesdePeriodo;
    }

    /**
     * @return mixed
     */
    public function getFechaHastaPeriodo()
    {
        return $this->fechaHastaPeriodo;
    }

    /**
     * @param mixed $fechaHastaPeriodo
     */
    public function setFechaHastaPeriodo($fechaHastaPeriodo): void
    {
        $this->fechaHastaPeriodo = $fechaHastaPeriodo;
    }

    /**
     * @return mixed
     */
    public function getFechaDesdeDisfrute()
    {
        return $this->fechaDesdeDisfrute;
    }

    /**
     * @param mixed $fechaDesdeDisfrute
     */
    public function setFechaDesdeDisfrute($fechaDesdeDisfrute): void
    {
        $this->fechaDesdeDisfrute = $fechaDesdeDisfrute;
    }

    /**
     * @return mixed
     */
    public function getFechaHastaDisfrute()
    {
        return $this->fechaHastaDisfrute;
    }

    /**
     * @param mixed $fechaHastaDisfrute
     */
    public function setFechaHastaDisfrute($fechaHastaDisfrute): void
    {
        $this->fechaHastaDisfrute = $fechaHastaDisfrute;
    }

    /**
     * @return mixed
     */
    public function getFechaInicioLabor()
    {
        return $this->fechaInicioLabor;
    }

    /**
     * @param mixed $fechaInicioLabor
     */
    public function setFechaInicioLabor($fechaInicioLabor): void
    {
        $this->fechaInicioLabor = $fechaInicioLabor;
    }

    /**
     * @return int
     */
    public function getVrSalud(): int
    {
        return $this->vrSalud;
    }

    /**
     * @param int $vrSalud
     */
    public function setVrSalud(int $vrSalud): void
    {
        $this->vrSalud = $vrSalud;
    }

    /**
     * @return int
     */
    public function getVrPension(): int
    {
        return $this->vrPension;
    }

    /**
     * @param int $vrPension
     */
    public function setVrPension(int $vrPension): void
    {
        $this->vrPension = $vrPension;
    }

    /**
     * @return int
     */
    public function getVrFondoSolidaridad(): int
    {
        return $this->vrFondoSolidaridad;
    }

    /**
     * @param int $vrFondoSolidaridad
     */
    public function setVrFondoSolidaridad(int $vrFondoSolidaridad): void
    {
        $this->vrFondoSolidaridad = $vrFondoSolidaridad;
    }

    /**
     * @return int
     */
    public function getVrIbc(): int
    {
        return $this->vrIbc;
    }

    /**
     * @param int $vrIbc
     */
    public function setVrIbc(int $vrIbc): void
    {
        $this->vrIbc = $vrIbc;
    }

    /**
     * @return int
     */
    public function getVrDeduccion(): int
    {
        return $this->vrDeduccion;
    }

    /**
     * @param int $vrDeduccion
     */
    public function setVrDeduccion(int $vrDeduccion): void
    {
        $this->vrDeduccion = $vrDeduccion;
    }

    /**
     * @return int
     */
    public function getVrBonificacion(): int
    {
        return $this->vrBonificacion;
    }

    /**
     * @param int $vrBonificacion
     */
    public function setVrBonificacion(int $vrBonificacion): void
    {
        $this->vrBonificacion = $vrBonificacion;
    }

    /**
     * @return int
     */
    public function getVrValor(): int
    {
        return $this->vrValor;
    }

    /**
     * @param int $vrValor
     */
    public function setVrValor(int $vrValor): void
    {
        $this->vrValor = $vrValor;
    }

    /**
     * @return int
     */
    public function getVrDisfrute(): int
    {
        return $this->vrDisfrute;
    }

    /**
     * @param int $vrDisfrute
     */
    public function setVrDisfrute(int $vrDisfrute): void
    {
        $this->vrDisfrute = $vrDisfrute;
    }

    /**
     * @return int
     */
    public function getVrDinero(): int
    {
        return $this->vrDinero;
    }

    /**
     * @param int $vrDinero
     */
    public function setVrDinero(int $vrDinero): void
    {
        $this->vrDinero = $vrDinero;
    }

    /**
     * @return int
     */
    public function getVrTotal(): int
    {
        return $this->vrTotal;
    }

    /**
     * @param int $vrTotal
     */
    public function setVrTotal(int $vrTotal): void
    {
        $this->vrTotal = $vrTotal;
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
    public function getDiasDisfrutados(): int
    {
        return $this->diasDisfrutados;
    }

    /**
     * @param int $diasDisfrutados
     */
    public function setDiasDisfrutados(int $diasDisfrutados): void
    {
        $this->diasDisfrutados = $diasDisfrutados;
    }

    /**
     * @return int
     */
    public function getDiasAusentismo(): int
    {
        return $this->diasAusentismo;
    }

    /**
     * @param int $diasAusentismo
     */
    public function setDiasAusentismo(int $diasAusentismo): void
    {
        $this->diasAusentismo = $diasAusentismo;
    }

    /**
     * @return int
     */
    public function getDiasPagados(): int
    {
        return $this->diasPagados;
    }

    /**
     * @param int $diasPagados
     */
    public function setDiasPagados(int $diasPagados): void
    {
        $this->diasPagados = $diasPagados;
    }

    /**
     * @return int
     */
    public function getDiasDisfrutadosReales(): int
    {
        return $this->diasDisfrutadosReales;
    }

    /**
     * @param int $diasDisfrutadosReales
     */
    public function setDiasDisfrutadosReales(int $diasDisfrutadosReales): void
    {
        $this->diasDisfrutadosReales = $diasDisfrutadosReales;
    }

    /**
     * @return int
     */
    public function getDiasPeriodo(): int
    {
        return $this->diasPeriodo;
    }

    /**
     * @param int $diasPeriodo
     */
    public function setDiasPeriodo(int $diasPeriodo): void
    {
        $this->diasPeriodo = $diasPeriodo;
    }

    /**
     * @return int
     */
    public function getMesesPeriodo(): int
    {
        return $this->mesesPeriodo;
    }

    /**
     * @param int $mesesPeriodo
     */
    public function setMesesPeriodo(int $mesesPeriodo): void
    {
        $this->mesesPeriodo = $mesesPeriodo;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */
    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @return int
     */
    public function getVrSalarioActual(): int
    {
        return $this->vrSalarioActual;
    }

    /**
     * @param int $vrSalarioActual
     */
    public function setVrSalarioActual(int $vrSalarioActual): void
    {
        $this->vrSalarioActual = $vrSalarioActual;
    }

    /**
     * @return int
     */
    public function getVrSalarioPromedio(): int
    {
        return $this->vrSalarioPromedio;
    }

    /**
     * @param int $vrSalarioPromedio
     */
    public function setVrSalarioPromedio(int $vrSalarioPromedio): void
    {
        $this->vrSalarioPromedio = $vrSalarioPromedio;
    }

    /**
     * @return int
     */
    public function getVrSalarioPromedioPropuesto(): int
    {
        return $this->vrSalarioPromedioPropuesto;
    }

    /**
     * @param int $vrSalarioPromedioPropuesto
     */
    public function setVrSalarioPromedioPropuesto(int $vrSalarioPromedioPropuesto): void
    {
        $this->vrSalarioPromedioPropuesto = $vrSalarioPromedioPropuesto;
    }

    /**
     * @return int
     */
    public function getVrDisfrutePropuesto(): int
    {
        return $this->vrDisfrutePropuesto;
    }

    /**
     * @param int $vrDisfrutePropuesto
     */
    public function setVrDisfrutePropuesto(int $vrDisfrutePropuesto): void
    {
        $this->vrDisfrutePropuesto = $vrDisfrutePropuesto;
    }

    /**
     * @return int
     */
    public function getVrSalarioPromedioPropuestoPagado(): int
    {
        return $this->vrSalarioPromedioPropuestoPagado;
    }

    /**
     * @param int $vrSalarioPromedioPropuestoPagado
     */
    public function setVrSalarioPromedioPropuestoPagado(int $vrSalarioPromedioPropuestoPagado): void
    {
        $this->vrSalarioPromedioPropuestoPagado = $vrSalarioPromedioPropuestoPagado;
    }

    /**
     * @return int
     */
    public function getVrSaludPropuesto(): int
    {
        return $this->vrSaludPropuesto;
    }

    /**
     * @param int $vrSaludPropuesto
     */
    public function setVrSaludPropuesto(int $vrSaludPropuesto): void
    {
        $this->vrSaludPropuesto = $vrSaludPropuesto;
    }

    /**
     * @return int
     */
    public function getVrPensionPropuesto(): int
    {
        return $this->vrPensionPropuesto;
    }

    /**
     * @param int $vrPensionPropuesto
     */
    public function setVrPensionPropuesto(int $vrPensionPropuesto): void
    {
        $this->vrPensionPropuesto = $vrPensionPropuesto;
    }

    /**
     * @return int
     */
    public function getDiasAusentismoPropuesto(): int
    {
        return $this->diasAusentismoPropuesto;
    }

    /**
     * @param int $diasAusentismoPropuesto
     */
    public function setDiasAusentismoPropuesto(int $diasAusentismoPropuesto): void
    {
        $this->diasAusentismoPropuesto = $diasAusentismoPropuesto;
    }

    /**
     * @return int
     */
    public function getVrBruto(): int
    {
        return $this->vrBruto;
    }

    /**
     * @param int $vrBruto
     */
    public function setVrBruto(int $vrBruto): void
    {
        $this->vrBruto = $vrBruto;
    }

    /**
     * @return bool
     */
    public function isEstadoPagoGenerado(): bool
    {
        return $this->estadoPagoGenerado;
    }

    /**
     * @param bool $estadoPagoGenerado
     */
    public function setEstadoPagoGenerado(bool $estadoPagoGenerado): void
    {
        $this->estadoPagoGenerado = $estadoPagoGenerado;
    }

    /**
     * @return bool
     */
    public function isEstadoPagoBanco(): bool
    {
        return $this->estadoPagoBanco;
    }

    /**
     * @param bool $estadoPagoBanco
     */
    public function setEstadoPagoBanco(bool $estadoPagoBanco): void
    {
        $this->estadoPagoBanco = $estadoPagoBanco;
    }

    /**
     * @return bool
     */
    public function isEstadoContabilizado(): bool
    {
        return $this->estadoContabilizado;
    }

    /**
     * @param bool $estadoContabilizado
     */
    public function setEstadoContabilizado(bool $estadoContabilizado): void
    {
        $this->estadoContabilizado = $estadoContabilizado;
    }

    /**
     * @return bool
     */
    public function isEstadoAutorizado(): bool
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
    public function isEstadoAprobado(): bool
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
    public function isEstadoAnulado(): bool
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
     * @return bool
     */
    public function isEstadoPagado(): bool
    {
        return $this->estadoPagado;
    }

    /**
     * @param bool $estadoPagado
     */
    public function setEstadoPagado(bool $estadoPagado): void
    {
        $this->estadoPagado = $estadoPagado;
    }

    /**
     * @return bool
     */
    public function isEstadoLiquidado(): bool
    {
        return $this->estadoLiquidado;
    }

    /**
     * @param bool $estadoLiquidado
     */
    public function setEstadoLiquidado(bool $estadoLiquidado): void
    {
        $this->estadoLiquidado = $estadoLiquidado;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return int
     */
    public function getVrRecargoNocturnoInicial(): int
    {
        return $this->vrRecargoNocturnoInicial;
    }

    /**
     * @param int $vrRecargoNocturnoInicial
     */
    public function setVrRecargoNocturnoInicial(int $vrRecargoNocturnoInicial): void
    {
        $this->vrRecargoNocturnoInicial = $vrRecargoNocturnoInicial;
    }

    /**
     * @return int
     */
    public function getVrRecargoNocturno(): int
    {
        return $this->vrRecargoNocturno;
    }

    /**
     * @param int $vrRecargoNocturno
     */
    public function setVrRecargoNocturno(int $vrRecargoNocturno): void
    {
        $this->vrRecargoNocturno = $vrRecargoNocturno;
    }

    /**
     * @return int
     */
    public function getVrPromedioRecargoNocturno(): int
    {
        return $this->vrPromedioRecargoNocturno;
    }

    /**
     * @param int $vrPromedioRecargoNocturno
     */
    public function setVrPromedioRecargoNocturno(int $vrPromedioRecargoNocturno): void
    {
        $this->vrPromedioRecargoNocturno = $vrPromedioRecargoNocturno;
    }

    /**
     * @return int
     */
    public function getVrIbcPromedio(): int
    {
        return $this->vrIbcPromedio;
    }

    /**
     * @param int $vrIbcPromedio
     */
    public function setVrIbcPromedio(int $vrIbcPromedio): void
    {
        $this->vrIbcPromedio = $vrIbcPromedio;
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

}
