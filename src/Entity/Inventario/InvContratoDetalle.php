<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContratoDetalleType
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvContratoDetalleRepository")
 */
class InvContratoDetalle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_detalle_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoContratoDetallePk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_contrato_fk", type="integer", nullable=true)
     */
    private $codigoContratoFk;

    /**
     * @ORM\Column(name="codigo_item_fk", type="integer", nullable=true)
     */
    private $codigoItemFk;

    /**
     * @ORM\Column(name="cantidad", type="float", nullable=true, options={"default" : 0})
     */
    private $cantidad = 0;

    /**
     * @ORM\Column(name="vr_precio", type="float", nullable=true, options={"default" : 0})
     */
    private $vrPrecio = 0;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSubtotal;

    /**
     * @ORM\Column(name="porcentaje_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentajeIva = 0;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true, options={"default" : 0})
     */
    private $vrIva = 0;

    /**
     * @ORM\Column(name="vr_total", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotal;

    /**
     * @ORM\ManyToOne(targetEntity="InvContrato", inversedBy="contratosDetallesContratoRel")
     * @ORM\JoinColumn(name="codigo_contrato_fk", referencedColumnName="codigo_contrato_pk")
     */
    protected $contratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="InvItem", inversedBy="contratosDetallesItemRel")
     * @ORM\JoinColumn(name="codigo_item_fk", referencedColumnName="codigo_item_pk")
     */
    protected $itemRel;


}
