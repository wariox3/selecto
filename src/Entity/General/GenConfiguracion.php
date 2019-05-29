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


}
