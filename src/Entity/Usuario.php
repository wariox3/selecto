<?php

namespace App\Entity;



use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\Role;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface, \Serializable
{


	/**
	 * @ORM\Column(name="codigo_usuario_pk",type="string")
	 * @ORM\Id
	 */
	private $codigoUsuarioPk;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $correo;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $nombres;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $apellidos;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $clave;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $verificado;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $token;

	/**
	 * @ORM\Column(name="codigo_cliente_fk", type="integer", nullable=true)
	 */
	private $codigoClienteFk;

	/**
	 * @ORM\Column(name="codigo_rol_fk", type="integer", nullable=true)
	 */
	private $codigoRolFk;

    /**
     * @ORM\Column(name="control", type="boolean", nullable=true)
     */
    private $control;

//    /**
//     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="usuarioRolRel")
//     * @ORM\JoinColumn(name="codigo_rol_fk", referencedColumnName="codigo_rol_pk")
//     */
	private $rolRel;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="usuariosClienteRel")
     * @ORM\JoinColumn(name="codigo_cliente_fk", referencedColumnName="codigo_cliente_pk")
     */
    private $clienteRel;


	/**
	 * Se implementan métodos de la clase User del core de Symfony además de los metodos de la entidad própia.
	 *
	 */
	public function serialize()
	{
		return serialize(array(
			$this->codigoUsuarioPk,
			$this->clave
		));
	}

	public function unserialize($serialized)
	{
		list(
			$this->codigoUsuarioPk,
			$this->clave

			) = unserialize($serialized);
	}

	public function getUsername()
	{
		return $this->getCodigoUsuarioPk();
	}

	public function getRoles()
	{

		return array('ROLE_USER');
	}

	public function getPassword()
	{
		return $this->getClave();
	}

	public function getSalt()
	{
		return null;
	}

	public function eraseCredentials()
	{

	}

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
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
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * @param mixed $verificado
     */
    public function setVerificado($verificado): void
    {
        $this->verificado = $verificado;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCodigoClienteFk()
    {
        return $this->codigoClienteFk;
    }

    /**
     * @param mixed $codigoClienteFk
     */
    public function setCodigoClienteFk($codigoClienteFk): void
    {
        $this->codigoClienteFk = $codigoClienteFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoTareaFk()
    {
        return $this->codigoTareaFk;
    }

    /**
     * @param mixed $codigoTareaFk
     */
    public function setCodigoTareaFk($codigoTareaFk): void
    {
        $this->codigoTareaFk = $codigoTareaFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoRolFk()
    {
        return $this->codigoRolFk;
    }

    /**
     * @param mixed $codigoRolFk
     */
    public function setCodigoRolFk($codigoRolFk): void
    {
        $this->codigoRolFk = $codigoRolFk;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param mixed $control
     */
    public function setControl($control): void
    {
        $this->control = $control;
    }

    /**
     * @return mixed
     */
    public function getRolRel()
    {
        return $this->rolRel;
    }

    /**
     * @param mixed $rolRel
     */
    public function setRolRel($rolRel): void
    {
        $this->rolRel = $rolRel;
    }
	/**
	 * end métodos de la clase User del core.
	 */



}
