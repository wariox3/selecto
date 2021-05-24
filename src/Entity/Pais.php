<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaisRepository")
 */
class Pais
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_pais_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPaisPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departamento", mappedBy="paisRel")
     */
    protected $departamentosPaisRel;

    /**
     * @return mixed
     */
    public function getCodigoPaisPk()
    {
        return $this->codigoPaisPk;
    }

    /**
     * @param mixed $codigoPaisPk
     */
    public function setCodigoPaisPk($codigoPaisPk): void
    {
        $this->codigoPaisPk = $codigoPaisPk;
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
    public function getDepartamentosPaisRel()
    {
        return $this->departamentosPaisRel;
    }

    /**
     * @param mixed $departamentosPaisRel
     */
    public function setDepartamentosPaisRel($departamentosPaisRel): void
    {
        $this->departamentosPaisRel = $departamentosPaisRel;
    }


}
