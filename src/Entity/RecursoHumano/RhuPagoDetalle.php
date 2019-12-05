<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuPagoDetalle
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuPagoDetalleRepository")
 */
class RhuPagoDetalle
{
    public $infoLog = [
        "primaryKey" => "codigoPagoDetallePk",
        "todos"     => true,
    ];
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_pago_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPagoDetallePk;

    /**
     * @ORM\Column(name="codigo_pago_fk", type="integer", nullable=true)
     */
    private $codigoPagoFk;

    /**
     * @ORM\Column(name="codigo_concepto_fk", type="string", length=10, nullable=true)
     */
    private $codigoConceptoFk;

    /**
     * @ORM\Column(name="codigo_credito_fk", type="integer", nullable=true)
     */
    private $codigoCreditoFk;

    /**
     * @ORM\Column(name="vr_pago", type="float", nullable=true)
     */
    private $vrPago = 0;

    /**
     * @ORM\Column(name="operacion", type="integer")
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="vr_pago_operado", type="float")
     */
    private $vrPagoOperado = 0;

    /**
     * @ORM\Column(name="horas", type="float")
     */
    private $horas = 0;

    /**
     * @ORM\Column(name="vr_hora", type="float")
     */
    private $vrHora = 0;

    /**
     * @ORM\Column(name="porcentaje", type="float")
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="dias", type="integer")
     */
    private $dias = 0;

    /**
     * @ORM\Column(name="detalle", type="string", length=250, nullable=true)
     */
    private $detalle;

    /**
     * @ORM\Column(name="vr_deduccion",options={"default":0}, type="float", nullable=true)
     */
    private $vrDeduccion = 0;

    /**
     * @ORM\Column(name="vr_devengado",options={"default":0}, type="float", nullable=true)
     */
    private $vrDevengado = 0;

    /**
     * @ORM\Column(name="vr_ingreso_base_cotizacion", type="float")
     */
    private $vrIngresoBaseCotizacion = 0;

    /**
     * @ORM\Column(name="vr_ingreso_base_prestacion", type="float")
     */
    private $vrIngresoBasePrestacion = 0;

    /**
     * @ORM\ManyToOne(targetEntity="RhuPago", inversedBy="pagosDetallesPagoRel")
     * @ORM\JoinColumn(name="codigo_pago_fk", referencedColumnName="codigo_pago_pk")
     */
    protected $pagoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuConcepto", inversedBy="pagosDetallesConceptoRel")
     * @ORM\JoinColumn(name="codigo_concepto_fk", referencedColumnName="codigo_concepto_pk")
     */
    protected $conceptoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCredito", inversedBy="pagosDetallesCreditoRel")
     * @ORM\JoinColumn(name="codigo_credito_fk", referencedColumnName="codigo_credito_pk")
     */
    protected $creditoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuCreditoPago", mappedBy="pagoDetalleRel")
     */
    protected $creditosPagosPagoDetalleRel;

    /**
     * @return array
     */
    public function getInfoLog(): array
    {
        return $this->infoLog;
    }

    /**
     * @param array $infoLog
     */
    public function setInfoLog(array $infoLog): void
    {
        $this->infoLog = $infoLog;
    }

    /**
     * @return mixed
     */
    public function getCodigoPagoDetallePk()
    {
        return $this->codigoPagoDetallePk;
    }

