<?php

namespace App\Entity\Compra;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Compra\ComEgresoDetalleRepository")
 */
class ComEgresoDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_egreso_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */        
    private $codigoEgresoDetallePk;

    /**
     * @ORM\Column(name="codigo_egreso_fk", type="integer", nullable=true)
     */
    private $codigoEgresoFk;

    /**
     * @ORM\Column(name="codigo_cuenta_pagar_fk", type="integer", nullable=true)
     */
    private $codigoCuentaPagarFk;

    /**
     * @ORM\Column(name="codigo_cuenta_pagar_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCuentaPagarTipoFk;

    /**
     * @ORM\Column(name="numero_compra", type="string", length=30, nullable=true)
     */
    private $numeroCompra;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Compra\ComEgreso", inversedBy="egresosDetallesEgresoRel")
     * @ORM\JoinColumn(name="codigo_egreso_fk", referencedColumnName="codigo_egreso_pk")
     */
    protected $egresoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compra\ComCuentaPagar", inversedBy="egresosDetallesCuentaPagarRel")
     * @ORM\JoinColumn(name="codigo_cuenta_pagar_fk", referencedColumnName="codigo_cuenta_pagar_pk")
     */
    protected $cuentaPagarRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compra\ComCuentaPagarTipo", inversedBy="egresosDetallesCuentaPagarTipoRel")
     * @ORM\JoinColumn(name="codigo_cuenta_pagar_tipo_fk", referencedColumnName="codigo_cuenta_pagar_tipo_pk")
     */
    protected $cuentaPagarTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoEgresoDetallePk()
    {
        return $this->codigoEgresoDetallePk;
    }

    /**
     * @param mixed $codigoEgresoDetallePk
     */
    public function setCodigoEgresoDetallePk($codigoEgresoDetallePk): void
    {
        $this->codigoEgresoDetallePk = $codigoEgresoDetallePk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEgresoFk()
    {
        return $this->codigoEgresoFk;
    }

    /**
     * @param mixed $codigoEgresoFk
     */
    public function setCodigoEgresoFk($codigoEgresoFk): void
    {
        $this->codigoEgresoFk = $codigoEgresoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaPagarFk()
    {
        return $this->codigoCuentaPagarFk;
    }

    /**
     * @param mixed $codigoCuentaPagarFk
     */
    public function setCodigoCuentaPagarFk($codigoCuentaPagarFk): void
    {
        $this->codigoCuentaPagarFk = $codigoCuentaPagarFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaPagarTipoFk()
    {
        return $this->codigoCuentaPagarTipoFk;
    }

    /**
     * @param mixed $codigoCuentaPagarTipoFk
     */
    public function setCodigoCuentaPagarTipoFk($codigoCuentaPagarTipoFk): void
    {
        $this->codigoCuentaPagarTipoFk = $codigoCuentaPagarTipoFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroCompra()
    {
        return $this->numeroCompra;
    }

    /**
     * @param mixed $numeroCompra
     */
    public function setNumeroCompra($numeroCompra): void
    {
        $this->numeroCompra = $numeroCompra;
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
    public function getEgresoRel()
    {
        return $this->egresoRel;
    }

    /**
     * @param mixed $egresoRel
     */
    public function setEgresoRel($egresoRel): void
    {
        $this->egresoRel = $egresoRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaPagarRel()
    {
        return $this->cuentaPagarRel;
    }

    /**
     * @param mixed $cuentaPagarRel
     */
    public function setCuentaPagarRel($cuentaPagarRel): void
    {
        $this->cuentaPagarRel = $cuentaPagarRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaPagarTipoRel()
    {
        return $this->cuentaPagarTipoRel;
    }

    /**
     * @param mixed $cuentaPagarTipoRel
     */
    public function setCuentaPagarTipoRel($cuentaPagarTipoRel): void
    {
        $this->cuentaPagarTipoRel = $cuentaPagarTipoRel;
    }



}
