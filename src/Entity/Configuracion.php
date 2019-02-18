<?php
/**
 * Created by PhpStorm.
 * User: avera
 * Date: 4/12/17
 * Time: 11:10 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
* Caso
*
* @ORM\Table(name="configuracion")
* @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
*/
class Configuracion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="codigo_configuracion_pk", type="integer", unique=true)
     */
    private $codigoConfiguracionPk;

    /**
     * @ORM\Column(name="correo_empresa", type="string", length=255, nullable =true)
     */
    private $correoEmpresa;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk( $codigoConfiguracionPk ): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getCorreoEmpresa()
    {
        return $this->correoEmpresa;
    }

    /**
     * @param mixed $correoEmpresa
     */
    public function setCorreoEmpresa( $correoEmpresa ): void
    {
        $this->correoEmpresa = $correoEmpresa;
    }



}
