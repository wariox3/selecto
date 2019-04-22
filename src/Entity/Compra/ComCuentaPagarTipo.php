<?php

namespace App\Entity\Compra;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaPagarTipoType
 *
 * @ORM\Table(name="cuenta_pagar_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\Compra\ComCuentaPagarTipoRepository")
 */
class ComCuentaPagarTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_pagar_tipo_pk", type="string", length=5)
     */
    private $codigoCuentaPagarTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="operacion", type="integer")
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="prefijo", type="string", length=5, nullable=true)
     */
    private $prefijo;

    /**
     * @ORM\OneToMany(targetEntity="ComCuentaPagar", mappedBy="cuentaPagarTipoRel")
     */
    protected $cuentaPagarRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvDocumento", mappedBy="cuentaPagarTipoDocumentoRel")
     */
    protected $documentoPagarTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoCuentaPagarTipoPk()
    {
        return $this->codigoCuentaPagarTipoPk;
    }

    /**
     * @param mixed $codigoCuentaPagarTipoPk
     */
    public function setCodigoCuentaPagarTipoPk($codigoCuentaPagarTipoPk): void
    {
        $this->codigoCuentaPagarTipoPk = $codigoCuentaPagarTipoPk;
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
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * @param mixed $operacion
     */
    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }

    /**
     * @return mixed
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * @param mixed $prefijo
     */
    public function setPrefijo($prefijo): void
    {
        $this->prefijo = $prefijo;
    }

    /**
     * @return mixed
     */
    public function getCuentaPagarRel()
    {
        return $this->cuentaPagarRel;
    }

    /**
     * @param mixed $cuentaPagarRel
     */
    public function setCuentaPagarRel($cuentaPagarRel): void
    {
        $this->cuentaPagarRel = $cuentaPagarRel;
    }

    /**
     * @return mixed
     */
    public function getDocumentoPagarTipoRel()
    {
        return $this->documentoPagarTipoRel;
    }

    /**
     * @param mixed $documentoPagarTipoRel
     */
    public function setDocumentoPagarTipoRel($documentoPagarTipoRel): void
    {
        $this->documentoPagarTipoRel = $documentoPagarTipoRel;
    }
}
