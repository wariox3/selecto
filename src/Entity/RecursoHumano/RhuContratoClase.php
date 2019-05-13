<?php

namespace App\Entity\RecursoHumano;

use Doctrine\ORM\Mapping as ORM;

/**
 * RH
 *
 * @ORM\Entity(repositoryClass="App\Repository\RecursoHumano\RhuContratoClaseRepository")
 */
class RhuContratoClase
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_contrato_clase_pk", type="string", length=10)
     */
    private $codigoContratoClasePk;        
    
    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */    
    private $nombre;                      
    
    /**     
     * @ORM\Column(name="indefinido", type="boolean",options={"default":false})
     */    
    private $indefinido = false;
    
    /**
     * @ORM\OneToMany(targetEntity="RhuContrato", mappedBy="contratoClaseRel")
     */
    protected $contratosContratoClaseRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuClasificacionRiesgo", inversedBy="contratosClasificacionRiesgoRel")
     * @ORM\JoinColumn(name="codigo_clasificacion_riesgo_fk",referencedColumnName="codigo_clasificacion_riesgo_pk")
     */
    protected $clasificacionRiesgoRel;


    /**
     * @ORM\ManyToOne(targetEntity="RhuTiempo", inversedBy="contratosTiempoRel")
     * @ORM\JoinColumn(name="codigo_tiempo_fk",referencedColumnName="codigo_tiempo_pk")
     */
    protected $tiempoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuSalud", inversedBy="contratosSaludRel")
     * @ORM\JoinColumn(name="codigo_salud_fk",referencedColumnName="codigo_salud_pk")
     */
    protected $saludRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuCargo", inversedBy="contratosCargoRel")
     * @ORM\JoinColumn(name="codigo_cargo_fk",referencedColumnName="codigo_cargo_pk")
     */
    protected $cargoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuGrupo", inversedBy="contratosGrupoRel")
     * @ORM\JoinColumn(name="codigo_grupo_fk",referencedColumnName="codigo_grupo_pk")
     */
    protected $grupoRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadSaludRel")
     * @ORM\JoinColumn(name="codigo_entidad_salud_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadSaludRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadPensionRel")
     * @ORM\JoinColumn(name="codigo_entidad_pension_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadPensionRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadCesantiaRel")
     * @ORM\JoinColumn(name="codigo_entidad_censantia_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadCesantiaRel;

    /**
     * @ORM\ManyToOne(targetEntity="RhuEntidad", inversedBy="contratosEntidadCajaRel")
     * @ORM\JoinColumn(name="codigo_entidad_caja_fk",referencedColumnName="codigo_entidad_pk")
     */
    protected $entidadCajaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="rhuContratosCiudadContratoRel")
     * @ORM\JoinColumn(name="codigo_ciudad_contrato_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadContratoRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="rhuContratosCiudadLaboraRel")
     * @ORM\JoinColumn(name="codigo_ciudad_labora_fk",referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadLaboraRel;



    /**
     * @ORM\OneToMany(targetEntity="RhuProgramacionDetalle", mappedBy="contratoRel")
     */
    protected $programacionesDetallesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuNovedad", mappedBy="contratoRel")
     */
    protected $novedadesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuCredito", mappedBy="contratoRel")
     */
    protected $creditosContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuVacacion", mappedBy="contratoRel")
     */
    protected $vacacionesContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="RhuPago", mappedBy="contratoRel")
     */
    protected $pagosContratoRel;

    /**
     * @return mixed
     */
    public function getCodigoContratoClasePk()
    {
        return $this->codigoContratoClasePk;
    }

    /**
     * @param mixed $codigoContratoClasePk
     */
    public function setCodigoContratoClasePk($codigoContratoClasePk): void
    {
        $this->codigoContratoClasePk = $codigoContratoClasePk;
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
    public function getIndefinido()
    {
        return $this->indefinido;
    }

    /**
     * @param mixed $indefinido
     */
    public function setIndefinido($indefinido): void
    {
        $this->indefinido = $indefinido;
    }

    /**
     * @return mixed
     */
    public function getContratosContratoClaseRel()
    {
        return $this->contratosContratoClaseRel;
    }

    /**
     * @param mixed $contratosContratoClaseRel
     */
    public function setContratosContratoClaseRel($contratosContratoClaseRel): void
    {
        $this->contratosContratoClaseRel = $contratosContratoClaseRel;
    }

    /**
     * @return mixed
     */
    public function getContratosTiposContratoClaseRel()
    {
        return $this->contratosTiposContratoClaseRel;
    }

    /**
     * @param mixed $contratosTiposContratoClaseRel
     */
    public function setContratosTiposContratoClaseRel($contratosTiposContratoClaseRel): void
    {
        $this->contratosTiposContratoClaseRel = $contratosTiposContratoClaseRel;
    }
}
