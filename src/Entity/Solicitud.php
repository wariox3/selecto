<?php
/**
 * Created by Juan David Marulanda V.
 * User: @ju4nr3v0l
 * appSoga developers Team.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tarea
 *
 * @ORM\Table(name="solicitud")
 * @ORM\Entity(repositoryClass="App\Repository\SolicitudRepository")
 */
class Solicitud
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_solicitud_pk", type="integer", unique=true )
     */
    private $codigoSolicitudPk;

    /**
     * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
     */
    private $codigoClienteFk;

    /**
     * @ORM\Column(name="codigo_solicitud_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoSolicitudTipoFk;

    /**
     * @ORM\Column(name="fecha_solicitud", type="datetime", nullable=true)
     */
    private $fechaSolicitud;

    /**
     * @ORM\Column(name="fecha_atencion", type="datetime", nullable=true)
     */
    private $fechaAtencion;

    /**
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=true)
     */
    private $fechaEntrega;

    /**
     * @ORM\Column(name="estado_atendido", type="boolean", nullable=true)
     */
    private $estadoAtendido = false;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean", nullable=true)
     */
    private $estadoCerrado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="vr_inversion", type="float")
     */
    private $vrInversion = 0;

    /**
     * @ORM\Column(name="nombre", type="string", length=25, nullable=true)
     */
    private $nombre;

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
     * @ORM\Column(name="telefono", type="string", length=100)
     */
    private $telefono;

    /**
     *
     * @ORM\Column(name="extension", type="string", length=50)
     */
    private $extension;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="solucion", type="text", nullable=true)
     */
    private $solucion;

    /**
     * @ORM\Column(name="horas", type="time", nullable=true)
     */
    private $horas;

    /**
     * @ORM\Column(name="descripcion_cierre", type="text", nullable=true)
     */
    private $descripcionCierre;


    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="solicitudesClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;

    /**
     * @ORM\ManyToOne(targetEntity="SolicitudTipo", inversedBy="solicitudesSolicitudTipoRel")
     * @ORM\JoinColumn(name="codigo_solicitud_tipo_fk", referencedColumnName="codigo_solicitud_tipo_pk")
     */
    private $solicitudTipoRel;

    /**
     *
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="solicitudRel")
     */

    private $solicitudesComentarioRel;

    /**
     * @return mixed
     */
    public function getCodigoSolicitudPk()
    {
        return $this->codigoSolicitudPk;
    }

    /**
     * @param mixed $codigoSolicitudPk
     */
    public function setCodigoSolicitudPk($codigoSolicitudPk): void
    {
        $this->codigoSolicitudPk = $codigoSolicitudPk;
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
    public function getCodigoSolicitudTipoFk()
    {
        return $this->codigoSolicitudTipoFk;
    }

    /**
     * @param mixed $codigoSolicitudTipoFk
     */
    public function setCodigoSolicitudTipoFk($codigoSolicitudTipoFk): void
    {
        $this->codigoSolicitudTipoFk = $codigoSolicitudTipoFk;
    }

    /**
     * @return mixed
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * @param mixed $fechaSolicitud
     */
    public function setFechaSolicitud($fechaSolicitud): void
    {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    /**
     * @return mixed
     */
    public function getFechaAtencion()
    {
        return $this->fechaAtencion;
    }

    /**
     * @param mixed $fechaAtencion
     */
    public function setFechaAtencion($fechaAtencion): void
    {
        $this->fechaAtencion = $fechaAtencion;
    }

    /**
     * @return mixed
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * @param mixed $fechaEntrega
     */
    public function setFechaEntrega($fechaEntrega): void
    {
        $this->fechaEntrega = $fechaEntrega;
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
    public function getEstadoCerrado()
    {
        return $this->estadoCerrado;
    }

    /**
     * @param mixed $estadoCerrado
     */
    public function setEstadoCerrado($estadoCerrado): void
    {
        $this->estadoCerrado = $estadoCerrado;
    }

    /**
     * @return mixed
     */
    public function getEstadoAprobado()
    {
        return $this->estadoAprobado;
    }

    /**
     * @param mixed $estadoAprobado
     */
    public function setEstadoAprobado($estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return mixed
     */
    public function getVrInversion()
    {
        return $this->vrInversion;
    }

    /**
     * @param mixed $vrInversion
     */
    public function setVrInversion($vrInversion): void
    {
        $this->vrInversion = $vrInversion;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
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
    public function getSolicitudTipoRel()
    {
        return $this->solicitudTipoRel;
    }

    /**
     * @param mixed $solicitudTipoRel
     */
    public function setSolicitudTipoRel($solicitudTipoRel): void
    {
        $this->solicitudTipoRel = $solicitudTipoRel;
    }

    /**
     * @return mixed
     */
    public function getSolicitudesComentarioRel()
    {
        return $this->solicitudesComentarioRel;
    }

    /**
     * @param mixed $solicitudesComentarioRel
     */
    public function setSolicitudesComentarioRel($solicitudesComentarioRel): void
    {
        $this->solicitudesComentarioRel = $solicitudesComentarioRel;
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
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * @param mixed $horas
     */
    public function setHoras($horas): void
    {
        $this->horas = $horas;
    }

    /**
     * @return mixed
     */
    public function getDescripcionCierre()
    {
        return $this->descripcionCierre;
    }

    /**
     * @param mixed $descripcionCierre
     */
    public function setDescripcionCierre($descripcionCierre): void
    {
        $this->descripcionCierre = $descripcionCierre;
    }

}
