<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RhuContratoMotivo
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuContratoMotivoRepository")
 */
class RhuContratoMotivo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_motivo_pk", type="string", length=10)
     */
    private $codigoContratoMotivoPk;
    
    /**
     * @ORM\Column(name="motivo", type="string", length=80, nullable=true)
     */    
    private $motivo;
    


    /**
     * @return mixed
     */
    public function getCodigoContratoMotivoPk()
    {
        return $this->codigoContratoMotivoPk;
    }

    /**
     * @param mixed $codigoContratoMotivoPk
     */
    public function setCodigoContratoMotivoPk($codigoContratoMotivoPk): void
    {
        $this->codigoContratoMotivoPk = $codigoContratoMotivoPk;
    }

    /**
     * @return mixed
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo): void
    {
        $this->motivo = $motivo;
    }

    /**
     * @return mixed
     */
    public function getContratosContratoMotivoRel()
    {
        return $this->contratosContratoMotivoRel;
    }

    /**
     * @param mixed $contratosContratoMotivoRel
     */
    public function setContratosContratoMotivoRel($contratosContratoMotivoRel): void
    {
        $this->contratosContratoMotivoRel = $contratosContratoMotivoRel;
    }
}
