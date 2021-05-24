<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegimenRepository")
 */
class Regimen
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=3, nullable=false, unique=true)
     */
    private $codigoRegimenPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_interface", type="string", length=3, nullable=true)
     */
    private $codigoInterface;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tercero", mappedBy="regimenRel")
     */
    protected $tercerosRegimenRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Empresa", mappedBy="regimenRel")
     */
    protected $empresasRegimenRel;

    /**
     * @return mixed
     */
    public function getCodigoRegimenPk()
    {
        return $this->codigoRegimenPk;
    }

    /**
     * @param mixed $codigoRegimenPk
     */
    public function setCodigoRegimenPk($codigoRegimenPk): void
    {
        $this->codigoRegimenPk = $codigoRegimenPk;
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
    public function getCodigoInterface()
    {
        return $this->codigoInterface;
    }

    /**
     * @param mixed $codigoInterface
     */
    public function setCodigoInterface($codigoInterface): void
    {
        $this->codigoInterface = $codigoInterface;
    }

    /**
     * @return mixed
     */
    public function getTercerosRegimenRel()
    {
        return $this->tercerosRegimenRel;
    }

    /**
     * @param mixed $tercerosRegimenRel
     */
    public function setTercerosRegimenRel($tercerosRegimenRel): void
    {
        $this->tercerosRegimenRel = $tercerosRegimenRel;
    }

    /**
     * @return mixed
     */
    public function getEmpresasRegimenRel()
    {
        return $this->empresasRegimenRel;
    }

    /**
     * @param mixed $empresasRegimenRel
     */
    public function setEmpresasRegimenRel($empresasRegimenRel): void
    {
        $this->empresasRegimenRel = $empresasRegimenRel;
    }



}