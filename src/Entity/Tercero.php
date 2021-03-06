<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TerceroRepository")
 */
class Tercero
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_tercero_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoTerceroPk;

    /**
     * @ORM\Column(name="codigo_identificacion_fk", type="string", length=3, nullable=true)
     */
    private $codigoIdentificacionFk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=80)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_forma_pago_fk", type="string", length=3, nullable=true)
     */
    private $codigoFormaPagoFk;

    /**
     * @ORM\Column(name="barrio", type="string", length=80,nullable=true)
     */
    private $barrio;

    /**
     * @ORM\Column(name="codigo_postal", type="string", length=20, nullable=true)
     */
    private $codigoPostal;

    /**
     * @ORM\Column(name="autoretenedor", type="boolean", nullable=true, options={"default":false})
     */
    private $autoretenedor = false;


    /**
     * @ORM\Column(name="bloqueo_cartera", type="boolean", nullable=true, options={"default" : false})
     */
    private $bloqueoCartera = false;

    /**
     * @ORM\Column(name="codigo_precio_venta_fk", type="integer", nullable=true)
     */
    private $codigoPrecioVentaFk;

    /**
     * @ORM\Column(name="codigo_precio_compra_fk", type="integer", nullable=true)
     */
    private $codigoPrecioCompraFk;

    /**
     * @ORM\Column(name="cupo_compra", type="float", nullable=true, options={"default" : 0})
     */
    private $cupoCompra = 0;

    /**
     * @ORM\Column(name="codigo_tipo_persona_fk", type="string", length=3, nullable=true)
     */
    private $codigoTipoPersonaFk;

    /**
     * @ORM\Column(name="codigo_regimen_fk", type="string", length=3, nullable=true)
     */
    private $codigoRegimenFk;

    /**
     * @ORM\Column(name="codigo_ciuu", type="string", length=20, nullable=true)
     */
    private $codigoCIUU;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=150, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="primer_nombre", type="string", length=50, nullable=true)
     */
    private $primerNombre;

    /**
     * @ORM\Column(name="segundo_nombre", type="string", length=50, nullable=true)
     */
    private $segundoNombre;

    /**
     * @ORM\Column(name="primer_apellido", type="string", length=50, nullable=true)
     */
    private $primerApellido;

    /**
     * @ORM\Column(name="segundo_apellido", type="string", length=50, nullable=true)
     */
    private $segundoApellido;

    /**
     * @ORM\Column(name="direccion", type="string", length=80,nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=20,nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="celular", type="string", length=20, nullable=true)
     */
    private $celular;

    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=1, nullable=true)
     */
    private $digitoVerificacion;

    /**
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(name="correo_factura_electronica", type="string", length=500, nullable=true)
     */
    private $correoFacturaElectronica;

    /**
     * @ORM\Column(name="plazo_pago", type="integer")
     */
    private $plazoPago = 0;

    /**
     * @ORM\Column(name="cliente", type="boolean", nullable=true, options={"default" : false})
     */
    private $cliente = false;

    /**
     * @ORM\Column(name="proveedor", type="boolean", nullable=true, options={"default" : false})
     */
    private $proveedor = false;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="retencion_iva", type="boolean", options={"default":false})
     */
    private $retencionIva = false;

    /**
     * @ORM\Column(name="retencion_fuente", type="boolean", options={"default":false})
     */
    private $retencionFuente = false;

    /**
     * @ORM\Column(name="retencion_fuente_sin_base", type="boolean", options={"default":false})
     */
    private $retencionFuenteSinBase = false;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Identificacion", inversedBy="tercerosIdentificacionRel")
     * @ORM\JoinColumn(name="codigo_identificacion_fk", referencedColumnName="codigo_identificacion_pk")
     */
    private $identificacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoPersona", inversedBy="tercerosTipoPersonaRel")
     * @ORM\JoinColumn(name="codigo_tipo_persona_fk", referencedColumnName="codigo_tipo_persona_pk")
     */
    private $tipoPersonaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Regimen", inversedBy="tercerosRegimenRel")
     * @ORM\JoinColumn(name="codigo_regimen_fk", referencedColumnName="codigo_regimen_pk")
     */
    private $regimenRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudad", inversedBy="ciudadTerceroRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FormaPago", inversedBy="tercerosFormaPagoRel")
     * @ORM\JoinColumn(name="codigo_forma_pago_fk", referencedColumnName="codigo_forma_pago_pk")
     */
    protected $formaPagoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="terceroRel")
     */
    protected $movimientosTerceroRel;

    /**
     * @return mixed
     */
    public function getCodigoTerceroPk()
    {
        return $this->codigoTerceroPk;
    }

    /**
     * @param mixed $codigoTerceroPk
     */
    public function setCodigoTerceroPk($codigoTerceroPk): void
    {
        $this->codigoTerceroPk = $codigoTerceroPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionFk()
    {
        return $this->codigoIdentificacionFk;
    }

    /**
     * @param mixed $codigoIdentificacionFk
     */
    public function setCodigoIdentificacionFk($codigoIdentificacionFk): void
    {
        $this->codigoIdentificacionFk = $codigoIdentificacionFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoFormaPagoFk()
    {
        return $this->codigoFormaPagoFk;
    }

    /**
     * @param mixed $codigoFormaPagoFk
     */
    public function setCodigoFormaPagoFk($codigoFormaPagoFk): void
    {
        $this->codigoFormaPagoFk = $codigoFormaPagoFk;
    }

    /**
     * @return mixed
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * @param mixed $barrio
     */
    public function setBarrio($barrio): void
    {
        $this->barrio = $barrio;
    }

    /**
     * @return mixed
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * @param mixed $codigoPostal
     */
    public function setCodigoPostal($codigoPostal): void
    {
        $this->codigoPostal = $codigoPostal;
    }

    /**
     * @return bool
     */
    public function isAutoretenedor(): bool
    {
        return $this->autoretenedor;
    }

    /**
     * @param bool $autoretenedor
     */
    public function setAutoretenedor(bool $autoretenedor): void
    {
        $this->autoretenedor = $autoretenedor;
    }

    /**
     * @return bool
     */
    public function isBloqueoCartera(): bool
    {
        return $this->bloqueoCartera;
    }

    /**
     * @param bool $bloqueoCartera
     */
    public function setBloqueoCartera(bool $bloqueoCartera): void
    {
        $this->bloqueoCartera = $bloqueoCartera;
    }

    /**
     * @return mixed
     */
    public function getCodigoPrecioVentaFk()
    {
        return $this->codigoPrecioVentaFk;
    }

    /**
     * @param mixed $codigoPrecioVentaFk
     */
    public function setCodigoPrecioVentaFk($codigoPrecioVentaFk): void
    {
        $this->codigoPrecioVentaFk = $codigoPrecioVentaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPrecioCompraFk()
    {
        return $this->codigoPrecioCompraFk;
    }

    /**
     * @param mixed $codigoPrecioCompraFk
     */
    public function setCodigoPrecioCompraFk($codigoPrecioCompraFk): void
    {
        $this->codigoPrecioCompraFk = $codigoPrecioCompraFk;
    }

    /**
     * @return int
     */
    public function getCupoCompra(): int
    {
        return $this->cupoCompra;
    }

    /**
     * @param int $cupoCompra
     */
    public function setCupoCompra(int $cupoCompra): void
    {
        $this->cupoCompra = $cupoCompra;
    }

    /**
     * @return mixed
     */
    public function getCodigoTipoPersonaFk()
    {
        return $this->codigoTipoPersonaFk;
    }

    /**
     * @param mixed $codigoTipoPersonaFk
     */
    public function setCodigoTipoPersonaFk($codigoTipoPersonaFk): void
    {
        $this->codigoTipoPersonaFk = $codigoTipoPersonaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoRegimenFk()
    {
        return $this->codigoRegimenFk;
    }

    /**
     * @param mixed $codigoRegimenFk
     */
    public function setCodigoRegimenFk($codigoRegimenFk): void
    {
        $this->codigoRegimenFk = $codigoRegimenFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCIUU()
    {
        return $this->codigoCIUU;
    }

    /**
     * @param mixed $codigoCIUU
     */
    public function setCodigoCIUU($codigoCIUU): void
    {
        $this->codigoCIUU = $codigoCIUU;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    /**
     * @param mixed $primerNombre
     */
    public function setPrimerNombre($primerNombre): void
    {
        $this->primerNombre = $primerNombre;
    }

    /**
     * @return mixed
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     * @param mixed $segundoNombre
     */
    public function setSegundoNombre($segundoNombre): void
    {
        $this->segundoNombre = $segundoNombre;
    }

    /**
     * @return mixed
     */
    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    /**
     * @param mixed $primerApellido
     */
    public function setPrimerApellido($primerApellido): void
    {
        $this->primerApellido = $primerApellido;
    }

    /**
     * @return mixed
     */
    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    /**
     * @param mixed $segundoApellido
     */
    public function setSegundoApellido($segundoApellido): void
    {
        $this->segundoApellido = $segundoApellido;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular): void
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificacion()
    {
        return $this->digitoVerificacion;
    }

    /**
     * @param mixed $digitoVerificacion
     */
    public function setDigitoVerificacion($digitoVerificacion): void
    {
        $this->digitoVerificacion = $digitoVerificacion;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCorreoFacturaElectronica()
    {
        return $this->correoFacturaElectronica;
    }

    /**
     * @param mixed $correoFacturaElectronica
     */
    public function setCorreoFacturaElectronica($correoFacturaElectronica): void
    {
        $this->correoFacturaElectronica = $correoFacturaElectronica;
    }

    /**
     * @return int
     */
    public function getPlazoPago(): int
    {
        return $this->plazoPago;
    }

    /**
     * @param int $plazoPago
     */
    public function setPlazoPago(int $plazoPago): void
    {
        $this->plazoPago = $plazoPago;
    }

    /**
     * @return bool
     */
    public function getCliente(): bool
    {
        return $this->cliente;
    }

    /**
     * @param bool $cliente
     */
    public function setCliente(bool $cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return bool
     */
    public function getProveedor(): bool
    {
        return $this->proveedor;
    }

    /**
     * @param bool $proveedor
     */
    public function setProveedor(bool $proveedor): void
    {
        $this->proveedor = $proveedor;
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
     * @return bool
     */
    public function isRetencionIva(): bool
    {
        return $this->retencionIva;
    }

    /**
     * @param bool $retencionIva
     */
    public function setRetencionIva(bool $retencionIva): void
    {
        $this->retencionIva = $retencionIva;
    }

    /**
     * @return bool
     */
    public function isRetencionFuente(): bool
    {
        return $this->retencionFuente;
    }

    /**
     * @param bool $retencionFuente
     */
    public function setRetencionFuente(bool $retencionFuente): void
    {
        $this->retencionFuente = $retencionFuente;
    }

    /**
     * @return bool
     */
    public function isRetencionFuenteSinBase(): bool
    {
        return $this->retencionFuenteSinBase;
    }

    /**
     * @param bool $retencionFuenteSinBase
     */
    public function setRetencionFuenteSinBase(bool $retencionFuenteSinBase): void
    {
        $this->retencionFuenteSinBase = $retencionFuenteSinBase;
    }

    /**
     * @return mixed
     */
    public function getIdentificacionRel()
    {
        return $this->identificacionRel;
    }

    /**
     * @param mixed $identificacionRel
     */
    public function setIdentificacionRel($identificacionRel): void
    {
        $this->identificacionRel = $identificacionRel;
    }

    /**
     * @return mixed
     */
    public function getTipoPersonaRel()
    {
        return $this->tipoPersonaRel;
    }

    /**
     * @param mixed $tipoPersonaRel
     */
    public function setTipoPersonaRel($tipoPersonaRel): void
    {
        $this->tipoPersonaRel = $tipoPersonaRel;
    }

    /**
     * @return mixed
     */
    public function getRegimenRel()
    {
        return $this->regimenRel;
    }

    /**
     * @param mixed $regimenRel
     */
    public function setRegimenRel($regimenRel): void
    {
        $this->regimenRel = $regimenRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getFormaPagoRel()
    {
        return $this->formaPagoRel;
    }

    /**
     * @param mixed $formaPagoRel
     */
    public function setFormaPagoRel($formaPagoRel): void
    {
        $this->formaPagoRel = $formaPagoRel;
    }

    /**
     * @return mixed
     */
    public function getMovimientosTerceroRel()
    {
        return $this->movimientosTerceroRel;
    }

    /**
     * @param mixed $movimientosTerceroRel
     */
    public function setMovimientosTerceroRel($movimientosTerceroRel): void
    {
        $this->movimientosTerceroRel = $movimientosTerceroRel;
    }



}
