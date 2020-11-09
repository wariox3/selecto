<?php


namespace App\Entity\General;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenIdentificacionRepository")
 */
class GenIdentificacion
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=3, nullable=false, unique=true)
     */
    private $codigoIdentificacionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_entidad", type="string", length=10, nullable=true)
     */
    private $codigoEntidad;

    /**
     * @return mixed
     */
    public function getCodigoIdentificacionPk()
    {
        return $this->codigoIdentificacionPk;
    }

    /**
     * @param mixed $codigoIdentificacionPk
     */
    public function setCodigoIdentificacionPk($codigoIdentificacionPk): void
    {
        $this->codigoIdentificacionPk = $codigoIdentificacionPk;
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
    public function getCodigoEntidad()
    {
        return $this->codigoEntidad;
    }

    /**
     * @param mixed $codigoEntidad
     */
    public function setCodigoEntidad($codigoEntidad): void
    {
        $this->codigoEntidad = $codigoEntidad;
    }



}