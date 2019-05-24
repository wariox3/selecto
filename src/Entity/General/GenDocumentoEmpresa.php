<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenDocumentoEmpresaRepository")
 */
class GenDocumentoEmpresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_documento_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoDocumentoEmpresaPk;

    /**
     * @ORM\Column(name="codigo_documento_fk", type="string", length=10, nullable=true)
     */
    private $codigoDocumentoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenDocumento", inversedBy="documentosEmpresasDocumentoRel")
     * @ORM\JoinColumn(name="codigo_documento_fk", referencedColumnName="codigo_documento_pk")
     */
    protected $documentoRel;

    /**
     * @return mixed
     */
    public function getCodigoDocumentoEmpresaPk()
    {
        return $this->codigoDocumentoEmpresaPk;
    }

    /**
     * @param mixed $codigoDocumentoEmpresaPk
     */
    public function setCodigoDocumentoEmpresaPk($codigoDocumentoEmpresaPk): void
    {
        $this->codigoDocumentoEmpresaPk = $codigoDocumentoEmpresaPk;
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
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return mixed
     */
    public function getDocumentoRel()
    {
        return $this->documentoRel;
    }

    /**
     * @param mixed $documentoRel
     */
    public function setDocumentoRel($documentoRel): void
    {
        $this->documentoRel = $documentoRel;
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



}
