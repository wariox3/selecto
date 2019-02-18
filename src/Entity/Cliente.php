<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 *
 */
class Cliente
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_cliente_pk", type="integer", unique=true)
     */
    private $codigoClientePk;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=11, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_social", type="string", length=255, nullable=true)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comercial", type="string", length=255, nullable=true)
     */
    private $nombreComercial;

    /**
     *
     * @ORM\OneToMany(targetEntity="Llamada", mappedBy="clienteRel")
     */

    private $llamadasClienteRel;

    /**
     *
     * @ORM\OneToMany(targetEntity="Caso", mappedBy="clienteRel")
     */
    private $casosClienteRel;

    /**
     *
     * @ORM\OneToMany(targetEntity="Solicitud", mappedBy="clienteRel")
     */
    private $solicitudesClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="Error", mappedBy="clienteRel", cascade={"persist", "remove"})
     */
    protected $erroresClienteRel;

    /**
     *
     * @ORM\OneToMany(targetEntity="Implementacion", mappedBy="clienteRel")
     */
    private $implementacionesClienteRel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->llamadasClienteRel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->casosClienteRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get codigoClientePk
     *
     * @return integer
     */
    public function getCodigoClientePk()
    {
        return $this->codigoClientePk;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return Cliente
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set razonSocial
     *
     * @param string $razonSocial
     *
     * @return Cliente
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set nombreComercial
     *
     * @param string $nombreComercial
     *
     * @return Cliente
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Get nombreComercial
     *
     * @return string
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * Add llamadasClienteRel
     *
     * @param \App\Entity\Llamada $llamadasClienteRel
     *
     * @return Cliente
     */
    public function addLlamadasClienteRel(\App\Entity\Llamada $llamadasClienteRel)
    {
        $this->llamadasClienteRel[] = $llamadasClienteRel;

        return $this;
    }

    /**
     * Remove llamadasClienteRel
     *
     * @param \App\Entity\Llamada $llamadasClienteRel
     */
    public function removeLlamadasClienteRel(\App\Entity\Llamada $llamadasClienteRel)
    {
        $this->llamadasClienteRel->removeElement($llamadasClienteRel);
    }

    /**
     * Get llamadasClienteRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLlamadasClienteRel()
    {
        return $this->llamadasClienteRel;
    }

    /**
     * Add casosClienteRel
     *
     * @param \App\Entity\Caso $casosClienteRel
     *
     * @return Cliente
     */
    public function addCasosClienteRel(\App\Entity\Caso $casosClienteRel)
    {
        $this->casosClienteRel[] = $casosClienteRel;

        return $this;
    }

    /**
     * Remove casosClienteRel
     *
     * @param \App\Entity\Caso $casosClienteRel
     */
    public function removeCasosClienteRel(\App\Entity\Caso $casosClienteRel)
    {
        $this->casosClienteRel->removeElement($casosClienteRel);
    }

    /**
     * Get casosClienteRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCasosClienteRel()
    {
        return $this->casosClienteRel;
    }

    /**
     * @return mixed
     */
    public function getErroresClienteRel()
    {
        return $this->erroresClienteRel;
    }

    /**
     * @param mixed $erroresClienteRel
     * @return Cliente
     */
    public function setErroresClienteRel($erroresClienteRel)
    {
        $this->erroresClienteRel = $erroresClienteRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImplementacionesClienteRel()
    {
        return $this->implementacionesClienteRel;
    }

    /**
     * @param mixed $implementacionesClienteRel
     */
    public function setImplementacionesClienteRel($implementacionesClienteRel): void
    {
        $this->implementacionesClienteRel = $implementacionesClienteRel;
    }

    /**
     * @return mixed
     */
    public function getSolicitudesClienteRel()
    {
        return $this->solicitudesClienteRel;
    }

    /**
     * @param mixed $solicitudesClienteRel
     */
    public function setSolicitudesClienteRel($solicitudesClienteRel): void
    {
        $this->solicitudesClienteRel = $solicitudesClienteRel;
    }

}
