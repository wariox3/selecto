<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuCredito
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuCreditoRepository")
 */
class RhuCredito
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_credito_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCreditoPk;

    /**
     * @ORM\Column(name="codigo_credito_tipo_fk", type="string",length=10, nullable=true)
     */
    private $codigoCreditoTipoFk;

    /**
     * @ORM\Column(name="codigo_credito_pago_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCreditoPagoTipoFk;

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
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fechaInicio;

    /**
     * @ORM\Column(name="fecha_finalizacion", type="date", nullable=true)
     */
    private $fechaFinalizacion;

    /**
     * @ORM\Column(name="fecha_credito", type="date", nullable=true)
     */
    private $fechaCredito;

    /**
     * @ORM\Column(name="vr_credito",options={"default": 0}, type="float")
     */
    private $vrCredito = 0;

    /**
     * @ORM\Column(name="vr_cuota",options={"default": 0}, type="float")
     */
    private $vrCuota = 0;

    /**
     * @ORM\Column(name="vr_abonos",options={"default": 0}, type="float")
     */
    private $vrAbonos = 0;

    /**
     * @ORM\Column(name="vr_saldo",options={"default": 0}, type="float")
     */
    private $vrSaldo = 0;

    /**
     * @ORM\Column(name="numero_cuotas",options={"default": 0}, type="integer", nullable=true)
     */
    private $numeroCuotas = 0;

    /**
     * @ORM\Column(name="numero_cuota_actual",options={"default": 0}, type="integer")
     */
    private $numeroCuotaActual = 0;

    /**
     * @ORM\Column(name="numero_libranza", type="string", length=50, nullable=true)
     */
    private $numeroLibranza;

    /**
     * @ORM\Column(name="comentario", type="string", length=200, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="estado_suspendido",options={"default": false}, type="boolean", nullable=true)
     */
    private $estadoSuspendido = false;

    /**
     * @ORM\Column(name="inactivo_periodo",options={"default": false}, type="boolean", nullable=true)
     */
    private $inactivoPeriodo = false;

    /**
     * @ORM\Column(name="estado_pagado",options={"default": false}, type="boolean", nullable=true)
     */
    private $estadoPagado = false;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAnulado = false;

    /**
     * @ORM\Column(name="usuario", type="string", length=50, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="validar_cuotas",options={"default": false}, type="boolean")
     */
    private $validarCuotas = false;

    /**
     * @ORM\Column(name="aplicar_cuota_prima",options={"default": false}, type="boolean")
     */
    private $aplicarCuotaPrima = false;

    /**
     * @ORM\Column(name="aplicar_cuota_cesantia",options={"default": false}, type="boolean")
     */
    private $aplicarCuotaCesantia = false;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCreditoTipo", inversedBy="creditosCreditoTipoRel")
     * @ORM\JoinColumn(name="codigo_credito_tipo_fk", referencedColumnName="codigo_credito_tipo_pk")
     */
    protected $creditoTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="creditosEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk", referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContrato", inversedBy="creditosContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    protected $contratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuGrupo", inversedBy="creditosGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    protected $grupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCreditoPagoTipo", inversedBy="creditosCreditoPagoTipoRel")
     * @ORM\JoinColumn(name="codigo_credito_pago_tipo_fk", referencedColumnName="codigo_credito_pago_tipo_pk")
     */
    protected $creditoPagoTipoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuCreditoPago", mappedBy="creditoRel")
     */
    protected $creditosPagosCreditoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuPagoDetalle", mappedBy="creditoRel")
     */
    protected $pagosDetallesCreditoRel;

    /**
     * @return mixed
     */
    public function getCodigoCreditoPk()
    {
        return $this->codigoCreditoPk;
    }

    /**
     * @param mixed $codigoCreditoPk
     */
    public function setCodigoCreditoPk($codigoCreditoPk): void
    {
        $this->codigoCreditoPk = $codigoCreditoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCreditoTipoFk()
    {
        return $this->codigoCreditoTipoFk;
    }

    /**
     * @param mixed $codigoCreditoTipoFk
     */
    public function setCodigoCreditoTipoFk($codigoCreditoTipoFk): void
    {
        $this->codigoCreditoTipoFk = $codigoCreditoTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCreditoPagoTipoFk()
    {
        return $this->codigoCreditoPagoTipoFk;
    }

    /**
     * @param mixed $codigoCreditoPagoTipoFk
     */
    public function setCodigoCreditoPagoTipoFk($codigoCreditoPagoTipoFk): void
    {
        $this->codigoCreditoPagoTipoFk = $codigoCreditoPagoTipoFk;
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
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $fechaInicio
     */
    public function setFechaInicio($fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return mixed
     */
    public function getFechaFinalizacion()
    {
        return $this->fechaFinalizacion;
    }

    /**
     * @param mixed $fechaFinalizacion
     */
    public function setFechaFinalizacion($fechaFinalizacion): void
    {
        $this->fechaFinalizacion = $fechaFinalizacion;
    }

    /**
     * @return mixed
     */
    public function getFechaCredito()
    {
        return $this->fechaCredito;
    }

    /**
     * @param mixed $fechaCredito
     */
    public function setFechaCredito($fechaCredito): void
    {
        $this->fechaCredito = $fechaCredito;
    }

    /**
     * @return int
     */
    public function getVrCredito(): int
    {
        return $this->vrCredito;
    }

    /**
     * @param int $vrCredito
     */
    public function setVrCredito(int $vrCredito): void
    {
        $this->vrCredito = $vrCredito;
    }

    /**
     * @return int
     */
    public function getVrCuota(): int
    {
        return $this->vrCuota;
    }

    /**
     * @param int $vrCuota
     */
    public function setVrCuota(int $vrCuota): void
    {
        $this->vrCuota = $vrCuota;
    }

    /**
     * @return int
     */
    public function getVrAbonos(): int
    {
        return $this->vrAbonos;
    }

    /**
     * @param int $vrAbonos
     */
    public function setVrAbonos(int $vrAbonos): void
    {
        $this->vrAbonos = $vrAbonos;
    }

    /**
     * @return int
     */
    public function getVrSaldo(): int
    {
        return $this->vrSaldo;
    }

    /**
     * @param int $vrSaldo
     */
    public function setVrSaldo(int $vrSaldo): void
    {
        $this->vrSaldo = $vrSaldo;
    }

    /**
     * @return int
     */
    public function getNumeroCuotas(): int
    {
        return $this->numeroCuotas;
    }

    /**
     * @param int $numeroCuotas
     */
    public function setNumeroCuotas(int $numeroCuotas): void
    {
        $this->numeroCuotas = $numeroCuotas;
    }

    /**
     * @return int
     */
    public function getNumeroCuotaActual(): int
    {
        return $this->numeroCuotaActual;
    }

    /**
     * @param int $numeroCuotaActual
     */
    public function setNumeroCuotaActual(int $numeroCuotaActual): void
    {
        $this->numeroCuotaActual = $numeroCuotaActual;
    }

    /**
     * @return mixed
     */
    public function getNumeroLibranza()
    {
        return $this->numeroLibranza;
    }

    /**
     * @param mixed $numeroLibranza
     */
    public function setNumeroLibranza($numeroLibranza): void
    {
        $this->numeroLibranza = $numeroLibranza;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return bool
     */
    public function getEstadoSuspendido(): bool
    {
        return $this->estadoSuspendido;
    }

    /**
     * @param bool $estadoSuspendido
     */
    public function setEstadoSuspendido(bool $estadoSuspendido): void
    {
        $this->estadoSuspendido = $estadoSuspendido;
    }

    /**
     * @return bool
     */
    public function isInactivoPeriodo(): bool
    {
        return $this->inactivoPeriodo;
    }

    /**
     * @param bool $inactivoPeriodo
     */
    public function setInactivoPeriodo(bool $inactivoPeriodo): void
    {
        $this->inactivoPeriodo = $inactivoPeriodo;
    }

    /**
     * @return bool
     */
    public function getEstadoPagado(): bool
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
     * @return bool
     */
    public function isValidarCuotas(): bool
    {
        return $this->validarCuotas;
    }

    /**
     * @param bool $validarCuotas
     */
    public function setValidarCuotas(bool $validarCuotas): void
    {
        $this->validarCuotas = $validarCuotas;
    }

    /**
     * @return bool
     */
    public function isAplicarCuotaPrima(): bool
    {
        return $this->aplicarCuotaPrima;
    }

    /**
     * @param bool $aplicarCuotaPrima
     */
    public function setAplicarCuotaPrima(bool $aplicarCuotaPrima): void
    {
        $this->aplicarCuotaPrima = $aplicarCuotaPrima;
    }

    /**
     * @return bool
     */
    public function isAplicarCuotaCesantia(): bool
    {
        return $this->aplicarCuotaCesantia;
    }

    /**
     * @param bool $aplicarCuotaCesantia
     */
    public function setAplicarCuotaCesantia(bool $aplicarCuotaCesantia): void
    {
        $this->aplicarCuotaCesantia = $aplicarCuotaCesantia;
    }

    /**
     * @return mixed
     */
    public function getCreditoTipoRel()
    {
        return $this->creditoTipoRel;
    }

    /**
     * @param mixed $creditoTipoRel
     */
    public function setCreditoTipoRel($creditoTipoRel): void
    {
        $this->creditoTipoRel = $creditoTipoRel;
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
    public function getCreditoPagoTipoRel()
    {
        return $this->creditoPagoTipoRel;
    }

    /**
     * @param mixed $creditoPagoTipoRel
     */
    public function setCreditoPagoTipoRel($creditoPagoTipoRel): void
    {
        $this->creditoPagoTipoRel = $creditoPagoTipoRel;
    }

    /**
     * @return mixed
     */
    public function getCreditosPagosCreditoRel()
    {
        return $this->creditosPagosCreditoRel;
    }

    /**
     * @param mixed $creditosPagosCreditoRel
     */
    public function setCreditosPagosCreditoRel($creditosPagosCreditoRel): void
    {
        $this->creditosPagosCreditoRel = $creditosPagosCreditoRel;
    }

    /**
     * @return mixed
     */
    public function getPagosDetallesCreditoRel()
    {
        return $this->pagosDetallesCreditoRel;
    }

    /**
     * @param mixed $pagosDetallesCreditoRel
     */
    public function setPagosDetallesCreditoRel($pagosDetallesCreditoRel): void
    {
        $this->pagosDetallesCreditoRel = $pagosDetallesCreditoRel;
    }

}
