<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemType
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoItemPk;

    /**
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="MovimientoDetalle", mappedBy="itemRel")
     */
    protected $movimientosDetallesItemRel;

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



}
