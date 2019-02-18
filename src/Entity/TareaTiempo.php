<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaTiempo
 *
 * @ORM\Table(name="tarea_tiempo")
 * @ORM\Entity(repositoryClass="App\Repository\TareaTiempoRepository")
 */

class TareaTiempo
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tarea_tiempo_pk",type="integer", unique=true)
     */
    private $codigoTareaTiempoPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string", length=50, nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="fecha_hora_inicio", type="datetime", nullable=true)
     */
    private $fechaHoraInicio;

    /**
     * @ORM\Column(name="fecha_hora_fin", type="datetime", nullable=true)
     */
    private $fechaHoraFin;

    /**
     * @ORM\Column(name="codigo_tarea_fk", type="integer", nullable=true)
     */
    private $codigoTareaFk;

    /**
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="tareaTiempoRel")
     */
    private $tareasTareaTiempoRel;

    /**
     * @ORM\Column(name="minutos", type="integer", nullable=true)
     */
    private $minutos;

    /**
     * @return string
     */
    public function getCodigoTareaTiempoPk(): string
    {
        return $this->codigoTareaTiempoPk;
    }

    /**
     * @param string $codigoTareaTiempoPk
     */
    public function setCodigoTareaTiempoPk(string $codigoTareaTiempoPk): void
    {
        $this->codigoTareaTiempoPk = $codigoTareaTiempoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getFechaHoraInicio()
    {
        return $this->fechaHoraInicio;
    }

    /**
     * @param mixed $fechaHoraInicio
     */
    public function setFechaHoraInicio($fechaHoraInicio): void
    {
        $this->fechaHoraInicio = $fechaHoraInicio;
    }

    /**
     * @return mixed
     */
    public function getFechaHoraFin()
    {
        return $this->fechaHoraFin;
    }

    /**
     * @param mixed $fechaHoraFin
     */
    public function setFechaHoraFin($fechaHoraFin): void
    {
        $this->fechaHoraFin = $fechaHoraFin;
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
    public function getTareasTareaTiempoRel()
    {
        return $this->tareasTareaTiempoRel;
    }

    /**
     * @param mixed $tareasTareaTiempoRel
     */
    public function setTareasTareaTiempoRel($tareasTareaTiempoRel): void
    {
        $this->tareasTareaTiempoRel = $tareasTareaTiempoRel;
    }

    /**
     * @return mixed
     */
    public function getMinutos()
    {
        return $this->minutos;
    }

    /**
     * @param mixed $minutos
     */
    public function setMinutos($minutos): void
    {
        $this->minutos = $minutos;
    }

}
