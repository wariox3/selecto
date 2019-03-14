<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoClientePk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=255, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\OneToMany(targetEntity="Centro", mappedBy="clienteRel")
     */
    protected $centrosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Malla", mappedBy="clienteRel")
     */
    protected $mallasClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="clienteRel")
     */
    protected $usuariosClienteRel;

    /**
     * @return mixed
     */
    public function getCodigoClientePk()
    {
        return $this->codigoClientePk;
    }

    /**
     * @param mixed $codigoClientePk
     */
    public function setCodigoClientePk($codigoClientePk): void
    {
        $this->codigoClientePk = $codigoClientePk;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getCentrosClienteRel()
    {
        return $this->centrosClienteRel;
    }

    /**
     * @param mixed $centrosClienteRel
     */
    public function setCentrosClienteRel($centrosClienteRel): void
    {
        $this->centrosClienteRel = $centrosClienteRel;
    }

    /**
     * @return mixed
     */
    public function getMallasClienteRel()
    {
        return $this->mallasClienteRel;
    }

    /**
     * @param mixed $mallasClienteRel
     */
    public function setMallasClienteRel($mallasClienteRel): void
    {
        $this->mallasClienteRel = $mallasClienteRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosClienteRel()
    {
        return $this->usuariosClienteRel;
    }

    /**
     * @param mixed $usuariosClienteRel
     */
    public function setUsuariosClienteRel($usuariosClienteRel): void
    {
        $this->usuariosClienteRel = $usuariosClienteRel;
    }



}
