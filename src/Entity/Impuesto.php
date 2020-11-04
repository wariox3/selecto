<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImpuestoRepository")
 */
class Impuesto
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_impuesto_pk", type="string", length=3, nullable=false)
     */
    private $codigoImpuestoPk;

    /**
     * @ORM\Column(name="codigo_impuesto_tipo_fk", type="string", length=3, nullable=true)
     */
    private $codigoImpuestoTipoFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="porcentaje", type="float", nullable=true, options={"default" : 0})
     */
    private $porcentaje = 0;

    /**
     * @ORM\Column(name="base", type="float", nullable=true, options={"default" : 0})
     */
    private $base = 0;

    /**
     * @ORM\Column(name="codigo_cuenta_fk", type="string", length=20, nullable=true)
     */
    private $codigoCuentaFk;

    /**
     * @ORM\Column(name="codigo_cuenta_devolucion_fk", type="string", length=20, nullable=true)
     */
    private $codigoCuentaDevolucionFk;


}

