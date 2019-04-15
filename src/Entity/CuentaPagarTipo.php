<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaPagarTipoType
 *
 * @ORM\Table(name="cuenta_pagar_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\CuentaPagarTipoRepository")
 */
class CuentaPagarTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_pagar_tipo_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCuentaPagarTipoPk;

    /**
     * @ORM\Column(name="codigo_documento_fk", type="integer", length=10, nullable=true)
     */
    private $codigoDocumentoFk;

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
     * @ORM\ManyToOne(targetEntity="Documento", inversedBy="cuentaPagarTipoDocumentoRel")
     * @ORM\JoinColumn(name="codigo_documento_fk", referencedColumnName="codigo_documento_pk")
     */
    private $documentoPagarTipoRel;

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
    public function getCodigoDocumentoFk()
    {
        return $this->codigoDocumentoFk;
    }

    /**
     * @param mixed $codigoDocumentoFk
     */
    public function setCodigoDocumentoFk($codigoDocumentoFk): void
    {
        $this->codigoDocumentoFk = $codigoDocumentoFk;
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
