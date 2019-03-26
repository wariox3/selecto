<?php

namespace App\Utilidades;

use App\Entity\Vigencia;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AyudaEliminar
{
    private $em;
/*
*/
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public static function eliminar($entidad, $datosSeleccionados=[]) {
        global $kernel;
        $container = $kernel->getContainer();
        $container->get("ServiceAyudaEliminar")->removerElementos($entidad, $datosSeleccionados);
    }

    public function removerElementos($entidad, $datosSeleccionados){
        try{
             if ($datosSeleccionados && is_array($datosSeleccionados)) {
                 foreach ($datosSeleccionados as $codigo) {
                     $em = $this->em;
                     $arNorma = $em->getRepository($entidad)->find($codigo);
                     if ($arNorma) {
                        $this->em->remove($arNorma);
                     }
                 }
                 $this->em->flush();
             }
         } catch (\Exception $ex) {
             AyudaEliminar::tipoError((get_class($ex)));
         }
    }

    static function tipoError($classError)
    {
        switch ($classError){
            case "Doctrine\DBAL\Exception\ConnectionException":
                Mensajes::error('Error con la conección de la base de datos');
                break;
            case "Doctrine\DBAL\Exception\RestricciónViolaciónExcepción":
                Mensajes::error('Error con la base de datos');
                break;
            case "Doctrine\DBAL\Exception\DatabaseObjectExistsException":
                Mensajes::error('Errores relacionados con la violación de restricciones');
                break;
            case "Doctrine\DBAL\Exception\DatabaseObjectNotFoundException":
                Mensajes::error('Errores relacionados con la violación de restricciones');
                break;
            case "Doctrine\DBAL\Exception\DeadlockException":
                Mensajes::error('Errores relacionados con la violación de restricciones');
                break;
            case "Doctrine\DBAL\Exception\DriverException":
                Mensajes::error('Error con la base de datos');
                break;
            case "Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException":
                Mensajes::warning('No se puede eliminar el registro, ya que este encuentra relacionado con otros datos, asegúrese de eliminar la sub información que contenga este registro.');
                break;
            case "Doctrine\DBAL\Exception\InvalidArgumentException":
                Mensajes::info('No se puede eliminar el registro, ya que este encuentra relacionado con otros datos, asegúrese de eliminar la sub información que contenga este registro.');
                break;
            case "Doctrine\DBAL\Exception\LockWaitTimeoutException":
                Mensajes::info('No se puede conectar al servidor tiempo de espera completo');
                break;
            case "Doctrine\DBAL\Exception\NonUniqueFieldNameException":
                Mensajes::warning('Ya existe un registro igual ');
                break;
            case "Doctrine\DBAL\Exception\NotNullConstraintViolationException":
                Mensajes::warning('Existen campos vacíos, los cuales no son permitidos por favor revisar la información');
                break;
            case "Doctrine\DBAL\Exception\ReadOnlyException":
                Mensajes::error('Errores relacionados con la violación de restricciones');
                break;
            case "Doctrine\DBAL\Exception\UniqueConstraintViolationException":
                Mensajes::warning('No se permiten datos duplicados  ');
                break;
            case "Doctrine\DBAL\Exception\SyntaxErrorException":
                Mensajes::error('Error con la base de datos');
                break;
            case "Doctrine\DBAL\Exception\TableExistsException":
                Mensajes::error('Error con la base de datos');
                break;
            case "Doctrine\DBAL\Exception\TableNotFoundException":
                Mensajes::error('Error con la base de datos');
                break;

        }

    }
}