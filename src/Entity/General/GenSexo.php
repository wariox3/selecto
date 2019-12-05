<?php


namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenSexoRepository")
 */
class GenSexo
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_sexo_pk", type="string", length=1, nullable=true)
     */
    private $codigoSexoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecursoHumano\RhuEmpleado", mappedBy="sexoRel")
     */
    protected $EmpleadosSexoRel;



}