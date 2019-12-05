<?php


namespace App\Entity\General;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenIdentificacionRepository")
 */
class GenIdentificacion
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=3, nullable=false, unique=true)
     */
    private $codigoIdentificacionPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="identificacionRel")
     */
    protected $EmpleadosIdentificacionRel;


}