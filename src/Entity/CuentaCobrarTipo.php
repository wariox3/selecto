<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CuentaCobrarTipoType
 *
 * @ORM\Table(name="cuenta_cobrar_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\CuentaCobrarTipoRepository")
 */
class CuentaCobrarTipo
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cuenta_cobrar_tipo_pk", type="string", length=5)
     */
    private $codigoCuentaCobrarTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="operacion", type="integer")
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="saldo_inicial", type="boolean", options={"default":false})
     */
    private $saldoInicial;

    /**
     * @ORM\Column(name="prefijo", type="string", length=5, nullable=true)
     */
    private $prefijo;

    /**
     * @ORM\OneToMany(targetEntity="CuentaCobrar", mappedBy="cuentaCobroTipoRel")
     */
    protected $cuentaCobroRel;

    /**
     * @ORM\OneToMany(targetEntity="Documento", mappedBy="cuentaCobrarTipoDocumentoRel")
     */
    protected $documentoCobrarTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoCuentaCobrarTipoPk()
    {
        return $this->codigoCuentaCobrarTipoPk;
    }

    /**
     * @param mixed $codigoCuentaCobrarTipoPk
     */
    public function setCodigoCuentaCobrarTipoPk($codigoCuentaCobrarTipoPk): void
    {
        $this->codigoCuentaCobrarTipoPk = $codigoCuentaCobrarTipoPk;
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
    public function getSaldoInicial()
    {
        return $this->saldoInicial;
    }

    /**
     * @param mixed $saldoInicial
     */
    public function setSaldoInicial($saldoInicial): void
    {
        $this->saldoInicial = $saldoInicial;
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
    public function getCuentaCobroRel()
    {
        return $this->cuentaCobroRel;
    }

    /**
     * @param mixed $cuentaCobroRel
     */
    public function setCuentaCobroRel($cuentaCobroRel): void
    {
        $this->cuentaCobroRel = $cuentaCobroRel;
    }

    /**
     * @return mixed
     */
    public function getDocumentoCobrarTipoRel()
    {
        return $this->documentoCobrarTipoRel;
    }

    /**
     * @param mixed $documentoCobrarTipoRel
     */
    public function setDocumentoCobrarTipoRel($documentoCobrarTipoRel): void
    {
        $this->documentoCobrarTipoRel = $documentoCobrarTipoRel;
    }

}
