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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvDocumentoEmpresa", mappedBy="documentoRel")
     */
    protected $documentosEmpresasDocumentoRel;

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
     * @return bool
     */
    public function isGeneraCartera(): bool
    {
        return $this->generaCartera;
    }

    /**
     * @param bool $generaCartera
     */
    public function setGeneraCartera(bool $generaCartera): void
    {
        $this->generaCartera = $generaCartera;
    }

    /**
     * @return bool
     */
    public function isGeneraTesoreria(): bool
    {
        return $this->generaTesoreria;
    }

    /**
     * @param bool $generaTesoreria
     */
    public function setGeneraTesoreria(bool $generaTesoreria): void
    {
        $this->generaTesoreria = $generaTesoreria;
    }

    /**
     * @return int
     */
    public function getOperacionInventario(): int
    {
        return $this->operacionInventario;
    }

    /**
     * @param int $operacionInventario
     */
    public function setOperacionInventario(int $operacionInventario): void
    {
        $this->operacionInventario = $operacionInventario;
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
    public function getDocumentosEmpresasDocumentoRel()
    {
        return $this->documentosEmpresasDocumentoRel;
    }

    /**
     * @param mixed $documentosEmpresasDocumentoRel
     */
    public function setDocumentosEmpresasDocumentoRel($documentosEmpresasDocumentoRel): void
    {
        $this->documentosEmpresasDocumentoRel = $documentosEmpresasDocumentoRel;
    }



}
