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
 * @ORM\Table(name="tarea")
 * @ORM\Entity(repositoryClass="App\Repository\TareaRepository")
 */
class Tarea
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tarea_pk", type="integer", unique=true )
     */
    private $codigoTareaPk;

    /**
     * @ORM\Column(name="codigo_usuario_registra_fk", type="string", length=50)
     */
    private $codigoUsuarioRegistraFk;

	/**
	 * @ORM\Column(name="codigo_prioridad_fk", type="string", length=50, nullable=true)
	 */
	private $codigoPrioridadFk;

	/**
     * @ORM\Column(name="codigo_tarea_tipo_fk", type="string", length=50, nullable=true)
     */
    private $codigoTareaTipoFk;

    /**
     * @ORM\Column(name="fecha_ejecucion", type="datetime", nullable=true)
     */
    private $fechaEjecucion;

    /**
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(name="fecha_verificado", type="datetime", nullable=true)
     */
    private $fechaVerificado;

    /**
     * @ORM\Column(name="estado_ejecucion", type="boolean", nullable=true)
     */
    private $estadoEjecucion = false;

    /**
     * @ORM\Column(name="estado_terminado", type="boolean", nullable=true)
     */
    private $estadoTerminado = false;

    /**
     * @ORM\Column(name="estado_verificado", type="boolean", nullable=true)
     */
    private $estadoVerificado = false;

    /**
     * @ORM\Column(name="codigo_usuario_asigna_fk", type="string", length=50, nullable=true)
     */
    private $codigoUsuarioAsignaFk;

	/**
	 * @ORM\Column(name="codigo_caso_fk", type="integer", length=50, nullable=true)
	 */
	private $codigoCasoFk;

    /**
     * @ORM\Column(name="fecha_gestion", type="datetime", nullable=true)
     */
    private $fechaGestion;

    /**
     * @ORM\Column(name="fecha_solucion", type="datetime", nullable=true)
     */
    private $fechaSolucion;

    /**
     * @ORM\Column(name="descripcion", type="string", length=5000, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="comentario", type="string", length=5000, nullable=true)
     */
    private $comentario;

	/**
	 * @ORM\Column(name="caso", type="string", length=10, nullable=true)
	 */
	private $caso;

    /**
     * @ORM\Column(name="estado_incomprensible", type="boolean", nullable=true)
     */
    private $estadoIncomprensible = false;

    /**
     * @ORM\Column(name="estado_pausa", type="boolean", nullable=true)
     */
    private $estadoPausa = false;

    /**
     * @ORM\Column(name="codigo_tarea_tiempo_fk", type="integer", nullable=true)
     */
    private $codigoTareaTiempoFk;

    /**
     * @ORM\Column(name="numero_devoluciones", type="integer", nullable=true)
     */
    private $numeroDevoluciones = 0;


    /**
     * @ORM\ManyToOne(targetEntity="TareaTipo", inversedBy="tareasTareaTipoRel")
     * @ORM\JoinColumn(name="codigo_tarea_tipo_fk", referencedColumnName="codigo_tarea_tipo_pk")
     */
    private $tareaTipoRel;

	/**
	 * @ORM\ManyToOne(targetEntity="Prioridad", inversedBy="tareaPrioridadRel")
	 * @ORM\JoinColumn(name="codigo_prioridad_fk", referencedColumnName="codigo_prioridad_pk")
	 */
	private $prioridadRel;


	/**
	 * @ORM\ManyToOne(targetEntity="Caso", inversedBy="tareasCasoRel")
	 * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk", nullable=true)
	 */
	private $casoRel;

    /**
     * @ORM\ManyToOne(targetEntity="TareaTiempo", inversedBy="tareasTareaTiempoRel")
     * @ORM\JoinColumn(name="codigo_tarea_tiempo_fk", referencedColumnName="codigo_tarea_tiempo_pk")
     */
    private $tareaTiempoRel;

    /**
     * @ORM\OneToMany(targetEntity="TareaDevolucion", mappedBy="devolucionRel")
     */
    private $tareasDevolucionRel;

    /**
     * @return int
     */
    public function getCodigoTareaPk(): int
    {
        return $this->codigoTareaPk;
    }

    /**
     * @param int $codigoTareaPk
     */
    public function setCodigoTareaPk(int $codigoTareaPk): void
    {
        $this->codigoTareaPk = $codigoTareaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioRegistraFk()
    {
        return $this->codigoUsuarioRegistraFk;
    }

    /**
     * @param mixed $codigoUsuarioRegistraFk
     */
    public function setCodigoUsuarioRegistraFk($codigoUsuarioRegistraFk): void
    {
        $this->codigoUsuarioRegistraFk = $codigoUsuarioRegistraFk;
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
    public function getCodigoTareaTipoFk()
    {
        return $this->codigoTareaTipoFk;
    }

    /**
     * @param mixed $codigoTareaTipoFk
     */
    public function setCodigoTareaTipoFk($codigoTareaTipoFk): void
    {
        $this->codigoTareaTipoFk = $codigoTareaTipoFk;
    }

    /**
     * @return mixed
     */
    public function getFechaEjecucion()
    {
        return $this->fechaEjecucion;
    }

    /**
     * @param mixed $fechaEjecucion
     */
    public function setFechaEjecucion($fechaEjecucion): void
    {
        $this->fechaEjecucion = $fechaEjecucion;
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
    public function getFechaVerificado()
    {
        return $this->fechaVerificado;
    }

    /**
     * @param mixed $fechaVerificado
     */
    public function setFechaVerificado($fechaVerificado): void
    {
        $this->fechaVerificado = $fechaVerificado;
    }

    /**
     * @return mixed
     */
    public function getEstadoEjecucion()
    {
        return $this->estadoEjecucion;
    }

    /**
     * @param mixed $estadoEjecucion
     */
    public function setEstadoEjecucion($estadoEjecucion): void
    {
        $this->estadoEjecucion = $estadoEjecucion;
    }

    /**
     * @return mixed
     */
    public function getEstadoTerminado()
    {
        return $this->estadoTerminado;
    }

    /**
     * @param mixed $estadoTerminado
     */
    public function setEstadoTerminado($estadoTerminado): void
    {
        $this->estadoTerminado = $estadoTerminado;
    }

    /**
     * @return mixed
     */
    public function getEstadoVerificado()
    {
        return $this->estadoVerificado;
    }

    /**
     * @param mixed $estadoVerificado
     */
    public function setEstadoVerificado($estadoVerificado): void
    {
        $this->estadoVerificado = $estadoVerificado;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioAsignaFk()
    {
        return $this->codigoUsuarioAsignaFk;
    }

    /**
     * @param mixed $codigoUsuarioAsignaFk
     */
    public function setCodigoUsuarioAsignaFk($codigoUsuarioAsignaFk): void
    {
        $this->codigoUsuarioAsignaFk = $codigoUsuarioAsignaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCasoFk()
    {
        return $this->codigoCasoFk;
    }

    /**
     * @param mixed $codigoCasoFk
     */
    public function setCodigoCasoFk($codigoCasoFk): void
    {
        $this->codigoCasoFk = $codigoCasoFk;
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
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getCaso()
    {
        return $this->caso;
    }

    /**
     * @param mixed $caso
     */
    public function setCaso($caso): void
    {
        $this->caso = $caso;
    }

    /**
     * @return mixed
     */
    public function getEstadoIncomprensible()
    {
        return $this->estadoIncomprensible;
    }

    /**
     * @param mixed $estadoIncomprensible
     */
    public function setEstadoIncomprensible($estadoIncomprensible): void
    {
        $this->estadoIncomprensible = $estadoIncomprensible;
    }

    /**
     * @return mixed
     */
    public function getEstadoPausa()
    {
        return $this->estadoPausa;
    }

    /**
     * @param mixed $estadoPausa
     */
    public function setEstadoPausa($estadoPausa): void
    {
        $this->estadoPausa = $estadoPausa;
    }

    /**
     * @return mixed
     */
    public function getCodigoTareaTiempoFk()
    {
        return $this->codigoTareaTiempoFk;
    }

    /**
     * @param mixed $codigoTareaTiempoFk
     */
    public function setCodigoTareaTiempoFk($codigoTareaTiempoFk): void
    {
        $this->codigoTareaTiempoFk = $codigoTareaTiempoFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroDevoluciones()
    {
        return $this->numeroDevoluciones;
    }

    /**
     * @param mixed $numeroDevoluciones
     */
    public function setNumeroDevoluciones($numeroDevoluciones): void
    {
        $this->numeroDevoluciones = $numeroDevoluciones;
    }

    /**
     * @return mixed
     */
    public function getTareaTipoRel()
    {
        return $this->tareaTipoRel;
    }

    /**
     * @param mixed $tareaTipoRel
     */
    public function setTareaTipoRel($tareaTipoRel): void
    {
        $this->tareaTipoRel = $tareaTipoRel;
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
    public function getCasoRel()
    {
        return $this->casoRel;
    }

    /**
     * @param mixed $casoRel
     */
    public function setCasoRel($casoRel): void
    {
        $this->casoRel = $casoRel;
    }

    /**
     * @return mixed
     */
    public function getTareaTiempoRel()
    {
        return $this->tareaTiempoRel;
    }

    /**
     * @param mixed $tareaTiempoRel
     */
    public function setTareaTiempoRel($tareaTiempoRel): void
    {
        $this->tareaTiempoRel = $tareaTiempoRel;
    }

    /**
     * @return mixed
     */
    public function getTareasDevolucionRel()
    {
        return $this->tareasDevolucionRel;
    }

    /**
     * @param mixed $tareasDevolucionRel
     */
    public function setTareasDevolucionRel($tareasDevolucionRel): void
    {
        $this->tareasDevolucionRel = $tareasDevolucionRel;
    }

   }
