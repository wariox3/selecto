<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contacto
 *
 * @ORM\Table(name="contacto")
 * @ORM\Entity(repositoryClass="App\Repository\ContactoRepository")
 *
 */
class Contacto
{


    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_contacto_pk", type="integer", unique=true)
     */
    private $codigoContactoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255, nullable=true)
     */
    private $nombres;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_cliente_pk", type="integer")
     */
    private $codigoClientePk;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigoContactoPk
     *
     * @param integer $codigoContactoPk
     *
     * @return Contacto
     */
    public function setCodigoContactoPk($codigoContactoPk)
    {
        $this->codigoContactoPk = $codigoContactoPk;

        return $this;
    }

    /**
     * Get codigoContactoPk
     *
     * @return int
     */
    public function getCodigoContactoPk()
    {
        return $this->codigoContactoPk;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Contacto
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set codigoClientePk
     *
     * @param integer $codigoClientePk
     *
     * @return Contacto
     */
    public function setCodigoClientePk($codigoClientePk)
    {
        $this->codigoClientePk = $codigoClientePk;

        return $this;
    }

    /**
     * Get codigoClientePk
     *
     * @return int
     */
    public function getCodigoClientePk()
    {
        return $this->codigoClientePk;
    }

    /**
     * Set clienteRel
     *
     * @param \App\Entity\Cliente $clienteRel
     *
     * @return Contacto
     */
    public function setClienteRel(\App\Entity\Cliente $clienteRel = null)
    {
        $this->clienteRel = $clienteRel;

        return $this;
    }

    /**
     * Get clienteRel
     *
     * @return \App\Entity\Cliente
     */
    public function getClienteRel()
    {
        return $this->clienteRel;
    }
}
