<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ErrorRepository")
 */
class Error
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_error_pk", type="integer", unique=true)
     */
    private $codigoErrorPk;

    /**
     * @var string
     * @ORM\Column(name="mensaje", type="text", nullable=true)
     */
    private $mensaje;

    /**
     * @var integer
     * @ORM\Column(name="codigo", type="integer", nullable=true)
     */
    private $codigo;

    /**
     * @var integer
     * @ORM\Column(name="linea", type="integer", nullable=true)
     */
    private $linea;

    /**
     * @var string
     * @ORM\Column(name="ruta", type="string", length=500, nullable=true)
     */
    private $ruta;

    /**
     * @var string
     * @ORM\Column(name="archivo", type="string", length=500, nullable=true)
     */
    private $archivo;

    /**
     * @var string
     * @ORM\Column(name="traza", type="text", nullable=true)
     */
    private $traza;

    /**
     * @var \DateTime
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="usuario", type="string", length=100, nullable=true)
     */
    private $usuario;

    /**
     * @var string
     * @ORM\Column(name="nombre_usuario", type="string", length=100, nullable=true)
     */
    private $nombreUsuario;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="cliente", type="string", length=100, nullable=true)
     */
    private $cliente;

    /**
     * @var bool
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true)
     */
    private $estadoAtendido = false;

    /**
     * @var bool
     * @ORM\Column(name="estado_solucionado", type="boolean", nullable=true)
     */
    private $estadoSolucionado  = false;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="erroresClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    protected $clienteRel;

    /**
     * @return mixed
     */
    public function getCodigoErrorPk()
    {
        return $this->codigoErrorPk;
    }

    /**
     * @param mixed $codigoErrorPk
     * @return Error
     */
    public function setCodigoErrorPk($codigoErrorPk)
    {
        $this->codigoErrorPk = $codigoErrorPk;
        return $this;
    }

    /**
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param string $mensaje
     * @return Error
     */
    public function setMensaje(string $mensaje)
    {
        $this->mensaje = $mensaje;
        return $this;
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     * @return Error
     */
    public function setCodigo(int $codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return int
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * @param int $linea
     * @return Error
     */
    public function setLinea(int $linea)
    {
        $this->linea = $linea;
        return $this;
    }

    /**
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * @param string $ruta
     * @return Error
     */
    public function setRuta(string $ruta)
    {
        $this->ruta = $ruta;
        return $this;
    }

    /**
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * @param string $archivo
     * @return Error
     */
    public function setArchivo(string $archivo)
    {
        $this->archivo = $archivo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraza()
    {
        return $this->traza;
    }

    /**
     * @param string $traza
     * @return Error
     */
    public function setTraza(string $traza)
    {
        $this->traza = $traza;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     * @return Error
     */
    public function setFecha(\DateTime $fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Error
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     * @return Error
     */
    public function setUsuario(string $usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param string $nombreUsuario
     * @return Error
     */
    public function setNombreUsuario(string $nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Error
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEstadoAtendido()
    {
        return $this->estadoAtendido;
    }

    /**
     * @param bool $estadoAtendido
     * @return Error
     */
    public function setEstadoAtendido(bool $estadoAtendido)
    {
        $this->estadoAtendido = $estadoAtendido;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEstadoSolucionado()
    {
        return $this->estadoSolucionado;
    }

    /**
     * @param bool $estadoSolucionado
     * @return Error
     */
    public function setEstadoSolucionado(bool $estadoSolucionado)
    {
        $this->estadoSolucionado = $estadoSolucionado;
        return $this;
    }

    /**
     * @return Cliente
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }

    /**
     * @param Cliente $clienteRel
     * @return Error
     */
    public function setClienteRel($clienteRel)
    {
        $this->clienteRel = $clienteRel;
        return $this;
    }

    /**
     * @return string
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param string $cliente
     * @return Error
     */
    public function setCliente(string $cliente)
    {
        $this->cliente = $cliente;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * @param mixed $codigoClienteFk
     * @return Error
     */
    public function setCodigoClienteFk($codigoClienteFk)
    {
        $this->codigoClienteFk= $codigoClienteFk;
        return $this;
    }
}