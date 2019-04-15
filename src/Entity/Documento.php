<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentoType
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentoRepository")
 */
class Documento
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
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo = 0;

    /**
     * @ORM\Column(name="operacion_inventario", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionInventario = 0;

    /**
     * @ORM\Column(name="codigo_cuenta_cobrar_tipo_fk", type="integer", nullable=true)
     */
    private $codigoCuentaCobrarTipoFk;

    /**
     * @ORM\Column(name="codigo_cuenta_pagar_tipo_fk", type="integer", nullable=true)
     */
    private $codigoCuentaPagarTipoFk;

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="documentoRel")
     */
    protected $movimientosDocumentoRel;

    /**
     * @ORM\ManyToOne(targetEntity="CuentaCobrarTipo", inversedBy="documentoCobrarTipoRel")
     * @ORM\JoinColumn(name="codigo_cuenta_cobrar_tipo_fk", referencedColumnName="codigo_cuenta_cobrar_tipo_pk")
     */
    protected $cuentaCobrarTipoDocumentoRel;

    /**
     * @ORM\ManyToOne(targetEntity="CuentaPagarTipo", inversedBy="documentoPagarTipoRel")
     * @ORM\JoinColumn(name="codigo_cuenta_pagar_tipo_fk", referencedColumnName="codigo_cuenta_pagar_tipo_pk")
     */
    protected $cuentaPagarTipoDocumentoRel;

    /**
     * @return mixed
     */
    public function getCodigoDocumentoPk()
    {
        return $this->codigoDocumentoPk;
    }

    /**
     * @param mixed $codigoDocumentoPk
     */
    public function setCodigoDocumentoPk($codigoDocumentoPk): void
    {
        $this->codigoDocumentoPk = $codigoDocumentoPk;
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
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * @param mixed $abreviatura
     */
    public function setAbreviatura($abreviatura): void
    {
        $this->abreviatura = $abreviatura;
    }

    /**
     * @return mixed
     */
    public function getGeneraCartera()
    {
        return $this->generaCartera;
    }

    /**
     * @param mixed $generaCartera
     */
    public function setGeneraCartera($generaCartera): void
    {
        $this->generaCartera = $generaCartera;
    }

    /**
     * @return mixed
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * @param mixed $consecutivo
     */
    public function setConsecutivo($consecutivo): void
    {
        $this->consecutivo = $consecutivo;
    }

    /**
     * @return mixed
     */
    public function getOperacionInventario()
    {
        return $this->operacionInventario;
    }

    /**
     * @param mixed $operacionInventario
     */
    public function setOperacionInventario($operacionInventario): void
    {
        $this->operacionInventario = $operacionInventario;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaCobrarTipoFk()
    {
        return $this->codigoCuentaCobrarTipoFk;
    }

    /**
     * @param mixed $codigoCuentaCobrarTipoFk
     */
    public function setCodigoCuentaCobrarTipoFk($codigoCuentaCobrarTipoFk): void
    {
        $this->codigoCuentaCobrarTipoFk = $codigoCuentaCobrarTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoCuentaPagarTipoFk()
    {
        return $this->codigoCuentaPagarTipoFk;
    }

    /**
     * @param mixed $codigoCuentaPagarTipoFk
     */
    public function setCodigoCuentaPagarTipoFk($codigoCuentaPagarTipoFk): void
    {
        $this->codigoCuentaPagarTipoFk = $codigoCuentaPagarTipoFk;
    }

    /**
     * @return mixed
     */
    public function getMovimientosDocumentoRel()
    {
        return $this->movimientosDocumentoRel;
    }

    /**
     * @param mixed $movimientosDocumentoRel
     */
    public function setMovimientosDocumentoRel($movimientosDocumentoRel): void
    {
        $this->movimientosDocumentoRel = $movimientosDocumentoRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaCobrarTipoDocumentoRel()
    {
        return $this->cuentaCobrarTipoDocumentoRel;
    }

    /**
     * @param mixed $cuentaCobrarTipoDocumentoRel
     */
    public function setCuentaCobrarTipoDocumentoRel($cuentaCobrarTipoDocumentoRel): void
    {
        $this->cuentaCobrarTipoDocumentoRel = $cuentaCobrarTipoDocumentoRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaPagarTipoDocumentoRel()
    {
        return $this->cuentaPagarTipoDocumentoRel;
    }

    /**
     * @param mixed $cuentaPagarTipoDocumentoRel
     */
    public function setCuentaPagarTipoDocumentoRel($cuentaPagarTipoDocumentoRel): void
    {
        $this->cuentaPagarTipoDocumentoRel = $cuentaPagarTipoDocumentoRel;
    }

}
