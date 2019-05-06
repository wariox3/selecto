<?php

namespace App\Entity\Inventario;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContratoType
 *
 * @ORM\Table(name="contrato")
 * @ORM\Entity(repositoryClass="App\Repository\Inventario\InvContratoRepository")
 */
class InvContrato
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoContratoPk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="codigo_tercero_fk", type="integer", nullable=true)
     */
    private $codigoTerceroFk;

    /**
     * @ORM\Column(name="vr_subtotal", type="float", nullable=true, options={"default" : 0})
     */
    private $vrSubtotal;

    /**
     * @ORM\Column(name="vr_total_bruto", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotalBruto;

    /**
     * @ORM\Column(name="vr_total_neto", type="float", nullable=true, options={"default" : 0})
     */
    private $vrTotalNeto;

    /**
     * @ORM\Column(name="vr_iva", type="float", nullable=true)
     */
    private $vrIva;

    /**
     * @ORM\Column(name="estado_autorizado", type="boolean", options={"default":false})
     */
    private $estadoAutorizado = false;

    /**
     * @ORM\Column(name="estado_aprobado", type="boolean", options={"default":false})
     */
    private $estadoAprobado = false;

    /**
     * @ORM\Column(name="estado_anulado", type="boolean", options={"default":false})
     */
    private $estadoAnulado = false;

    /**
     * @ORM\ManyToOne(targetEntity="InvTercero", inversedBy="contratosTerceroRel")
     * @ORM\JoinColumn(name="codigo_tercero_fk", referencedColumnName="codigo_tercero_pk")
     */
    protected $terceroRel;

    /**
     * @ORM\OneToMany(targetEntity="InvContratoDetalle", mappedBy="contratoRel")
     */
    protected $contratosDetallesContratoRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoPk()
    {
        return $this->codigoContratoPk;
    }

    /**
     * @param mixed $codigoContratoPk
     */
    public function setCodigoContratoPk($codigoContratoPk): void
    {
        $this->codigoContratoPk = $codigoContratoPk;
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
    public function getCodigoTerceroFk()
    {
        return $this->codigoTerceroFk;
    }

    /**
     * @param mixed $codigoTerceroFk
     */
    public function setCodigoTerceroFk($codigoTerceroFk): void
    {
        $this->codigoTerceroFk = $codigoTerceroFk;
    }

    /**
     * @return mixed
     */
    public function getVrSubtotal()
    {
        return $this->vrSubtotal;
    }

    /**
     * @param mixed $vrSubtotal
     */
    public function setVrSubtotal($vrSubtotal): void
    {
        $this->vrSubtotal = $vrSubtotal;
    }

    /**
     * @return mixed
     */
    public function getVrTotalBruto()
    {
        return $this->vrTotalBruto;
    }

    /**
     * @param mixed $vrTotalBruto
     */
    public function setVrTotalBruto($vrTotalBruto): void
    {
        $this->vrTotalBruto = $vrTotalBruto;
    }

    /**
     * @return mixed
     */
    public function getVrTotalNeto()
    {
        return $this->vrTotalNeto;
    }

    /**
     * @param mixed $vrTotalNeto
     */
    public function setVrTotalNeto($vrTotalNeto): void
    {
        $this->vrTotalNeto = $vrTotalNeto;
    }

    /**
     * @return mixed
     */
    public function getVrIva()
    {
        return $this->vrIva;
    }

    /**
     * @param mixed $vrIva
     */
    public function setVrIva($vrIva): void
    {
        $this->vrIva = $vrIva;
    }

    /**
     * @return mixed
     */
    public function getEstadoAutorizado()
    {
        return $this->estadoAutorizado;
    }

    /**
     * @param mixed $estadoAutorizado
     */
    public function setEstadoAutorizado($estadoAutorizado): void
    {
        $this->estadoAutorizado = $estadoAutorizado;
    }

    /**
     * @return mixed
     */
    public function getEstadoAprobado()
    {
        return $this->estadoAprobado;
    }

    /**
     * @param mixed $estadoAprobado
     */
    public function setEstadoAprobado($estadoAprobado): void
    {
        $this->estadoAprobado = $estadoAprobado;
    }

    /**
     * @return mixed
     */
    public function getEstadoAnulado()
    {
        return $this->estadoAnulado;
    }

    /**
     * @param mixed $estadoAnulado
     */
    public function setEstadoAnulado($estadoAnulado): void
    {
        $this->estadoAnulado = $estadoAnulado;
    }

    /**
     * @return mixed
     */
    public function getTerceroRel()
    {
        return $this->terceroRel;
    }

    /**
     * @param mixed $terceroRel
     */
    public function setTerceroRel($terceroRel): void
    {
        $this->terceroRel = $terceroRel;
    }

    /**
     * @return mixed
     */
    public function getContratosDetallesContratoRel()
    {
        return $this->contratosDetallesContratoRel;
    }

    /**
     * @param mixed $contratosDetallesContratoRel
     */
    public function setContratosDetallesContratoRel($contratosDetallesContratoRel): void
    {
        $this->contratosDetallesContratoRel = $contratosDetallesContratoRel;
    }



}
