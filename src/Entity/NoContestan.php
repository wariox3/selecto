<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoContestan
 *
 * @ORM\Table(name="no_contestan")
 * @ORM\Entity(repositoryClass="App\Repository\NoContestanRepository")
 */
class NoContestan
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_no_contestan_pk", type="integer", length=255, unique=true)
     */
    private $codigoNoContestanPk;

    /**
     * @var int
     *
     * @ORM\Column(name="codigo_llamada_fk", type="integer", length=255)
     */
    private $codigoLlamadaFk;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_no_contestan", type="datetime", nullable=true)
     */
    private $fechaNoContestan;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_usuario_fk", type="string", length=255, nullable=true)
     */
    private $codigoUsuarioFk;

	/**
	 * @ORM\ManyToOne(targetEntity="Llamada", inversedBy="llamadasNoContestanRel")
	 * @ORM\JoinColumn(name="codigo_llamada_fk", referencedColumnName="codigo_llamada_pk")
	 */
	private $noContestanRel;




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
     * Set codigoNoContestanPk
     *
     * @param string $codigoNoContestanPk
     *
     * @return NoContestan
     */
    public function setCodigoNoContestanPk($codigoNoContestanPk)
    {
        $this->codigoNoContestanPk = $codigoNoContestanPk;

        return $this;
    }

    /**
     * Get codigoNoContestanPk
     *
     * @return string
     */
    public function getCodigoNoContestanPk()
    {
        return $this->codigoNoContestanPk;
    }

    /**
     * Set codigoLlamadaFk
     *
     * @param string $codigoLlamadaFk
     *
     * @return NoContestan
     */
    public function setCodigoLlamadaFk($codigoLlamadaFk)
    {
        $this->codigoLlamadaFk = $codigoLlamadaFk;

        return $this;
    }

    /**
     * Get codigoLlamadaFk
     *
     * @return string
     */
    public function getCodigoLlamadaFk()
    {
        return $this->codigoLlamadaFk;
    }

    /**
     * Set fechaNoContestan
     *
     * @param \DateTime $fechaNoContestan
     *
     * @return NoContestan
     */
    public function setFechaNoContestan($fechaNoContestan)
    {
        $this->fechaNoContestan = $fechaNoContestan;

        return $this;
    }

    /**
     * Get fechaNoContestan
     *
     * @return \DateTime
     */
    public function getFechaNoContestan()
    {
        return $this->fechaNoContestan;
    }

    /**
     * Set codigoUsuarioFk
     *
     * @param string $codigoUsuarioFk
     *
     * @return NoContestan
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk)
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;

        return $this;
    }

    /**
     * Get codigoUsuarioFk
     *
     * @return string
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * Set noContestanRel
     *
     * @param \App\Entity\Llamada $noContestanRel
     *
     * @return NoContestan
     */
    public function setNoContestanRel(\App\Entity\Llamada $noContestanRel = null)
    {
        $this->noContestanRel = $noContestanRel;

        return $this;
    }

    /**
     * Get noContestanRel
     *
     * @return \App\Entity\Llamada
     */
    public function getNoContestanRel()
    {
        return $this->noContestanRel;
    }
}