    /**
     * @param mixed $codigoPagoDetallePk
     */
    public function setCodigoPagoDetallePk($codigoPagoDetallePk): void
    {
        $this->codigoPagoDetallePk = $codigoPagoDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPagoFk()
    {
        return $this->codigoPagoFk;
    }

    /**
     * @param mixed $codigoPagoFk
     */
    public function setCodigoPagoFk($codigoPagoFk): void
    {
        $this->codigoPagoFk = $codigoPagoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoFk()
    {
        return $this->codigoConceptoFk;
    }

    /**
     * @param mixed $codigoConceptoFk
     */
    public function setCodigoConceptoFk($codigoConceptoFk): void
    {
        $this->codigoConceptoFk = $codigoConceptoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCreditoFk()
    {
        return $this->codigoCreditoFk;
    }

    /**
     * @param mixed $codigoCreditoFk
     */
    public function setCodigoCreditoFk($codigoCreditoFk): void
    {
        $this->codigoCreditoFk = $codigoCreditoFk;
    }

    /**
     * @return int
     */
    public function getVrPago(): int
    {
        return $this->vrPago;
    }

    /**
     * @param int $vrPago
     */
    public function setVrPago(int $vrPago): void
    {
        $this->vrPago = $vrPago;
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
     * @return int
     */
    public function getVrPagoOperado(): int
    {
        return $this->vrPagoOperado;
    }

    /**
     * @param int $vrPagoOperado
     */
    public function setVrPagoOperado(int $vrPagoOperado): void
    {
        $this->vrPagoOperado = $vrPagoOperado;
    }

    /**
     * @return int
     */
    public function getHoras(): int
    {
        return $this->horas;
    }

    /**
     * @param int $horas
     */
    public function setHoras(int $horas): void
    {
        $this->horas = $horas;
    }

    /**
     * @return int
     */
    public function getVrHora(): int
    {
        return $this->vrHora;
    }

    /**
     * @param int $vrHora
     */
    public function setVrHora(int $vrHora): void
    {
        $this->vrHora = $vrHora;
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
     * @return mixed
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param mixed $detalle
     */
    public function setDetalle($detalle): void
    {
        $this->detalle = $detalle;
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
    public function getVrDevengado(): int
    {
        return $this->vrDevengado;
    }

    /**
     * @param int $vrDevengado
     */
    public function setVrDevengado(int $vrDevengado): void
    {
        $this->vrDevengado = $vrDevengado;
    }

    /**
     * @return int
     */
    public function getVrIngresoBaseCotizacion(): int
    {
        return $this->vrIngresoBaseCotizacion;
    }

    /**
     * @param int $vrIngresoBaseCotizacion
     */
    public function setVrIngresoBaseCotizacion(int $vrIngresoBaseCotizacion): void
    {
        $this->vrIngresoBaseCotizacion = $vrIngresoBaseCotizacion;
    }

    /**
     * @return int
     */
    public function getVrIngresoBasePrestacion(): int
    {
        return $this->vrIngresoBasePrestacion;
    }

    /**
     * @param int $vrIngresoBasePrestacion
     */
    public function setVrIngresoBasePrestacion(int $vrIngresoBasePrestacion): void
    {
        $this->vrIngresoBasePrestacion = $vrIngresoBasePrestacion;
    }

    /**
     * @return mixed
     */
    public function getPagoRel()
    {
        return $this->pagoRel;
    }

    /**
     * @param mixed $pagoRel
     */
    public function setPagoRel($pagoRel): void
    {
        $this->pagoRel = $pagoRel;
    }

    /**
     * @return mixed
     */
    public function getConceptoRel()
    {
        return $this->conceptoRel;
    }

    /**
     * @param mixed $conceptoRel
     */
    public function setConceptoRel($conceptoRel): void
    {
        $this->conceptoRel = $conceptoRel;
    }

    /**
     * @return mixed
     */
    public function getCreditoRel()
    {
        return $this->creditoRel;
    }

    /**
     * @param mixed $creditoRel
     */
    public function setCreditoRel($creditoRel): void
    {
        $this->creditoRel = $creditoRel;
    }

    /**
     * @return mixed
     */
    public function getCreditosPagosPagoDetalleRel()
    {
        return $this->creditosPagosPagoDetalleRel;
    }

    /**
     * @param mixed $creditosPagosPagoDetalleRel
     */
    public function setCreditosPagosPagoDetalleRel($creditosPagosPagoDetalleRel): void
    {
        $this->creditosPagosPagoDetalleRel = $creditosPagosPagoDetalleRel;
    }

}
