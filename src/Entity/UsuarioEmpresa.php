<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\General\UsuarioEmpresaRepository")
 */
class UsuarioEmpresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoUsuarioEmpresaPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string",length=100, nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_empresa_fk", type="integer", nullable=true)
     */
    private $codigoEmpresaFk;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="usuariosEmpresasEmpresaRel")
     * @ORM\JoinColumn(name="codigo_empresa_fk", referencedColumnName="codigo_empresa_pk")
     */
    private $empresaRel;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioEmpresaPk()
    {
        return $this->codigoUsuarioEmpresaPk;
    }

    /**
     * @param mixed $codigoUsuarioEmpresaPk
     */
    public function setCodigoUsuarioEmpresaPk($codigoUsuarioEmpresaPk): void
    {
        $this->codigoUsuarioEmpresaPk = $codigoUsuarioEmpresaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresaFk()
    {
        return $this->codigoEmpresaFk;
    }

    /**
     * @param mixed $codigoEmpresaFk
     */
    public function setCodigoEmpresaFk($codigoEmpresaFk): void
    {
        $this->codigoEmpresaFk = $codigoEmpresaFk;
    }

    /**
     * @return mixed
     */
    public function getEmpresaRel()
    {
        return $this->empresaRel;
    }

    /**
     * @param mixed $empresaRel
     */
    public function setEmpresaRel($empresaRel): void
    {
        $this->empresaRel = $empresaRel;
    }



}