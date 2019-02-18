<?php
/**
 * Created by PhpStorm.
 * User: avera
 * Date: 4/12/17
 * Time: 11:10 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
* Caso
*
* @ORM\Table(name="caso")
* @ORM\Entity(repositoryClass="App\Repository\CasoRepository")
*/
class Caso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_caso_pk", type="integer", unique=true)
     */
    private $codigoCasoPk;

    /**
     * @ORM\Column(name="asunto", type="string", length=255)
     */
    private $asunto;

	/**
	 * @ORM\Column(name="adjunto", type="string", length=255, nullable =true)
	 */
	private $adjunto;

    /**
     * @ORM\Column(name="correo", type="string", length=200)
     */
    private $correo;

    /**
     *
     * @ORM\Column(name="contacto", type="string", length=200)
     */
    private $contacto;

    /**
     *
     * @ORM\Column(name="usuario", type="string", length=100, nullable=true)
     */
    private $usuario;

    /**
     *
     * @ORM\Column(name="telefono", type="string", length=100, nullable=true)
     */
    private $telefono;

    /**
     *
     * @ORM\Column(name="extension", type="string", length=50, nullable=true)
     */
    private $extension;

    /**
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     *
     * @ORM\Column(name="soporte", type="text", nullable=true)
     */
    private $soporte;

    /**
     *
     * @ORM\Column(name="solucion", type="text", nullable=true)
     */
    private $solucion;

    /**
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable= TRUE)
     */
    private $fechaRegistro;


	/**
	 *
	 * @ORM\Column(name="fecha_solicitud_informacion", type="datetime", nullable= TRUE)
	 */
	private $fechaSolicitudInformacion;

	/**
	 *
	 * @ORM\Column(name="fecha_respuesta_solicitud_informacion", type="datetime", nullable= TRUE)
	 */
	private $fechaRespuestaSolicitudInformacion;

    /**
     *
     * @ORM\Column(name="fecha_gestion", type="datetime", nullable= TRUE)
     */
    private $fechaGestion;

    /**
     *
     * @ORM\Column(name="fecha_solucion", type="datetime", nullable= TRUE)
     */
    private $fechaSolucion;

    /**
     * @ORM\Column(name="fecha_compromiso", type="date", nullable= true)
     */
    private $fechaCompromiso;

    /**
     *
     * @ORM\Column(name="codigo_categoria_caso_fk", type="string", length=50 )
     */
    private $codigoCategoriaCasoFk;

    /**
     *
     * @ORM\Column(name="codigo_cargo_fk", type="string", length=50, nullable=true)
     */
    private $codigoCargoFk;

    /**
     *
     * @ORM\Column(name="codigo_area_fk", type="string", length=50, nullable=true)
     */
    private $codigoAreaFk;

    /**
     *
     * @ORM\Column(name="codigo_prioridad_fk", type="string", length=50, nullable= TRUE)
     */
    private $codigoPrioridadFk;

    /**
     *
     * @ORM\Column(name="codigo_usuario_atiende_fk", type="string", length=50, nullable= TRUE)
     */
    private $codigoUsuarioAtiendeFk;

	/**
	 *
	 * @ORM\Column(name="codigo_tarea_fk", type="integer", length=50, nullable= TRUE)
	 */
	private $codigoTareaFk;

    /**
     *
     * @ORM\Column(name="codigo_usuario_soluciona_fk", type="string", length=50, nullable= TRUE)
     */
    private $codigoUsuarioSolucionaFk;

    /**
     *
     * @ORM\Column(name="estado_atendido", type="boolean", nullable= TRUE)
     */
    private $estadoAtendido = false;

	/**
	 *
	 * @ORM\Column(name="estado_solicitud_informacion", type="boolean", nullable= TRUE)
	 */
	private $estadoSolicitudInformacion = false;

	/**
	 *
	 * @ORM\Column(name="estado_respuesta_solicitud_informacion", type="boolean", nullable= TRUE)
	 */
	private $estadoRespuestaSolicitudInformacion = false;

	/**
	 *
	 * @ORM\Column(name="solicitud_informacion", type="text", nullable= TRUE)
	 */
	private $solicitudInformacion;


	/**
	 *
	 * @ORM\Column(name="respuesta_solicitud_informacion", type="text", nullable= TRUE)
	 */
	private $respuestaSolicitudInformacion;

	/**
	 *
	 * @ORM\Column(name="estado_escalado", type="boolean", nullable= TRUE)
	 */
	private $estadoEscalado = false;

	/**
	 *
	 * @ORM\Column(name="estado_reabierto", type="boolean", nullable= TRUE)
	 */
	private $estadoReabierto = false;

    /**
     *
     * @ORM\Column(name="estado_solucionado", type="boolean", nullable= TRUE)
     */
    private $estadoSolucionado = false;

    /**
     * @ORM\Column(name="estado_tarea", type="boolean", nullable=TRUE)
     */
    private $estadoTarea = false;

    /**
     * @ORM\Column(name="estado_tarea_terminada", type="boolean", nullable=TRUE)
     */
    private $estadoTareaTerminada = false;

    /**
     * @ORM\Column(name="estado_tarea_revisada", type="boolean", nullable=TRUE)
     */
    private $estadoTareaRevisada = false;

    /**
     *
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable= TRUE)
     */
    private $codigoClienteFk;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="casosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
    * @ORM\ManyToOne(targetEntity="CasoCategoria", inversedBy="casosCategoriaRel")
    * @ORM\JoinColumn(name="codigo_categoria_caso_fk", referencedColumnName="codigo_categoria_caso_pk")
    */
    private $categoriaRel;

    /**
     * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="casosCargoRel")
     * @ORM\JoinColumn(name="codigo_cargo_fk", referencedColumnName="codigo_cargo_pk")
     */
    private $cargoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="casosAreaRel")
     * @ORM\JoinColumn(name="codigo_area_fk", referencedColumnName="codigo_area_pk")
     */
    private $areaRel;

    /**
     * @ORM\ManyToOne(targetEntity="Prioridad", inversedBy="casosPrioridadRel")
     * @ORM\JoinColumn(name="codigo_prioridad_fk", referencedColumnName="codigo_prioridad_pk")
     */
    private $prioridadRel;


	/**
	 *
	 * @ORM\OneToMany(targetEntity="Tarea", mappedBy="casoRel")
	 *
	 */
	 private $tareasCasoRel;


	/**
	 *
	 * @ORM\OneToMany(targetEntity="Comentario", mappedBy="casoRel")
	 */

	private $casosComentarioRel;

    /**
     * @return mixed
     */
    public function getCodigoCasoPk()
    {
        return $this->codigoCasoPk;
    }

    /**
     * @param mixed $codigoCasoPk
     */
    public function setCodigoCasoPk($codigoCasoPk): void
    {
        $this->codigoCasoPk = $codigoCasoPk;
    }

    /**
     * @return mixed
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * @param mixed $asunto
     */
    public function setAsunto($asunto): void
    {
        $this->asunto = $asunto;
    }

    /**
     * @return mixed
     */
    public function getAdjunto()
    {
        return $this->adjunto;
    }

    /**
     * @param mixed $adjunto
     */
    public function setAdjunto($adjunto): void
    {
        $this->adjunto = $adjunto;
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
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * @param mixed $contacto
     */
    public function setContacto($contacto): void
    {
        $this->contacto = $contacto;
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
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getSoporte()
    {
        return $this->soporte;
    }

    /**
     * @param mixed $soporte
     */
    public function setSoporte($soporte): void
    {
        $this->soporte = $soporte;
    }

    /**
     * @return mixed
     */
    public function getSolucion()
    {
        return $this->solucion;
    }

    /**
     * @param mixed $solucion
     */
    public function setSolucion($solucion): void
    {
        $this->solucion = $solucion;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    /**
     * @return mixed
     */
    public function getFechaSolicitudInformacion()
    {
        return $this->fechaSolicitudInformacion;
    }

    /**
     * @param mixed $fechaSolicitudInformacion
     */
    public function setFechaSolicitudInformacion($fechaSolicitudInformacion): void
    {
        $this->fechaSolicitudInformacion = $fechaSolicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getFechaRespuestaSolicitudInformacion()
    {
        return $this->fechaRespuestaSolicitudInformacion;
    }

    /**
     * @param mixed $fechaRespuestaSolicitudInformacion
     */
    public function setFechaRespuestaSolicitudInformacion($fechaRespuestaSolicitudInformacion): void
    {
        $this->fechaRespuestaSolicitudInformacion = $fechaRespuestaSolicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getFechaGestion()
    {
        return $this->fechaGestion;
    }

    /**
     * @param mixed $fechaGestion
     */
    public function setFechaGestion($fechaGestion): void
    {
        $this->fechaGestion = $fechaGestion;
    }

    /**
     * @return mixed
     */
    public function getFechaSolucion()
    {
        return $this->fechaSolucion;
    }

    /**
     * @param mixed $fechaSolucion
     */
    public function setFechaSolucion($fechaSolucion): void
    {
        $this->fechaSolucion = $fechaSolucion;
    }

    /**
     * @return mixed
     */
    public function getFechaCompromiso()
    {
        return $this->fechaCompromiso;
    }

    /**
     * @param mixed $fechaCompromiso
     */
    public function setFechaCompromiso($fechaCompromiso): void
    {
        $this->fechaCompromiso = $fechaCompromiso;
    }

    /**
     * @return mixed
     */
    public function getCodigoCategoriaCasoFk()
    {
        return $this->codigoCategoriaCasoFk;
    }

    /**
     * @param mixed $codigoCategoriaCasoFk
     */
    public function setCodigoCategoriaCasoFk($codigoCategoriaCasoFk): void
    {
        $this->codigoCategoriaCasoFk = $codigoCategoriaCasoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCargoFk()
    {
        return $this->codigoCargoFk;
    }

    /**
     * @param mixed $codigoCargoFk
     */
    public function setCodigoCargoFk($codigoCargoFk): void
    {
        $this->codigoCargoFk = $codigoCargoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoAreaFk()
    {
        return $this->codigoAreaFk;
    }

    /**
     * @param mixed $codigoAreaFk
     */
    public function setCodigoAreaFk($codigoAreaFk): void
    {
        $this->codigoAreaFk = $codigoAreaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoPrioridadFk()
    {
        return $this->codigoPrioridadFk;
    }

    /**
     * @param mixed $codigoPrioridadFk
     */
    public function setCodigoPrioridadFk($codigoPrioridadFk): void
    {
        $this->codigoPrioridadFk = $codigoPrioridadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioAtiendeFk()
    {
        return $this->codigoUsuarioAtiendeFk;
    }

    /**
     * @param mixed $codigoUsuarioAtiendeFk
     */
    public function setCodigoUsuarioAtiendeFk($codigoUsuarioAtiendeFk): void
    {
        $this->codigoUsuarioAtiendeFk = $codigoUsuarioAtiendeFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoTareaFk()
    {
        return $this->codigoTareaFk;
    }

    /**
     * @param mixed $codigoTareaFk
     */
    public function setCodigoTareaFk($codigoTareaFk): void
    {
        $this->codigoTareaFk = $codigoTareaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioSolucionaFk()
    {
        return $this->codigoUsuarioSolucionaFk;
    }

    /**
     * @param mixed $codigoUsuarioSolucionaFk
     */
    public function setCodigoUsuarioSolucionaFk($codigoUsuarioSolucionaFk): void
    {
        $this->codigoUsuarioSolucionaFk = $codigoUsuarioSolucionaFk;
    }

    /**
     * @return mixed
     */
    public function getEstadoAtendido()
    {
        return $this->estadoAtendido;
    }

    /**
     * @param mixed $estadoAtendido
     */
    public function setEstadoAtendido($estadoAtendido): void
    {
        $this->estadoAtendido = $estadoAtendido;
    }

    /**
     * @return mixed
     */
    public function getEstadoSolicitudInformacion()
    {
        return $this->estadoSolicitudInformacion;
    }

    /**
     * @param mixed $estadoSolicitudInformacion
     */
    public function setEstadoSolicitudInformacion($estadoSolicitudInformacion): void
    {
        $this->estadoSolicitudInformacion = $estadoSolicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getEstadoRespuestaSolicitudInformacion()
    {
        return $this->estadoRespuestaSolicitudInformacion;
    }

    /**
     * @param mixed $estadoRespuestaSolicitudInformacion
     */
    public function setEstadoRespuestaSolicitudInformacion($estadoRespuestaSolicitudInformacion): void
    {
        $this->estadoRespuestaSolicitudInformacion = $estadoRespuestaSolicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getSolicitudInformacion()
    {
        return $this->solicitudInformacion;
    }

    /**
     * @param mixed $solicitudInformacion
     */
    public function setSolicitudInformacion($solicitudInformacion): void
    {
        $this->solicitudInformacion = $solicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getRespuestaSolicitudInformacion()
    {
        return $this->respuestaSolicitudInformacion;
    }

    /**
     * @param mixed $respuestaSolicitudInformacion
     */
    public function setRespuestaSolicitudInformacion($respuestaSolicitudInformacion): void
    {
        $this->respuestaSolicitudInformacion = $respuestaSolicitudInformacion;
    }

    /**
     * @return mixed
     */
    public function getEstadoEscalado()
    {
        return $this->estadoEscalado;
    }

    /**
     * @param mixed $estadoEscalado
     */
    public function setEstadoEscalado($estadoEscalado): void
    {
        $this->estadoEscalado = $estadoEscalado;
    }

    /**
     * @return mixed
     */
    public function getEstadoReabierto()
    {
        return $this->estadoReabierto;
    }

    /**
     * @param mixed $estadoReabierto
     */
    public function setEstadoReabierto($estadoReabierto): void
    {
        $this->estadoReabierto = $estadoReabierto;
    }

    /**
     * @return mixed
     */
    public function getEstadoSolucionado()
    {
        return $this->estadoSolucionado;
    }

    /**
     * @param mixed $estadoSolucionado
     */
    public function setEstadoSolucionado($estadoSolucionado): void
    {
        $this->estadoSolucionado = $estadoSolucionado;
    }

    /**
     * @return mixed
     */
    public function getEstadoTarea()
    {
        return $this->estadoTarea;
    }

    /**
     * @param mixed $estadoTarea
     */
    public function setEstadoTarea($estadoTarea): void
    {
        $this->estadoTarea = $estadoTarea;
    }

    /**
     * @return mixed
     */
    public function getEstadoTareaTerminada()
    {
        return $this->estadoTareaTerminada;
    }

    /**
     * @param mixed $estadoTareaTerminada
     */
    public function setEstadoTareaTerminada($estadoTareaTerminada): void
    {
        $this->estadoTareaTerminada = $estadoTareaTerminada;
    }

    /**
     * @return mixed
     */
    public function getEstadoTareaRevisada()
    {
        return $this->estadoTareaRevisada;
    }

    /**
     * @param mixed $estadoTareaRevisada
     */
    public function setEstadoTareaRevisada($estadoTareaRevisada): void
    {
        $this->estadoTareaRevisada = $estadoTareaRevisada;
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
     */
    public function setCodigoClienteFk($codigoClienteFk): void
    {
        $this->codigoClienteFk = $codigoClienteFk;
    }

    /**
     * @return mixed
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }

    /**
     * @param mixed $clienteRel
     */
    public function setClienteRel($clienteRel): void
    {
        $this->clienteRel = $clienteRel;
    }

    /**
     * @return mixed
     */
    public function getCategoriaRel()
    {
        return $this->categoriaRel;
    }

    /**
     * @param mixed $categoriaRel
     */
    public function setCategoriaRel($categoriaRel): void
    {
        $this->categoriaRel = $categoriaRel;
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
    public function getAreaRel()
    {
        return $this->areaRel;
    }

    /**
     * @param mixed $areaRel
     */
    public function setAreaRel($areaRel): void
    {
        $this->areaRel = $areaRel;
    }

    /**
     * @return mixed
     */
    public function getPrioridadRel()
    {
        return $this->prioridadRel;
    }

    /**
     * @param mixed $prioridadRel
     */
    public function setPrioridadRel($prioridadRel): void
    {
        $this->prioridadRel = $prioridadRel;
    }

    /**
     * @return mixed
     */
    public function getTareasCasoRel()
    {
        return $this->tareasCasoRel;
    }

    /**
     * @param mixed $tareasCasoRel
     */
    public function setTareasCasoRel($tareasCasoRel): void
    {
        $this->tareasCasoRel = $tareasCasoRel;
    }

    /**
     * @return mixed
     */
    public function getCasosComentarioRel()
    {
        return $this->casosComentarioRel;
    }

    /**
     * @param mixed $casosComentarioRel
     */
    public function setCasosComentarioRel($casosComentarioRel): void
    {
        $this->casosComentarioRel = $casosComentarioRel;
    }

}
