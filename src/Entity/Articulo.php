<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table(name="articulo")
 * @ORM\Entity(repositoryClass="App\Repository\ArticuloRepository")
 */
class Articulo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoArticuloPk;

    /**
     * @ORM\Column(name="codigo_norma_fk", type="integer", nullable=true)
     */
    private $codigoNormaFk;

    /**
     * @ORM\Column(name="obligacion", type="text", nullable=true)
     */
    private $obligacion;

    /**
     * @ORM\Column(name="verificable", type="boolean", nullable=true, options={"default" : false})
     */
    private $verificable = false;

    /**
     * @ORM\Column(name="estado_derogado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoDerogado = false;

    /**
     * @ORM\Column(name="codigo_accion_fk", type="string", length=30, nullable=true)
     */
    private $codigoAccionFk;

    /**
     * @ORM\ManyToOne(targetEntity="Norma", inversedBy="articulosNormaRel")
     * @ORM\JoinColumn(name="codigo_norma_fk", referencedColumnName="codigo_norma_pk")
     */
    private $normaRel;

    /**
     * @ORM\ManyToOne(targetEntity="Accion", inversedBy="articulosAccionRel")
     * @ORM\JoinColumn(name="codigo_accion_fk", referencedColumnName="codigo_accion_pk")
     */
    private $accionRel;

    /**
     * @return mixed
     */
    public function getCodigoArticuloPk()
    {
        return $this->codigoArticuloPk;
    }

    /**
     * @param mixed $codigoArticuloPk
     */
    public function setCodigoArticuloPk($codigoArticuloPk): void
    {
        $this->codigoArticuloPk = $codigoArticuloPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoNormaFk()
    {
        return $this->codigoNormaFk;
    }

    /**
     * @param mixed $codigoNormaFk
     */
    public function setCodigoNormaFk($codigoNormaFk): void
    {
        $this->codigoNormaFk = $codigoNormaFk;
    }

    /**
     * @return mixed
     */
    public function getObligacion()
    {
        return $this->obligacion;
    }

    /**
     * @param mixed $obligacion
     */
    public function setObligacion($obligacion): void
    {
        $this->obligacion = $obligacion;
    }

    /**
     * @return mixed
     */
    public function getVerificable()
    {
        return $this->verificable;
    }

    /**
     * @param mixed $verificable
     */
    public function setVerificable($verificable): void
    {
        $this->verificable = $verificable;
    }

    /**
     * @return mixed
     */
    public function getCodigoAccionFk()
    {
        return $this->codigoAccionFk;
    }

    /**
     * @param mixed $codigoAccionFk
     */
    public function setCodigoAccionFk($codigoAccionFk): void
    {
        $this->codigoAccionFk = $codigoAccionFk;
    }

    /**
     * @return mixed
     */
    public function getNormaRel()
    {
        return $this->normaRel;
    }

    /**
     * @param mixed $normaRel
     */
    public function setNormaRel($normaRel): void
    {
        $this->normaRel = $normaRel;
    }

    /**
     * @return mixed
     */
    public function getAccionRel()
    {
        return $this->accionRel;
    }

    /**
     * @param mixed $accionRel
     */
    public function setAccionRel($accionRel): void
    {
        $this->accionRel = $accionRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoDerogado()
    {
        return $this->estadoDerogado;
    }

    /**
     * @param mixed $estadoDerogado
     */
    public function setEstadoDerogado($estadoDerogado): void
    {
        $this->estadoDerogado = $estadoDerogado;
    }



}
