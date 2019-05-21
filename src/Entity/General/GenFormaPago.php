<?php

namespace App\Entity\General;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\GenFormaPagoRepository")
 */
class GenFormaPago
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_forma_pago_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoFormaPagoPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventario\InvTercero", mappedBy="formaPagoRel")
     */
    private $formaPagoTerceroRel;

    /**
     * @return mixed
     */
    public function getCodigoFormaPagoPk()
    {
        return $this->codigoFormaPagoPk;
    }

    /**
     * @param mixed $codigoFormaPagoPk
     */
    public function setCodigoFormaPagoPk($codigoFormaPagoPk): void
    {
        $this->codigoFormaPagoPk = $codigoFormaPagoPk;
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
    public function getFormaPagoTerceroRel()
    {
        return $this->formaPagoTerceroRel;
    }

    /**
     * @param mixed $formaPagoTerceroRel
     */
    public function setFormaPagoTerceroRel($formaPagoTerceroRel): void
    {
        $this->formaPagoTerceroRel = $formaPagoTerceroRel;
    }


}
