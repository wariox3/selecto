<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemType
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvItemRepository")
 */
class InvItem
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_item_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoItemPk;

    /**
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="referencia", type="string",length=50, nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(name="cantidad_existencia", type="integer", nullable=true, options={"default" : 0})
     */
    private $cantidadExistencia = 0;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="porcentaje_iva", type="integer", nullable=true)
     */
    private $porcentajeIva = 0;

    /**
     * @ORM\Column(name="vr_precio", type="float", nullable=true, options={"default" : 0})
     */
    private $vrPrecio;

    /**
     * @ORM\Column(name="servicio", type="boolean", nullable=true, options={"default" : false})
     */
    private $servicio = false;

    /**
     * @ORM\OneToMany(targetEntity="InvMovimientoDetalle", mappedBy="itemRel")
     */
    protected $movimientosDetallesItemRel;

    /**
     * @ORM\OneToMany(targetEntity="InvContratoDetalle", mappedBy="itemRel")
     */
    protected $contratosDetallesItemRel;

    /**
     * @return mixed
     */
    public function getCodigoItemPk()
    {
        return $this->codigoItemPk;
    }

    /**
     * @param mixed $codigoItemPk
     */
    public function setCodigoItemPk($codigoItemPk): void
    {
        $this->codigoItemPk = $codigoItemPk;
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
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     */
    public function setReferencia($referencia): void
    {
        $this->referencia = $referencia;
    }

    /**
     * @return mixed
     */
    public function getCantidadExistencia()
    {
        return $this->cantidadExistencia;
    }

    /**
     * @param mixed $cantidadExistencia
     */
    public function setCantidadExistencia($cantidadExistencia): void
    {
        $this->cantidadExistencia = $cantidadExistencia;
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
    public function getPorcentajeIva()
    {
        return $this->porcentajeIva;
    }

    /**
     * @param mixed $porcentajeIva
     */
    public function setPorcentajeIva($porcentajeIva): void
    {
        $this->porcentajeIva = $porcentajeIva;
    }

    /**
     * @return mixed
     */
    public function getMovimientosDetallesItemRel()
    {
        return $this->movimientosDetallesItemRel;
    }

    /**
     * @param mixed $movimientosDetallesItemRel
     */
    public function setMovimientosDetallesItemRel($movimientosDetallesItemRel): void
    {
        $this->movimientosDetallesItemRel = $movimientosDetallesItemRel;
    }

    /**
     * @return mixed
     */
    public function getContratosDetallesItemRel()
    {
        return $this->contratosDetallesItemRel;
    }

    /**
     * @param mixed $contratosDetallesItemRel
     */
    public function setContratosDetallesItemRel($contratosDetallesItemRel): void
    {
        $this->contratosDetallesItemRel = $contratosDetallesItemRel;
    }

    /**
     * @return mixed
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * @param mixed $servicio
     */
    public function setServicio($servicio): void
    {
        $this->servicio = $servicio;
    }

    /**
     * @return mixed
     */
    public function getVrPrecio()
    {
        return $this->vrPrecio;
    }

    /**
     * @param mixed $vrPrecio
     */
    public function setVrPrecio($vrPrecio): void
    {
        $this->vrPrecio = $vrPrecio;
    }


}
