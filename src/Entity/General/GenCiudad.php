<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\General\GenCiudadRepository")
 */
class GenCiudad
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_ciudad_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoCiudadPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_departamento_fk", type="integer")
     */
    private $codigoDepartamentoFk;

    /**
     * @ORM\Column(name="codigo_dane", type="string", length=5)
     */
    private $codigoDane;

    /**
     * @ORM\ManyToOne(targetEntity="GenDepartamento", inversedBy="ciudadesRel")
     * @ORM\JoinColumn(name="codigo_departamento_fk", referencedColumnName="codigo_departamento_pk")
     */
    protected $departamentoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\General\GenTercero", mappedBy="ciudadRel")
     */
    private $ciudadTerceroRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadRel")
     */
    protected $EmpleadosCiudadRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadExpedicionRel")
     */
    protected $rhuEmpleadosCiudadExpedicionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="ciudadNacimientoRel")
     */
    protected $EmpleadosCiudadNacimientoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuContrato", mappedBy="ciudadContratoRel")
     */
    protected $rhuContratosCiudadContratoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuContrato", mappedBy="ciudadLaboraRel")
     */
    protected $rhuContratosCiudadLaboraRel;


}
