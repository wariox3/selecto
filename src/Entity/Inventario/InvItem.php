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
     * @ORM\Column(name="codigo_impuesto_retencion_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoRetencionFk;

    /**
     * @ORM\Column(name="codigo_impuesto_iva_venta_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoIvaVentaFk;

    /**
     * @ORM\Column(name="vr_precio", type="float", nullable=true, options={"default" : 0})
     */
    private $vrPrecio;

    /**
     * @ORM\Column(name="producto", type="boolean", nullable=true, options={"default":false})
     */
    private $producto = false;

    /**
     * @ORM\Column(name="servicio", type="boolean", nullable=true, options={"default":false})
     */
    private $servicio = false;

    /**
     * @ORM\Column(name="afecta_inventario", type="boolean", nullable=true, options={"default":false})
     */
    private $afectaInventario = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenImpuesto", inversedBy="itemsImpuestoRetencionRel")
     * @ORM\JoinColumn(name="codigo_impuesto_retencion_fk",referencedColumnName="codigo_impuesto_pk")
     */
    protected $impuestoRetencionRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenImpuesto", inversedBy="itemsImpuestoIvaVentaRel")
     * @ORM\JoinColumn(name="codigo_impuesto_iva_venta_fk",referencedColumnName="codigo_impuesto_pk")
     */
    protected $impuestoIvaVentaRel;

    /**
     * @ORM\OneToMany(targetEntity="InvMovimientoDetalle", mappedBy="itemRel")
     */
    protected $movimientosDetallesItemRel;

    /**
     * @ORM\OneToMany(targetEntity="InvContratoDetalle", mappedBy="itemRel")
     */
    protected $contratosDetallesItemRel;


}
