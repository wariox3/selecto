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
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo = 0;

    /**
     * @ORM\Column(name="operacion_inventario", type="smallint", nullable=true, options={"default" : 0})
     */
    private $operacionInventario = 0;

    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="documentoRel")
     */
    protected $movimientosDocumentoRel;

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
    public function getMovimientoDocumentoRel()
    {
        return $this->movimientoDocumentoRel;
    }

    /**
     * @param mixed $movimientoDocumentoRel
     */
    public function setMovimientoDocumentoRel($movimientoDocumentoRel): void
    {
        $this->movimientoDocumentoRel = $movimientoDocumentoRel;
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

}
