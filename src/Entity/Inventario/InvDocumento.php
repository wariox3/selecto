<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoType
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvDocumentoRepository")
 */
class InvDocumento
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_documento_pk", type="string", length=5)
     */
    private $codigoDocumentoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @ORM\Column(name="abreviatura", type="string", length=10)
     */
    private $abreviatura;

    /**
     * @ORM\Column(name="genera_cartera", type="boolean", options={"default":false})
     */
    private $generaCartera = false;

    /**
     * @ORM\Column(name="genera_tesoreria", type="boolean", options={"default":false})
     */
    private $generaTesoreria = false;

    /**
     * @ORM\Column(name="operacion_inventario", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionInventario = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvMovimiento", mappedBy="documentoRel")
     */
    protected $movimientosDocumentoRel;


}
