<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 * @ORM\Entity(repositoryClass="App\Repository\General\EmpresaRepository")
 */
class Empresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoEmpresaPk;

    /**
     * @ORM\Column(name="nombre_corto", type="string", length=255, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="nit", type="string", nullable=true)
     */
    private $nit;

    /**
     * @ORM\Column(name="digito_verificacion", type="string", length=1, nullable=true)
     */
    private $digitoVerificacion;

    /**
     * @ORM\Column(name="direccion", type="string", length=80,nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string", length=20,nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="ruta_temporal", type="string", length=100, nullable=true)
     */
    private $rutaTemporal;

    /**
     * @ORM\Column(name="logo", type="blob", nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=5, name="extension", nullable=true)
     */
    private $extension;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="empresaRel")
     */
    protected $usuariosEmpresaRel;

    /**
     * @ORM\Column(name="fecha_desde_vigencia", type="date", nullable=true)
     */
    private $fechaDesdeVigencia;

    /**
     * @ORM\Column(name="fecha_hasta_vigencia", type="date", nullable=true)
     */
    private $fechaHastaVigencia;

    /**
     * @ORM\Column(name="numeracion_desde", type="string", length=20, nullable=true)
     */
    private $numeracionDesde;

    /**
     * @ORM\Column(name="numeracion_hasta", type="string", length=20, nullable=true)
     */
    private $numeracionHasta;

    /**
     * @ORM\Column(name="numero_resolucion_dian_factura", type="string", length=1000, nullable=true)
     */
    private $numeroResolucionDianFactura;

    /**
     * @ORM\Column(name="informacion_cuenta_pago", type="string", length=1000, nullable=true)
     */
    private $informacionCuentaPago;

    /**
     * @ORM\Column(name="prefijo_facturacion", type="string", length=10, nullable=true)
     */
    private $prefijoFacturacion;

    /**
     * @return mixed
     */
    public function getCodigoEmpresaPk()
    {
        return $this->codigoEmpresaPk;
    }

    /**
     * @param mixed $codigoEmpresaPk
     */
    public function setCodigoEmpresaPk($codigoEmpresaPk): void
    {
        $this->codigoEmpresaPk = $codigoEmpresaPk;
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
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * @param mixed $nit
     */
    public function setNit($nit): void
    {
        $this->nit = $nit;
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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getUsuariosEmpresaRel()
    {
        return $this->usuariosEmpresaRel;
    }

    /**
     * @param mixed $usuariosEmpresaRel
     */
    public function setUsuariosEmpresaRel($usuariosEmpresaRel): void
    {
        $this->usuariosEmpresaRel = $usuariosEmpresaRel;
    }

    /**
     * @return mixed
     */
    public function getRutaTemporal()
    {
        return $this->rutaTemporal;
    }

    /**
     * @param mixed $rutaTemporal
     */
    public function setRutaTemporal($rutaTemporal): void
    {
        $this->rutaTemporal = $rutaTemporal;
    }

    /**
     * @return mixed
     */
    public function getFechaDesdeVigencia()
    {
        return $this->fechaDesdeVigencia;
    }

    /**
     * @param mixed $fechaDesdeVigencia
     */
    public function setFechaDesdeVigencia($fechaDesdeVigencia): void
    {
        $this->fechaDesdeVigencia = $fechaDesdeVigencia;
    }

    /**
     * @return mixed
     */
    public function getFechaHastaVigencia()
    {
        return $this->fechaHastaVigencia;
    }

    /**
     * @param mixed $fechaHastaVigencia
     */
    public function setFechaHastaVigencia($fechaHastaVigencia): void
    {
        $this->fechaHastaVigencia = $fechaHastaVigencia;
    }

    /**
     * @return mixed
     */
    public function getNumeracionDesde()
    {
        return $this->numeracionDesde;
    }

    /**
     * @param mixed $numeracionDesde
     */
    public function setNumeracionDesde($numeracionDesde): void
    {
        $this->numeracionDesde = $numeracionDesde;
    }

    /**
     * @return mixed
     */
    public function getNumeracionHasta()
    {
        return $this->numeracionHasta;
    }

    /**
     * @param mixed $numeracionHasta
     */
    public function setNumeracionHasta($numeracionHasta): void
    {
        $this->numeracionHasta = $numeracionHasta;
    }

    /**
     * @return mixed
     */
    public function getNumeroResolucionDianFactura()
    {
        return $this->numeroResolucionDianFactura;
    }

    /**
     * @param mixed $numeroResolucionDianFactura
     */
    public function setNumeroResolucionDianFactura($numeroResolucionDianFactura): void
    {
        $this->numeroResolucionDianFactura = $numeroResolucionDianFactura;
    }

    /**
     * @return mixed
     */
    public function getInformacionCuentaPago()
    {
        return $this->informacionCuentaPago;
    }

    /**
     * @param mixed $informacionCuentaPago
     */
    public function setInformacionCuentaPago($informacionCuentaPago): void
    {
        $this->informacionCuentaPago = $informacionCuentaPago;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getPrefijoFacturacion()
    {
        return $this->prefijoFacturacion;
    }

    /**
     * @param mixed $prefijoFacturacion
     */
    public function setPrefijoFacturacion($prefijoFacturacion): void
    {
        $this->prefijoFacturacion = $prefijoFacturacion;
    }



}
