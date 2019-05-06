<?php

namespace App\Entity\Cartera;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="recibo_detalle")
 * @ORM\Entity(repositoryClass="App\Repository\Cartera\CarReciboDetalleRepository")
 */
class CarReciboDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_recibo_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoReciboDetallePk;

    /**
     * @ORM\Column(name="codigo_recibo_fk", type="integer", nullable=true)
     */
    private $codigoReciboFk;

    /**
     * @ORM\Column(name="codigo_cuenta_cobrar_fk", type="integer", nullable=true)
     */
    private $codigoCuentaCobrarFk;

    /**
     * @ORM\Column(name="codigo_cuenta_cobrar_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCuentaCobrarTipoFk;

    /**
     * @ORM\Column(name="numero_factura", type="string", length=30, nullable=true)
     */
    private $numeroFactura;

    /**
     * @ORM\Column(name="vr_pago", type="float", nullable=true)
     */
    private $vrPago = 0;

    /**
     * @ORM\Column(name="vr_pago_afectar", type="float", nullable=true)
     */
    private $vrPagoAfectar = 0;

    /**
     * @ORM\Column(name="usuario", type="string", length=50, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="operacion", type="integer")
     */
    private $operacion = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cartera\CarRecibo", inversedBy="recibosDetallesRecibosRel")
     * @ORM\JoinColumn(name="codigo_recibo_fk", referencedColumnName="codigo_recibo_pk")
     */
    protected $reciboRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cartera\CarCuentaCobrar", inversedBy="recibosDetallesCuentaCobrarRel")
     * @ORM\JoinColumn(name="codigo_cuenta_cobrar_fk", referencedColumnName="codigo_cuenta_cobrar_pk")
     */
    protected $cuentaCobrarRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cartera\CarCuentaCobrarTipo", inversedBy="recibosDetallesCuentaCobrarTipoRel")
     * @ORM\JoinColumn(name="codigo_cuenta_cobrar_tipo_fk", referencedColumnName="codigo_cuenta_cobrar_tipo_pk")
     */
    protected $cuentaCobrarTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoReciboDetallePk()
    {
        return $this->codigoReciboDetallePk;
    }

    /**
     * @param mixed $codigoReciboDetallePk
     */
    public function setCodigoReciboDetallePk($codigoReciboDetallePk): void
    {
        $this->codigoReciboDetallePk = $codigoReciboDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoReciboFk()
    {
        return $this->codigoReciboFk;
    }

    /**
     * @param mixed $codigoReciboFk
     */
    public function setCodigoReciboFk($codigoReciboFk): void
    {
        $this->codigoReciboFk = $codigoReciboFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaCobrarFk()
    {
        return $this->codigoCuentaCobrarFk;
    }

    /**
     * @param mixed $codigoCuentaCobrarFk
     */
    public function setCodigoCuentaCobrarFk($codigoCuentaCobrarFk): void
    {
        $this->codigoCuentaCobrarFk = $codigoCuentaCobrarFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaCobrarTipoFk()
    {
        return $this->codigoCuentaCobrarTipoFk;
    }

    /**
     * @param mixed $codigoCuentaCobrarTipoFk
     */
    public function setCodigoCuentaCobrarTipoFk($codigoCuentaCobrarTipoFk): void
    {
        $this->codigoCuentaCobrarTipoFk = $codigoCuentaCobrarTipoFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * @param mixed $numeroFactura
     */
    public function setNumeroFactura($numeroFactura): void
    {
        $this->numeroFactura = $numeroFactura;
    }

    /**
     * @return mixed
     */
    public function getVrPago()
    {
        return $this->vrPago;
    }

    /**
     * @param mixed $vrPago
     */
    public function setVrPago($vrPago): void
    {
        $this->vrPago = $vrPago;
    }

    /**
     * @return mixed
     */
    public function getVrPagoAfectar()
    {
        return $this->vrPagoAfectar;
    }

    /**
     * @param mixed $vrPagoAfectar
     */
    public function setVrPagoAfectar($vrPagoAfectar): void
    {
        $this->vrPagoAfectar = $vrPagoAfectar;
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
     * @return mixed
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * @param mixed $operacion
     */
    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }

    /**
     * @return mixed
     */
    public function getReciboRel()
    {
        return $this->reciboRel;
    }

    /**
     * @param mixed $reciboRel
     */
    public function setReciboRel($reciboRel): void
    {
        $this->reciboRel = $reciboRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaCobrarRel()
    {
        return $this->cuentaCobrarRel;
    }

    /**
     * @param mixed $cuentaCobrarRel
     */
    public function setCuentaCobrarRel($cuentaCobrarRel): void
    {
        $this->cuentaCobrarRel = $cuentaCobrarRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaCobrarTipoRel()
    {
        return $this->cuentaCobrarTipoRel;
    }

    /**
     * @param mixed $cuentaCobrarTipoRel
     */
    public function setCuentaCobrarTipoRel($cuentaCobrarTipoRel): void
    {
        $this->cuentaCobrarTipoRel = $cuentaCobrarTipoRel;
    }

}
