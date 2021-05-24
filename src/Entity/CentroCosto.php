<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemType
 * @ORM\Entity(repositoryClass="App\Repository\CentroCostoRepository")
 */
class CentroCosto
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_centro_costo_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCentroCostoPk;

    /**
     * @ORM\Column(name="codigo", type="string",length=10, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movimiento", mappedBy="centroCostoRel")
     */
    protected $movimientosCentroCostoRel;

    /**
     * @return mixed
     */
    public function getCodigoCentroCostoPk()
    {
        return $this->codigoCentroCostoPk;
    }

    /**
     * @param mixed $codigoCentroCostoPk
     */
    public function setCodigoCentroCostoPk($codigoCentroCostoPk): void
    {
        $this->codigoCentroCostoPk = $codigoCentroCostoPk;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo): void
    {
        $this->codigo = $codigo;
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
    public function getMovimientosCentroCostoRel()
    {
        return $this->movimientosCentroCostoRel;
    }

    /**
     * @param mixed $movimientosCentroCostoRel
     */
    public function setMovimientosCentroCostoRel($movimientosCentroCostoRel): void
    {
        $this->movimientosCentroCostoRel = $movimientosCentroCostoRel;
    }


}
