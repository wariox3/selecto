<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuNovedad
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuNovedadRepository")
 */
class RhuNovedad
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_novedad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoNovedadPk;
    
    /**
     * @ORM\Column(name="codigo_novedad_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoNovedadTipoFk;

    /**
     * @ORM\Column(name="codigo_empleado_fk", type="integer", nullable=true)
     */
    private $codigoEmpleadoFk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="codigo_entidad_fk", type="integer", nullable=true)
     */
    private $codigoEntidadFk;

    /**
     * @ORM\Column(name="codigo_grupo_fk", type="string",length=10, nullable=true)
     */
    private $codigoGrupoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="fecha_desde", type="date", nullable=true)
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta", type="date", nullable=true)
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="dias", options={"default" : 0}, type="float", nullable=true)
     */
    private $dias = 0;

    /**
     * @ORM\Column(name="comentarios", type="text", nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAnulado = false;

    /**
     * @ORM\Column(name="prorroga", options={"default" : false}, type="boolean", nullable=true)
     */
    private $prorroga = false;

    /**
     * @ORM\Column(name="transcripcion", options={"default" : false}, type="boolean", nullable=true)
     */
    private $transcripcion = false;

    /**
     * @ORM\Column(name="legalizado", options={"default" : false}, type="boolean", nullable=true)
     */
    private $legalizado = false;

    /**
     * @ORM\Column(name="porcentaje", options={"default" : 0}, type="float", nullable=true)
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="vr_valor", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrValor = 0;

    /**
     * @ORM\Column(name="vr_ibc", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrIbc = 0;

    /**
     * @ORM\Column(name="dias_ibc", options={"default" : 0}, type="float", nullable=true)
     */
    private $diasIbc = 0;

    /**
     * @ORM\Column(name="vr_ibc_propuesto", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrIbcPropuesto = 0;

    /**
     * @ORM\Column(name="vr_propuesto", options={"default" : 0}, type="float", nullable=true)
     */
    private $vrPropuesto = 0;

    /**
     * @ORM\ManyToOne(targetEntity="RhuNovedadTipo", inversedBy="novedadesNovedadTipoRel")
     * @ORM\JoinColumn(name="codigo_novedad_tipo_fk", referencedColumnName="codigo_novedad_tipo_pk")
     */
    protected $novedadTipoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEmpleado", inversedBy="novedadesEmpleadoRel")
     * @ORM\JoinColumn(name="codigo_empleado_fk", referencedColumnName="codigo_empleado_pk")
     */
    protected $empleadoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuContrato", inversedBy="novedadesContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    protected $contratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="novedadesEntidadRel")
     * @ORM\JoinColumn(name="codigo_entidad_fk", referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuGrupo", inversedBy="novedadesGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk", referencedColumnName="codigo_grupo_pk")
     */
    protected $grupoRel;

    /**
     * @return mixed
     */
    public function getCodigoNovedadPk()
    {
        return $this->codigoNovedadPk;
    }

    /**
     * @param mixed $codigoNovedadPk
     */
    public function setCodigoNovedadPk($codigoNovedadPk): void
    {
        $this->codigoNovedadPk = $codigoNovedadPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoNovedadTipoFk()
    {
        return $this->codigoNovedadTipoFk;
    }

    /**
     * @param mixed $codigoNovedadTipoFk
     */
    public function setCodigoNovedadTipoFk($codigoNovedadTipoFk): void
    {
        $this->codigoNovedadTipoFk = $codigoNovedadTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpleadoFk()
    {
        return $this->codigoEmpleadoFk;
    }

    /**
     * @param mixed $codigoEmpleadoFk
     */
    public function setCodigoEmpleadoFk($codigoEmpleadoFk): void
    {
        $this->codigoEmpleadoFk = $codigoEmpleadoFk;
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
    public function getCodigoEntidadFk()
    {
        return $this->codigoEntidadFk;
    }

    /**
     * @param mixed $codigoEntidadFk
     */
    public function setCodigoEntidadFk($codigoEntidadFk): void
    {
        $this->codigoEntidadFk = $codigoEntidadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoGrupoFk()
    {
        return $this->codigoGrupoFk;
    }

    /**
     * @param mixed $codigoGrupoFk
     */
    public function setCodigoGrupoFk($codigoGrupoFk): void
    {
        $this->codigoGrupoFk = $codigoGrupoFk;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde): void
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return int
     */
    public function getDias(): int
    {
        return $this->dias;
    }

    /**
     * @param int $dias
     */
    public function setDias(int $dias): void
    {
        $this->dias = $dias;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */
    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
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
     * @return bool
     */
    public function getEstadoAutorizado(): bool
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param bool $estadoAutorizado
     */
    public function setEstadoAutorizado(bool $estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return bool
     */
    public function getEstadoAprobado(): bool
    {
        return $this->estadoAprobado;
    }

    /**
     * @param bool $estadoAprobado
     */
    public function setEstadoAprobado(bool $estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return bool
     */
    public function getEstadoAnulado(): bool
    {
        return $this->estadoAnulado;
    }

    /**
     * @param bool $estadoAnulado
     */
    public function setEstadoAnulado(bool $estadoAnulado): void
    {
        $this->estadoAnulado = $estadoAnulado;
    }

    /**
     * @return bool
     */
    public function isProrroga(): bool
    {
        return $this->prorroga;
    }

    /**
     * @param bool $prorroga
     */
    public function setProrroga(bool $prorroga): void
    {
        $this->prorroga = $prorroga;
    }

    /**
     * @return bool
     */
    public function isTranscripcion(): bool
    {
        return $this->transcripcion;
    }

    /**
     * @param bool $transcripcion
     */
    public function setTranscripcion(bool $transcripcion): void
    {
        $this->transcripcion = $transcripcion;
    }

    /**
     * @return bool
     */
    public function isLegalizado(): bool
    {
        return $this->legalizado;
    }

    /**
     * @param bool $legalizado
     */
    public function setLegalizado(bool $legalizado): void
    {
        $this->legalizado = $legalizado;
    }

    /**
     * @return int
     */
    public function getPorcentaje(): int
    {
        return $this->porcentaje;
    }

    /**
     * @param int $porcentaje
     */
    public function setPorcentaje(int $porcentaje): void
    {
        $this->porcentaje = $porcentaje;
    }

    /**
     * @return int
     */
    public function getVrValor(): int
    {
        return $this->vrValor;
    }

    /**
     * @param int $vrValor
     */
    public function setVrValor(int $vrValor): void
    {
        $this->vrValor = $vrValor;
    }

    /**
     * @return int
     */
    public function getVrIbc(): int
    {
        return $this->vrIbc;
    }

    /**
     * @param int $vrIbc
     */
    public function setVrIbc(int $vrIbc): void
    {
        $this->vrIbc = $vrIbc;
    }

    /**
     * @return int
     */
    public function getDiasIbc(): int
    {
        return $this->diasIbc;
    }

    /**
     * @param int $diasIbc
     */
    public function setDiasIbc(int $diasIbc): void
    {
        $this->diasIbc = $diasIbc;
    }

    /**
     * @return int
     */
    public function getVrIbcPropuesto(): int
    {
        return $this->vrIbcPropuesto;
    }

    /**
     * @param int $vrIbcPropuesto
     */
    public function setVrIbcPropuesto(int $vrIbcPropuesto): void
    {
        $this->vrIbcPropuesto = $vrIbcPropuesto;
    }

    /**
     * @return int
     */
    public function getVrPropuesto(): int
    {
        return $this->vrPropuesto;
    }

    /**
     * @param int $vrPropuesto
     */
    public function setVrPropuesto(int $vrPropuesto): void
    {
        $this->vrPropuesto = $vrPropuesto;
    }

    /**
     * @return mixed
     */
    public function getNovedadTipoRel()
    {
        return $this->novedadTipoRel;
    }

    /**
     * @param mixed $novedadTipoRel
     */
    public function setNovedadTipoRel($novedadTipoRel): void
    {
        $this->novedadTipoRel = $novedadTipoRel;
    }

    /**
     * @return mixed
     */
    public function getEmpleadoRel()
    {
        return $this->empleadoRel;
    }

    /**
     * @param mixed $empleadoRel
     */
    public function setEmpleadoRel($empleadoRel): void
    {
        $this->empleadoRel = $empleadoRel;
    }

    /**
     * @return mixed
     */
    public function getContratoRel()
    {
        return $this->contratoRel;
    }

    /**
     * @param mixed $contratoRel
     */
    public function setContratoRel($contratoRel): void
    {
        $this->contratoRel = $contratoRel;
    }

    /**
     * @return mixed
     */
    public function getEntidadRel()
    {
        return $this->entidadRel;
    }

    /**
     * @param mixed $entidadRel
     */
    public function setEntidadRel($entidadRel): void
    {
        $this->entidadRel = $entidadRel;
    }

    /**
     * @return mixed
     */
    public function getGrupoRel()
    {
        return $this->grupoRel;
    }

    /**
     * @param mixed $grupoRel
     */
    public function setGrupoRel($grupoRel): void
    {
        $this->grupoRel = $grupoRel;
    }

}
