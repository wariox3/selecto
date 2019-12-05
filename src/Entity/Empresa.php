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
     * @ORM\Column(name="correo", type="string", length=200, nullable=true)
     */
    private $correo;

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
     * @ORM\Column(name="formato_factura", type="string", length=1, nullable=true)
     */
    private $formatoFactura;
    /**
     * @ORM\Column(name="porcentaje_interes_mora", type="float", options={"default":0} , nullable=true)
     */
    private $porcentajeInteresMora = 0;

    /**
     * @ORM\Column(name="codigo_item_interes_mora", type="integer", nullable=true)
     */
    private $codigoItemInteresMora;

    /**
     * @ORM\Column(name="genera_interes_mora", type="boolean", nullable=true, options={"default" : false})
     */
    private $generaInteresMora = false;

    /**
     * @ORM\Column(name="codigo_tipo_persona_fk", type="string", length=3, nullable=true)
     */
    private $codigoTipoPersonaFk;

    /**
     * @ORM\Column(name="codigo_regimen_fk", type="string", length=3, nullable=true)
     */
    private $codigoRegimenFk;

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
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="matricula_mercantil", type="string", length=100, nullable=true)
     */
    private $matriculaMercantil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenCiudad", inversedBy="empresasCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenTipoPersona", inversedBy="empresasTipoPersonaRel")
     * @ORM\JoinColumn(name="codigo_tipo_persona_fk", referencedColumnName="codigo_tipo_persona_pk")
     */
    private $tipoPersonaRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\General\GenRegimen", inversedBy="empresasRegimenRel")
     * @ORM\JoinColumn(name="codigo_regimen_fk", referencedColumnName="codigo_regimen_pk")
     */
    private $regimenRel;

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

    /**
     * @return mixed
     */
    public function getFormatoFactura()
    {
        return $this->formatoFactura;
    }

    /**
     * @param mixed $formatoFactura
     */
    public function setFormatoFactura($formatoFactura): void
    {
        $this->formatoFactura = $formatoFactura;
    }

    /**
     * @return int
     */
    public function getPorcentajeInteresMora(): int
    {
        return $this->porcentajeInteresMora;
    }

    /**
     * @param int $porcentajeInteresMora
     */
    public function setPorcentajeInteresMora(int $porcentajeInteresMora): void
    {
        $this->porcentajeInteresMora = $porcentajeInteresMora;
    }

    /**
     * @return mixed
     */
    public function getCodigoItemInteresMora()
    {
        return $this->codigoItemInteresMora;
    }

    /**
     * @param mixed $codigoItemInteresMora
     */
    public function setCodigoItemInteresMora($codigoItemInteresMora): void
    {
        $this->codigoItemInteresMora = $codigoItemInteresMora;
    }

    /**
     * @return bool
     */
    public function isGeneraInteresMora(): bool
    {
        return $this->generaInteresMora;
    }

    /**
     * @param bool $generaInteresMora
     */
    public function setGeneraInteresMora(bool $generaInteresMora): void
    {
        $this->generaInteresMora = $generaInteresMora;
    }

    /**
     * @return mixed
     */
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getCodigoTipoPersonaFk()
    {
        return $this->codigoTipoPersonaFk;
    }

    /**
     * @param mixed $codigoTipoPersonaFk
     */
    public function setCodigoTipoPersonaFk($codigoTipoPersonaFk): void
    {
        $this->codigoTipoPersonaFk = $codigoTipoPersonaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoRegimenFk()
    {
        return $this->codigoRegimenFk;
    }

    /**
     * @param mixed $codigoRegimenFk
     */
    public function setCodigoRegimenFk($codigoRegimenFk): void
    {
        $this->codigoRegimenFk = $codigoRegimenFk;
    }

    /**
     * @return mixed
     */
    public function getTipoPersonaRel()
    {
        return $this->tipoPersonaRel;
    }

    /**
     * @param mixed $tipoPersonaRel
     */
    public function setTipoPersonaRel($tipoPersonaRel): void
    {
        $this->tipoPersonaRel = $tipoPersonaRel;
    }

    /**
     * @return mixed
     */
    public function getRegimenRel()
    {
        return $this->regimenRel;
    }

    /**
     * @param mixed $regimenRel
     */
    public function setRegimenRel($regimenRel): void
    {
        $this->regimenRel = $regimenRel;
    }

    /**
     * @return mixed
     */
    public function getMatriculaMercantil()
    {
        return $this->matriculaMercantil;
    }

    /**
     * @param mixed $matriculaMercantil
     */
    public function setMatriculaMercantil($matriculaMercantil): void
    {
        $this->matriculaMercantil = $matriculaMercantil;
    }



}
