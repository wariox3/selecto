<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaDevolucion
 *
 * @ORM\Table(name="tarea_devolucion")
 * @ORM\Entity(repositoryClass="App\Repository\DevolucionRepository")
 */

class TareaDevolucion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_tarea_devolucion_pk", type="integer", unique=true)
     */
    private $codigoTareaDevolucionPk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentarios", type="text", nullable=true)
     */
    private $comentarios;

    /**
     * @ORM\Column(name="codigo_tarea_fk", type="integer", nullable=true)
     */
    private $codigoTareaFk;

    /**
     * @ORM\ManyToOne(targetEntity="Tarea", inversedBy="tareasDevolucionRel")
     * @ORM\JoinColumn(name="codigo_tarea_fk", referencedColumnName="codigo_tarea_pk")
     */
    private $devolucionRel;

    /**
     * @return mixed
     */
    public function getCodigoTareaDevolucionPk()
    {
        return $this->codigoTareaDevolucionPk;
    }

    /**
     * @param mixed $codigoTareaDevolucionPk
     */
    public function setCodigoTareaDevolucionPk($codigoTareaDevolucionPk): void
    {
        $this->codigoTareaDevolucionPk = $codigoTareaDevolucionPk;
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
    public function getDevolucionRel()
    {
        return $this->devolucionRel;
    }

    /**
     * @param mixed $devolucionRel
     */
    public function setDevolucionRel($devolucionRel): void
    {
        $this->devolucionRel = $devolucionRel;
    }



}