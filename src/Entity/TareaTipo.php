<?php
/**
 * Created by Juan David Marulanda V.
 * User: @ju4nr3v0l
 * appSoga developers Team.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaTipo
 *
 * @ORM\Table(name="tarea_tipo")
 * @ORM\Entity(repositoryClass="App\Repository\TareaTipoRepository")
 */

class TareaTipo
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="codigo_tarea_tipo_pk")
     */
    private $codigoTareaTipoPk;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     *
     * @ORM\OneToMany(targetEntity="Tarea", mappedBy="tareaTipoRel")
     */

    private $tareasTareaTipoRel;
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->tareasTareaTipoRel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codigoTareaTipoPk
     *
     * @param string $codigoTareaTipoPk
     *
     * @return TareaTipo
     */
    public function setCodigoTareaTipoPk($codigoTareaTipoPk)
    {
        $this->codigoTareaTipoPk = $codigoTareaTipoPk;

        return $this;
    }

    /**
     * Get codigoTareaTipoPk
     *
     * @return string
     */
    public function getCodigoTareaTipoPk()
    {
        return $this->codigoTareaTipoPk;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TareaTipo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add tareasTareaTipoRel
     *
     * @param \App\Entity\Tarea $tareasTareaTipoRel
     *
     * @return TareaTipo
     */
    public function addTareasTareaTipoRel(\App\Entity\Tarea $tareasTareaTipoRel)
    {
        $this->tareasTareaTipoRel[] = $tareasTareaTipoRel;

        return $this;
    }

    /**
     * Remove tareasTareaTipoRel
     *
     * @param \App\Entity\Tarea $tareasTareaTipoRel
     */
    public function removeTareasTareaTipoRel(\App\Entity\Tarea $tareasTareaTipoRel)
    {
        $this->tareasTareaTipoRel->removeElement($tareasTareaTipoRel);
    }

    /**
     * Get tareasTareaTipoRel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTareasTareaTipoRel()
    {
        return $this->tareasTareaTipoRel;
    }
}
