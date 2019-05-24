<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenTerceroRepository")
 */
class GenTercero
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_tercero_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoTerceroPk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=80)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="codigo_identificacion_fk", type="string", length=3, nullable=true)
     */
    private $codigoIdentificacionFk;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_forma_pago_fk", type="integer", nullable=true)
     */
    private $codigoFormaPagoFk;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="ciudadTerceroRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenFormaPago", inversedBy="formaPagoTerceroRel")
     * @ORM\JoinColumn(name="codigo_forma_pago_fk", referencedColumnName="codigo_forma_pago_pk")
     */
    protected $formaPagoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvMovimiento", mappedBy="terceroRel")
     */
    protected $movimientosTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvContrato", mappedBy="terceroRel")
     */
    protected $contratosTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartera\CarCuentaCobrar", mappedBy="terceroRel")
     */
    private $cuentaCobroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cartera\CarRecibo", mappedBy="terceroRel")
     */
    private $carRecibosTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compra\ComCuentaPagar", mappedBy="terceroRel")
     */
    private $cuentaPagarRel;



}
