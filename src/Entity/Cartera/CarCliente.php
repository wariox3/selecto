<?php

namespace App\Entity\Cartera;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="App\Repository\Cartera\CarReciboRepository")
 */
class CarCliente
{

    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_cliente_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoClientePk;

    /**
     * @ORM\Column(name="codigo_identificacion_fk", type="string", length=3, nullable=true)
     */
    private $codigoIdentificacionFk;

    /**
     * @ORM\Column(name="numero_identificacion", type="string", length=15, nullable=false)
     */
    private $numeroIdentificacion;

    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=1, nullable=true)
     */
    private $digitoVerificacion;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=200)
     */
    private $nombreCorto;

    /**
     * @ORM\OneToMany(targetEntity="CarRecibo", mappedBy="clienteRel")
     */
    protected $recibosClienteRel;

    /**
     * @ORM\OneToMany(targetEntity="CarCuentaCobrar", mappedBy="clienteRel")
     */
    protected $cuentaCobrarClientesRel;

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
    public function getCodigoIdentificacionFk()
    {
        return $this->codigoIdentificacionFk;
    }

    /**
     * @param mixed $codigoIdentificacionFk
     */
    public function setCodigoIdentificacionFk($codigoIdentificacionFk): void
    {
        $this->codigoIdentificacionFk = $codigoIdentificacionFk;
    }

    /**
     * @return mixed
     */
    public function getNumeroIdentificacion()
    {
        return $this->numeroIdentificacion;
    }

    /**
     * @param mixed $numeroIdentificacion
     */
    public function setNumeroIdentificacion($numeroIdentificacion): void
    {
        $this->numeroIdentificacion = $numeroIdentificacion;
    }

    /**
     * @return mixed
     */
    public function getDigitoVerificacion()
    {
        return $this->digitoVerificacion;
    }

    /**
     * @param mixed $digitoVerificacion
     */
    public function setDigitoVerificacion($digitoVerificacion): void
    {
        $this->digitoVerificacion = $digitoVerificacion;
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
    public function getRecibosClienteRel()
    {
        return $this->recibosClienteRel;
    }

    /**
     * @param mixed $recibosClienteRel
     */
    public function setRecibosClienteRel($recibosClienteRel): void
    {
        $this->recibosClienteRel = $recibosClienteRel;
    }

    /**
     * @return mixed
     */
    public function getCuentaCobrarClientesRel()
    {
        return $this->cuentaCobrarClientesRel;
    }

    /**
     * @param mixed $cuentaCobrarClientesRel
     */
    public function setCuentaCobrarClientesRel($cuentaCobrarClientesRel): void
    {
        $this->cuentaCobrarClientesRel = $cuentaCobrarClientesRel;
    }
}
