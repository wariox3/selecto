<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Llamada
 *
 * @ORM\Table(name="llamada")
 * @ORM\Entity(repositoryClass="App\Repository\LlamadaRepository")
 */
class Llamada
{


    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_llamada_pk", type="integer", unique=true, )
     */
    private $codigoLlamadaPk;


    /**
     * @var string
     *
     * @ORM\Column(name="tema", type="string", length=255, nullable= TRUE)
     */
    private $tema;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_contacto", type="string" ,length=255, nullable= TRUE)
     */
    private $nombreContacto;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255 ,nullable= TRUE)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255, nullable= TRUE)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text" ,nullable= TRUE)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable= TRUE)
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_gestion", type="datetime" ,nullable= TRUE)
     */
    private $fechaGestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_solucion", type="datetime" ,nullable= TRUE)
     */
    private $fechaSolucion;



    /**
     * @var int
     *
     * @ORM\Column(name="codigo_categoria_llamada_fk", type="integer" ,nullable= TRUE)
     */
    private $codigoCategoriaLlamadaFk;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado_atendido", type="boolean" ,nullable= TRUE)
     */
    private $estadoAtendido;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado_solucionado", type="boolean" ,nullable= TRUE)
     */
    private $estadoSolucionado;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="estado_no_contestan", type="boolean" ,nullable= TRUE)
	 */
	private $estadoNoContestan;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_usuario_recibe_fk", type="string", length=255 ,nullable= TRUE)
     */
    private $codigoUsuarioRecibeFk;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_usuario_atiende_fk", type="string", length=255, nullable= TRUE)
     */
    private $codigoUsuarioAtiendeFk;

     /**
     * @var int
     *
     * @ORM\Column(name="codigo_usuario_soluciona_fk", type="string", length=255, nullable= TRUE)
     */
    private $codigoUsuarioSolucionaFk;

    /**
     * @var string
     * @ORM\Column(name="codigo_modulo_fk", type="string", length=255, nullable= TRUE)
     */
    private $codigoModuloFk;

    
    /**
     * @var int
     *
     * @ORM\Column(name="codigo_cliente_fk", type="integer" ,nullable= TRUE)
     */
    private $codigoClienteFk;


    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="llamadasClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="LlamadaCategoria", inversedBy="llamadasCategoriaRel")
     * @ORM\JoinColumn(name="codigo_categoria_llamada_fk", referencedColumnName="codigo_categoria_llamada_pk")
     */
    private $categoriaRel;

    /**
     * @ORM\ManyToOne(targetEntity="Modulo", inversedBy="llamadasModuloRel")
     * @ORM\JoinColumn(name="codigo_modulo_fk", referencedColumnName="codigo_modulo_pk")
     */
    private $moduloRel;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="NoContestan", mappedBy="noContestanRel")
	 */

	private $llamadasNoContestanRel;



	/**
     * Get codigoLlamadaPk
     *
     * @return integer
     */
    public function getCodigoLlamadaPk()
    {
        return $this->codigoLlamadaPk;
    }

    /**
     * Set tema
     *
     * @param string $tema
     *
     * @return Llamada
     */
    public function setTema($tema)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema
     *
     * @return string
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set nombreContacto
     *
     * @param string $nombreContacto
     *
     * @return Llamada
     */
    public function setNombreContacto($nombreContacto)
    {
        $this->nombreContacto = $nombreContacto;

        return $this;
    }

    /**
     * Get nombreContacto
     *
     * @return string
     */
    public function getNombreContacto()
    {
        return $this->nombreContacto;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Llamada
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Llamada
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Llamada
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     *
     * @return Llamada
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaGestion
     *
     * @param \DateTime $fechaGestion
     *
     * @return Llamada
     */
    public function setFechaGestion($fechaGestion)
    {
        $this->fechaGestion = $fechaGestion;

        return $this;
    }

    /**
     * Get fechaGestion
     *
     * @return \DateTime
     */
    public function getFechaGestion()
    {
        return $this->fechaGestion;
    }

    /**
     * Set fechaSolucion
     *
     * @param \DateTime $fechaSolucion
     *
     * @return Llamada
     */
    public function setFechaSolucion($fechaSolucion)
    {
        $this->fechaSolucion = $fechaSolucion;

        return $this;
    }

    /**
     * Get fechaSolucion
     *
     * @return \DateTime
     */
    public function getFechaSolucion()
    {
        return $this->fechaSolucion;
    }

    /**
     * Set codigoCategoriaLlamadaFk
     *
     * @param integer $codigoCategoriaLlamadaFk
     *
     * @return Llamada
     */
    public function setCodigoCategoriaLlamadaFk($codigoCategoriaLlamadaFk)
    {
        $this->codigoCategoriaLlamadaFk = $codigoCategoriaLlamadaFk;

        return $this;
    }

    /**
     * Get codigoCategoriaLlamadaFk
     *
     * @return integer
     */
    public function getCodigoCategoriaLlamadaFk()
    {
        return $this->codigoCategoriaLlamadaFk;
    }

    /**
     * Set estadoAtendido
     *
     * @param boolean $estadoAtendido
     *
     * @return Llamada
     */
    public function setEstadoAtendido($estadoAtendido)
    {
        $this->estadoAtendido = $estadoAtendido;

        return $this;
    }

    /**
     * Get estadoAtendido
     *
     * @return boolean
     */
    public function getEstadoAtendido()
    {
        return $this->estadoAtendido;
    }

    /**
     * Set estadoSolucionado
     *
     * @param boolean $estadoSolucionado
     *
     * @return Llamada
     */
    public function setEstadoSolucionado($estadoSolucionado)
    {
        $this->estadoSolucionado = $estadoSolucionado;

        return $this;
    }

    /**
     * Get estadoSolucionado
     *
     * @return boolean
     */
    public function getEstadoSolucionado()
    {
        return $this->estadoSolucionado;
    }

    /**
     * Set codigoUsuarioRecibeFk
     *
     * @param string $codigoUsuarioRecibeFk
     *
     * @return Llamada
     */
    public function setCodigoUsuarioRecibeFk($codigoUsuarioRecibeFk)
    {
        $this->codigoUsuarioRecibeFk = $codigoUsuarioRecibeFk;

        return $this;
    }

    /**
     * Get codigoUsuarioRecibeFk
     *
     * @return string
     */
    public function getCodigoUsuarioRecibeFk()
    {
        return $this->codigoUsuarioRecibeFk;
    }

    /**
     * Set codigoUsuarioAtiendeFk
     *
     * @param string $codigoUsuarioAtiendeFk
     *
     * @return Llamada
     */
    public function setCodigoUsuarioAtiendeFk($codigoUsuarioAtiendeFk)
    {
        $this->codigoUsuarioAtiendeFk = $codigoUsuarioAtiendeFk;

        return $this;
    }

    /**
     * Get codigoUsuarioAtiendeFk
     *
     * @return string
     */
    public function getCodigoUsuarioAtiendeFk()
    {
        return $this->codigoUsuarioAtiendeFk;
    }

    /**
     * Set codigoUsuarioSolucionaFk
     *
     * @param string $codigoUsuarioSolucionaFk
     *
     * @return Llamada
     */
    public function setCodigoUsuarioSolucionaFk($codigoUsuarioSolucionaFk)
    {
        $this->codigoUsuarioSolucionaFk = $codigoUsuarioSolucionaFk;

        return $this;
    }

    /**
     * Get codigoUsuarioSolucionaFk
     *
     * @return string
     */
    public function getCodigoUsuarioSolucionaFk()
    {
        return $this->codigoUsuarioSolucionaFk;
    }

    /**
     * Set codigoModuloFk
     *
     * @param string $codigoModuloFk
     *
     * @return Llamada
     */
    public function setCodigoModuloFk($codigoModuloFk)
    {
        $this->codigoModuloFk = $codigoModuloFk;

        return $this;
    }

    /**
     * Get codigoModuloFk
     *
     * @return string
     */
    public function getCodigoModuloFk()
    {
        return $this->codigoModuloFk;
    }

    /**
     * Set codigoClienteFk
     *
     * @param integer $codigoClienteFk
     *
     * @return Llamada
     */
    public function setCodigoClienteFk($codigoClienteFk)
    {
        $this->codigoClienteFk = $codigoClienteFk;

        return $this;
    }

    /**
     * Get codigoClienteFk
     *
     * @return integer
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * Set clienteRel
     *
     * @param \App\Entity\Cliente $clienteRel
     *
     * @return Llamada
     */
    public function setClienteRel(\App\Entity\Cliente $clienteRel = null)
    {
        $this->clienteRel = $clienteRel;

        return $this;
    }

    /**
     * Get clienteRel
     *
     * @return \App\Entity\Cliente
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }

    /**
     * Set categoriaRel
     *
     * @param \App\Entity\LlamadaCategoria $categoriaRel
     *
     * @return Llamada
     */
    public function setCategoriaRel(\App\Entity\LlamadaCategoria $categoriaRel = null)
    {
        $this->categoriaRel = $categoriaRel;

        return $this;
    }

    /**
     * Get categoriaRel
     *
     * @return \App\Entity\LlamadaCategoria
     */
    public function getCategoriaRel()
    {
        return $this->categoriaRel;
    }

    /**
     * Set moduloRel
     *
     * @param \App\Entity\Modulo $moduloRel
     *
     * @return Llamada
     */
    public function setModuloRel(\App\Entity\Modulo $moduloRel = null)
    {
        $this->moduloRel = $moduloRel;

        return $this;
    }

    /**
     * Get moduloRel
     *
     * @return \App\Entity\Modulo
     */
    public function getModuloRel()
    {
        return $this->moduloRel;
    }

    /**
     * Set estadoContestan
     *
     * @param boolean $estadoContestan
     *
     * @return Llamada
     */
    public function setEstadoContestan($estadoContestan)
    {
        $this->estadoContestan = $estadoContestan;

        return $this;
    }

    /**
     * Get estadoContestan
     *
     * @return boolean
     */
    public function getEstadoContestan()
    {
        return $this->estadoContestan;
    }

    /**
     * Set estadoNoContestan
     *
     * @param boolean $estadoNoContestan
     *
     * @return Llamada
     */
    public function setEstadoNoContestan($estadoNoContestan)
    {
        $this->estadoNoContestan = $estadoNoContestan;

        return $this;
    }

    /**
     * Get estadoNoContestan
     *
     * @return boolean
     */
    public function getEstadoNoContestan()
    {
        return $this->estadoNoContestan;
    }

    /**
     * Set fechaNoContestan
     *
     * @param \DateTime $fechaNoContestan
     *
     * @return Llamada
     */
    public function setFechaNoContestan($fechaNoContestan)
    {
        $this->fechaNoContestan = $fechaNoContestan;

        return $this;
    }

    /**
     * Get fechaNoContestan
     *
     * @return \DateTime
     */
    public function getFechaNoContestan()
    {
        return $this->fechaNoContestan;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->llamadasNoContestanRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add llamadasNoContestanRel
     *
     * @param \App\Entity\NoContestan $llamadasNoContestanRel
     *
     * @return Llamada
     */
    public function addLlamadasNoContestanRel(\App\Entity\NoContestan $llamadasNoContestanRel)
    {
        $this->llamadasNoContestanRel[] = $llamadasNoContestanRel;

        return $this;
    }

    /**
     * Remove llamadasNoContestanRel
     *
     * @param \App\Entity\NoContestan $llamadasNoContestanRel
     */
    public function removeLlamadasNoContestanRel(\App\Entity\NoContestan $llamadasNoContestanRel)
    {
        $this->llamadasNoContestanRel->removeElement($llamadasNoContestanRel);
    }

    /**
     * Get llamadasNoContestanRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLlamadasNoContestanRel()
    {
        return $this->llamadasNoContestanRel;
    }
}
