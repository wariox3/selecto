<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovimientoTipoEmpresaRepository")
 */
class MovimientoTipoEmpresa
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_movimiento_tipo_empresa_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoMovimientoTipoEmpresaPk;

    /**
     * @ORM\Column(name="codigo_movimiento_tipo_fk", type="string", length=10, nullable=true)
     */
    private $codigoMovimientoTipoFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="string",length=10, nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\Column(name="consecutivo", type="integer")
     */
    private $consecutivo = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MovimientoTipo", inversedBy="movimientosTiposEmpresasMovimientoTipoRel")
     * @ORM\JoinColumn(name="codigo_movimiento_tipo_fk", referencedColumnName="codigo_movimiento_tipo_pk")
     */
    protected $movimientoTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoMovimientoTipoEmpresaPk()
    {
        return $this->codigoMovimientoTipoEmpresaPk;
    }

    /**
     * @param mixed $codigoMovimientoTipoEmpresaPk
     */
    public function setCodigoMovimientoTipoEmpresaPk($codigoMovimientoTipoEmpresaPk): void
    {
        $this->codigoMovimientoTipoEmpresaPk = $codigoMovimientoTipoEmpresaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoMovimientoTipoFk()
    {
        return $this->codigoMovimientoTipoFk;
    }

    /**
     * @param mixed $codigoMovimientoTipoFk
     */
    public function setCodigoMovimientoTipoFk($codigoMovimientoTipoFk): void
    {
        $this->codigoMovimientoTipoFk = $codigoMovimientoTipoFk;
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
     * @return int
     */
    public function getConsecutivo(): int
    {
        return $this->consecutivo;
    }

    /**
     * @param int $consecutivo
     */
    public function setConsecutivo(int $consecutivo): void
    {
        $this->consecutivo = $consecutivo;
    }

    /**
     * @return mixed
     */
    public function getMovimientoTipoRel()
    {
        return $this->movimientoTipoRel;
    }

    /**
     * @param mixed $movimientoTipoRel
     */
    public function setMovimientoTipoRel($movimientoTipoRel): void
    {
        $this->movimientoTipoRel = $movimientoTipoRel;
    }


}
