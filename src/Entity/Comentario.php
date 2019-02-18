<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Comentario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_comentario_pk", type="integer", unique=true)
     */
    private $codigoComentarioPk;

    /**
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @ORM\Column(name="comentario", type="string", length=500, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_ususario_fk", type="string", length=50, nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_caso_fk", type="integer",  nullable=true)
     */
    private $codigoCasoFk;

    /**
     * @ORM\Column(name="codigo_tarea_fk", type="integer", nullable=true)
     */
    private $codigoTareaFk;

    /**
     * @ORM\Column(name="codigo_solicitud_fk", type="integer",  nullable=true)
     */
    private $codigoSolicitudFk;

    /**
     * @ORM\Column(name="cliente", type="boolean", nullable= true)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Caso", inversedBy="casosComentarioRel")
     * @ORM\JoinColumn(name="codigo_caso_fk", referencedColumnName="codigo_caso_pk")
     */
    private $casoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tarea", inversedBy="tareasComentarioRel")
     * @ORM\JoinColumn(name="codigo_tarea_fk", referencedColumnName="codigo_tarea_pk")
     */
    private $tareaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Solicitud", inversedBy="solicitudesComentarioRel")
     * @ORM\JoinColumn(name="codigo_solicitud_fk", referencedColumnName="codigo_solicitud_pk")
     */
    private $solicitudRel;

    /**
     * @return mixed
     */
    public function getCodigoComentarioPk()
    {
        return $this->codigoComentarioPk;
    }

    /**
     * @param mixed $codigoComentarioPk
     */
    public function setCodigoComentarioPk($codigoComentarioPk): void
    {
        $this->codigoComentarioPk = $codigoComentarioPk;
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
    public function getCodigoSolicitudFk()
    {
        return $this->codigoSolicitudFk;
    }

    /**
     * @param mixed $codigoSolicitudFk
     */
    public function setCodigoSolicitudFk($codigoSolicitudFk): void
    {
        $this->codigoSolicitudFk = $codigoSolicitudFk;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente): void
    {
        $this->cliente = $cliente;
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
    public function getTareaRel()
    {
        return $this->tareaRel;
    }

    /**
     * @param mixed $tareaRel
     */
    public function setTareaRel($tareaRel): void
    {
        $this->tareaRel = $tareaRel;
    }

    /**
     * @return mixed
     */
    public function getSolicitudRel()
    {
        return $this->solicitudRel;
    }

    /**
     * @param mixed $solicitudRel
     */
    public function setSolicitudRel($solicitudRel): void
    {
        $this->solicitudRel = $solicitudRel;
    }
    
}
