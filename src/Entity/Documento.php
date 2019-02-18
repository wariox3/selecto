<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentoRepository")
 */
class Documento
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="codigo_documento_pk", type="integer")
     */
    private $codigoDocumentoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @return int
     */
    public function getCodigoDocumentoPk(): int
    {
        return $this->codigoDocumentoPk;
    }

    /**
     * @param int $codigoDocumentoPk
     */
    public function setCodigoDocumentoPk(int $codigoDocumentoPk): void
    {
        $this->codigoDocumentoPk = $codigoDocumentoPk;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

}
