<?php


namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleado
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuEmpleadoRepository")
 */
class RhuEmpleado
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_empleado_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoEmpleadoPk;

    /**
     * @ORM\Column(name="codigo_identificacion_fk", type="string", length=3, nullable=true)
     */
    private $codigoIdentificacionFk;

    /**
     * @ORM\Column(name="codigo_empleado_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoEmpleadoTipoFk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="codigo_cuenta_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoCuentaTipoFk;

    /**
     * @ORM\Column(name="codigo_contrato_ultimo_fk", type="integer", nullable=true)
     */
    private $codigoContratoUltimoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=20 ,nullable=false)
     */
    private $numeroIdentificacion;



    /**
     * @ORM\Column(name="estado_contrato", type="boolean", nullable=false,options={"default":false})
     */
    private $estadoContrato = false;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=80, nullable=true)
     */
    private $nombreCorto; // contactener no 1,2 ap 1,2

    /**
     * @ORM\Column(name="nombre1", type="string", length=30, nullable=true)
     */
    private $nombre1;

    /**
     * @ORM\Column(name="nombre2", type="string", length=30, nullable=true)

     */
    private $nombre2;

    /**
     * @ORM\Column(name="apellido1", type="string", length=30, nullable=true)
     */
    private $apellido1;

    /**
     * @ORM\Column(name="apellido2", type="string", length=30, nullable=true)
     */
    private $apellido2;


    /**
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="celular", type="string", length=20, nullable=true)
     */
    private $celular;

    /**
     * @ORM\Column(name="direccion", type="string", length=120, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_ciudad_expedicion_identificacion_fk", type="integer", nullable=true)
     */
    private $codigoCiudadExpedicionIdentificacionFk;

    /**
     * @ORM\Column(name="fecha_expedicion_identificacion", type="date", nullable=true)
     */
    private $fechaExpedicionIdentificacion;

    /**
     * @ORM\Column(name="codigo_rh_fk", type="string", length=10, nullable=true)
     */
    private $codigoRhFk;

    /**
     * @ORM\Column(name="codigo_sexo_fk", type="string", length=1, nullable=true)
     */
    private $codigoSexoFk;

    /**
     * @ORM\Column(name="correo", type="string", length=80, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;
    /**
     * @ORM\Column(name="codigo_ciudad_nacimiento_fk", type="integer", nullable=true)
     */
    private $codigoCiudadNacimientoFk;

    /**
     * @ORM\Column(name="codigo_estado_civil_fk", type="string", length=1, nullable=true)
     */
    private $codigoEstadoCivilFk;

    /**
     * @ORM\Column(name="cuenta", type="string", length=80, nullable=true)
     */
    private $cuenta;

    /**
     * Tabla propia de bancos de recurso humano
     * @ORM\Column(name="codigo_banco_fk", type="string", length=10, nullable=true)
     */
    private $codigoBancoFk;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenIdentificacion", inversedBy="EmpleadosIdentificacionRel")
     * @ORM\JoinColumn(name="codigo_identificacion_fk",referencedColumnName="codigo_identificacion_pk")
     */
    protected $identificacionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="EmpleadosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="EmpleadosCiudadExpedicionRel")
     * @ORM\JoinColumn(name="codigo_ciudad_expedicion_identificacion_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadExpedicionRel;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="EmpleadosCiudadNacimientoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_nacimiento_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadNacimientoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenSexo", inversedBy="EmpleadosSexoRel")
     * @ORM\JoinColumn(name="codigo_sexo_fk",referencedColumnName="codigo_sexo_pk")
     */
    protected $sexoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenEstadoCivil", inversedBy="EmpleadosEstadoCivilRel")
     * @ORM\JoinColumn(name="codigo_estado_civil_fk",referencedColumnName="codigo_estado_civil_pk")
     */
    protected $estadoCivilRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCargo", inversedBy="empleadosCargoRel")
     * @ORM\JoinColumn(name="codigo_cargo_fk",referencedColumnName="codigo_cargo_pk")
     */
    protected $cargoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuRh", inversedBy="empleadosRhRel")
     * @ORM\JoinColumn(name="codigo_rh_fk",referencedColumnName="codigo_rh_pk")
     */
    protected $rhRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuBanco", inversedBy="empleadosBancoRel")
     * @ORM\JoinColumn(name="codigo_banco_fk",referencedColumnName="codigo_banco_pk")
     */
    protected $bancoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="empleadoRel")
     */
    protected $contratosEmpleadoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuAdicional", mappedBy="empleadoRel")
     */
    protected $adicionalesEmpleadoRel;

    /**
     * @return mixed
     */
    public function getCodigoEmpleadoPk()
    {
        return $this->codigoEmpleadoPk;
    }

    /**
     * @param mixed $codigoEmpleadoPk
     */
    public function setCodigoEmpleadoPk($codigoEmpleadoPk): void
    {
        $this->codigoEmpleadoPk = $codigoEmpleadoPk;
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
    public function getCodigoEmpleadoTipoFk()
    {
        return $this->codigoEmpleadoTipoFk;
    }

    /**
     * @param mixed $codigoEmpleadoTipoFk
     */
    public function setCodigoEmpleadoTipoFk($codigoEmpleadoTipoFk): void
    {
        $this->codigoEmpleadoTipoFk = $codigoEmpleadoTipoFk;
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
    public function getCodigoCuentaTipoFk()
    {
        return $this->codigoCuentaTipoFk;
    }

    /**
     * @param mixed $codigoCuentaTipoFk
     */
    public function setCodigoCuentaTipoFk($codigoCuentaTipoFk): void
    {
        $this->codigoCuentaTipoFk = $codigoCuentaTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoContratoUltimoFk()
    {
        return $this->codigoContratoUltimoFk;
    }

    /**
     * @param mixed $codigoContratoUltimoFk
     */
    public function setCodigoContratoUltimoFk($codigoContratoUltimoFk): void
    {
        $this->codigoContratoUltimoFk = $codigoContratoUltimoFk;
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
    public function getEstadoContrato()
    {
        return $this->estadoContrato;
    }

    /**
     * @param mixed $estadoContrato
     */
    public function setEstadoContrato($estadoContrato): void
    {
        $this->estadoContrato = $estadoContrato;
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
    public function getNombre1()
    {
        return $this->nombre1;
    }

    /**
     * @param mixed $nombre1
     */
    public function setNombre1($nombre1): void
    {
        $this->nombre1 = $nombre1;
    }

    /**
     * @return mixed
     */
    public function getNombre2()
    {
        return $this->nombre2;
    }

    /**
     * @param mixed $nombre2
     */
    public function setNombre2($nombre2): void
    {
        $this->nombre2 = $nombre2;
    }

    /**
     * @return mixed
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * @param mixed $apellido1
     */
    public function setApellido1($apellido1): void
    {
        $this->apellido1 = $apellido1;
    }

    /**
     * @return mixed
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * @param mixed $apellido2
     */
    public function setApellido2($apellido2): void
    {
        $this->apellido2 = $apellido2;
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
    public function getCodigoCiudadExpedicionIdentificacionFk()
    {
        return $this->codigoCiudadExpedicionIdentificacionFk;
    }

    /**
     * @param mixed $codigoCiudadExpedicionIdentificacionFk
     */
    public function setCodigoCiudadExpedicionIdentificacionFk($codigoCiudadExpedicionIdentificacionFk): void
    {
        $this->codigoCiudadExpedicionIdentificacionFk = $codigoCiudadExpedicionIdentificacionFk;
    }

    /**
     * @return mixed
     */
    public function getFechaExpedicionIdentificacion()
    {
        return $this->fechaExpedicionIdentificacion;
    }

    /**
     * @param mixed $fechaExpedicionIdentificacion
     */
    public function setFechaExpedicionIdentificacion($fechaExpedicionIdentificacion): void
    {
        $this->fechaExpedicionIdentificacion = $fechaExpedicionIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getCodigoRhFk()
    {
        return $this->codigoRhFk;
    }

    /**
     * @param mixed $codigoRhFk
     */
    public function setCodigoRhFk($codigoRhFk): void
    {
        $this->codigoRhFk = $codigoRhFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoSexoFk()
    {
        return $this->codigoSexoFk;
    }

    /**
     * @param mixed $codigoSexoFk
     */
    public function setCodigoSexoFk($codigoSexoFk): void
    {
        $this->codigoSexoFk = $codigoSexoFk;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @param mixed $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadNacimientoFk()
    {
        return $this->codigoCiudadNacimientoFk;
    }

    /**
     * @param mixed $codigoCiudadNacimientoFk
     */
    public function setCodigoCiudadNacimientoFk($codigoCiudadNacimientoFk): void
    {
        $this->codigoCiudadNacimientoFk = $codigoCiudadNacimientoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEstadoCivilFk()
    {
        return $this->codigoEstadoCivilFk;
    }

    /**
     * @param mixed $codigoEstadoCivilFk
     */
    public function setCodigoEstadoCivilFk($codigoEstadoCivilFk): void
    {
        $this->codigoEstadoCivilFk = $codigoEstadoCivilFk;
    }

    /**
     * @return mixed
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     */
    public function setCuenta($cuenta): void
    {
        $this->cuenta = $cuenta;
    }

    /**
     * @return mixed
     */
    public function getCodigoBancoFk()
    {
        return $this->codigoBancoFk;
    }

    /**
     * @param mixed $codigoBancoFk
     */
    public function setCodigoBancoFk($codigoBancoFk): void
    {
        $this->codigoBancoFk = $codigoBancoFk;
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
    public function getCiudadExpedicionRel()
    {
        return $this->ciudadExpedicionRel;
    }

    /**
     * @param mixed $ciudadExpedicionRel
     */
    public function setCiudadExpedicionRel($ciudadExpedicionRel): void
    {
        $this->ciudadExpedicionRel = $ciudadExpedicionRel;
    }

    /**
     * @return mixed
     */
    public function getCiudadNacimientoRel()
    {
        return $this->ciudadNacimientoRel;
    }

    /**
     * @param mixed $ciudadNacimientoRel
     */
    public function setCiudadNacimientoRel($ciudadNacimientoRel): void
    {
        $this->ciudadNacimientoRel = $ciudadNacimientoRel;
    }

    /**
     * @return mixed
     */
    public function getSexoRel()
    {
        return $this->sexoRel;
    }

    /**
     * @param mixed $sexoRel
     */
    public function setSexoRel($sexoRel): void
    {
        $this->sexoRel = $sexoRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoCivilRel()
    {
        return $this->estadoCivilRel;
    }

    /**
     * @param mixed $estadoCivilRel
     */
    public function setEstadoCivilRel($estadoCivilRel): void
    {
        $this->estadoCivilRel = $estadoCivilRel;
    }

    /**
     * @return mixed
     */
    public function getCargoRel()
    {
        return $this->cargoRel;
    }

    /**
     * @param mixed $cargoRel
     */
    public function setCargoRel($cargoRel): void
    {
        $this->cargoRel = $cargoRel;
    }

    /**
     * @return mixed
     */
    public function getRhRel()
    {
        return $this->rhRel;
    }

    /**
     * @param mixed $rhRel
     */
    public function setRhRel($rhRel): void
    {
        $this->rhRel = $rhRel;
    }

    /**
     * @return mixed
     */
    public function getBancoRel()
    {
        return $this->bancoRel;
    }

    /**
     * @param mixed $bancoRel
     */
    public function setBancoRel($bancoRel): void
    {
        $this->bancoRel = $bancoRel;
    }

    /**
     * @return mixed
     */
    public function getContratosEmpleadoRel()
    {
        return $this->contratosEmpleadoRel;
    }

    /**
     * @param mixed $contratosEmpleadoRel
     */
    public function setContratosEmpleadoRel($contratosEmpleadoRel): void
    {
        $this->contratosEmpleadoRel = $contratosEmpleadoRel;
    }

    /**
     * @return mixed
     */
    public function getAdicionalesEmpleadoRel()
    {
        return $this->adicionalesEmpleadoRel;
    }

    /**
     * @param mixed $adicionalesEmpleadoRel
     */
    public function setAdicionalesEmpleadoRel($adicionalesEmpleadoRel): void
    {
        $this->adicionalesEmpleadoRel = $adicionalesEmpleadoRel;
    }


}