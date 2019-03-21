<?php

namespace App\Utilidades;


final class AyudaEliminar
{
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