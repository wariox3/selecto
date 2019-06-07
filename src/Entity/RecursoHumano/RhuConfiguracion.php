<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuConfiguracionRepository")
 */
class RhuConfiguracion
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="integer")
     */
    private $codigoConfiguracionPk;

    /**
     * @ORM\Column(name="vr_salario_minimo", type="float",options={"default":0}, nullable=true)
     */
    private $vrSalarioMinimo = 0;

    /**
     * @ORM\Column(name="codigo_concepto_auxilio_transporte_fk", type="string", length=10, nullable=true)
     */
    private $codigoConceptoAuxilioTransporteFk;

    /**
     * @ORM\Column(name="vr_auxilio_transporte", type="float", nullable=true)
     */
    private $vrAuxilioTransporte;

    /**
     * @ORM\Column(name="codigo_concepto_fondo_pension_fk", type="string", length=10, nullable=true)
     */
    private $codigoConceptoFondoPensionFk;

    /**
     * @ORM\Column(name="codigo_concepto_vacacion_fk", type="string", length=10, nullable=true)
     */
    private $codigoConceptoVacacionFk;

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
    public function getVrSalarioMinimo()
    {
        return $this->vrSalarioMinimo;
    }

    /**
     * @param mixed $vrSalarioMinimo
     */
    public function setVrSalarioMinimo($vrSalarioMinimo): void
    {
        $this->vrSalarioMinimo = $vrSalarioMinimo;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoAuxilioTransporteFk()
    {
        return $this->codigoConceptoAuxilioTransporteFk;
    }

    /**
     * @param mixed $codigoConceptoAuxilioTransporteFk
     */
    public function setCodigoConceptoAuxilioTransporteFk($codigoConceptoAuxilioTransporteFk): void
    {
        $this->codigoConceptoAuxilioTransporteFk = $codigoConceptoAuxilioTransporteFk;
    }

    /**
     * @return mixed
     */
    public function getVrAuxilioTransporte()
    {
        return $this->vrAuxilioTransporte;
    }

    /**
     * @param mixed $vrAuxilioTransporte
     */
    public function setVrAuxilioTransporte($vrAuxilioTransporte): void
    {
        $this->vrAuxilioTransporte = $vrAuxilioTransporte;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoFondoPensionFk()
    {
        return $this->codigoConceptoFondoPensionFk;
    }

    /**
     * @param mixed $codigoConceptoFondoPensionFk
     */
    public function setCodigoConceptoFondoPensionFk($codigoConceptoFondoPensionFk): void
    {
        $this->codigoConceptoFondoPensionFk = $codigoConceptoFondoPensionFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoConceptoVacacionFk()
    {
        return $this->codigoConceptoVacacionFk;
    }

    /**
     * @param mixed $codigoConceptoVacacionFk
     */
    public function setCodigoConceptoVacacionFk($codigoConceptoVacacionFk): void
    {
        $this->codigoConceptoVacacionFk = $codigoConceptoVacacionFk;
    }


}
