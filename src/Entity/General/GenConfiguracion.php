<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\General\GenConfiguracionRepository")
 */
class GenConfiguracion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="integer")
     */
    private $codigoConfiguracionPk;

    /**
     * @ORM\Column(name="formato_factura", type="string", length=1, nullable=true)
     */
    private $formatoFactura;
    /**
     * @ORM\Column(name="porcentaje_interes_mora", type="float", options={"default":0} , nullable=true)
     */
    private $porcentajeInteresMora = 0;

    /**
     * @ORM\Column(name="codigo_item_interes_mora", type="integer", nullable=true)
     */
    private $codigoItemInteresMora;

    /**
     * @ORM\Column(name="genera_interes_mora", type="boolean", nullable=true, options={"default" : false})
     */
    private $generaInteresMora = false;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk($codigoConfiguracionPk): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getFormatoFactura()
    {
        return $this->formatoFactura;
    }

    /**
     * @param mixed $formatoFactura
     */
    public function setFormatoFactura($formatoFactura): void
    {
        $this->formatoFactura = $formatoFactura;
    }

    /**
     * @return int
     */
    public function getPorcentajeInteresMora(): int
    {
        return $this->porcentajeInteresMora;
    }

    /**
     * @param int $porcentajeInteresMora
     */
    public function setPorcentajeInteresMora(int $porcentajeInteresMora): void
    {
        $this->porcentajeInteresMora = $porcentajeInteresMora;
    }

    /**
     * @return mixed
     */
    public function getCodigoItemInteresMora()
    {
        return $this->codigoItemInteresMora;
    }

    /**
     * @param mixed $codigoItemInteresMora
     */
    public function setCodigoItemInteresMora($codigoItemInteresMora): void
    {
        $this->codigoItemInteresMora = $codigoItemInteresMora;
    }

    /**
     * @return bool
     */
    public function isGeneraInteresMora(): bool
    {
        return $this->generaInteresMora;
    }

    /**
     * @param bool $generaInteresMora
     */
    public function setGeneraInteresMora(bool $generaInteresMora): void
    {
        $this->generaInteresMora = $generaInteresMora;
    }



}
