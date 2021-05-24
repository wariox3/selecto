<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class Identificacion extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('CC');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('CC');
            $arIdentificacion->setNombre('CEDULA DE CIUDADANIA');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('RC');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('RC');
            $arIdentificacion->setNombre('REGISTRO CIVIL DE NACIMIENTO');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('TI');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('TI');
            $arIdentificacion->setNombre('TARJETA DE IDENTIDAD');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('TE');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('TE');
            $arIdentificacion->setNombre('TARJETA DE EXTRANJERÍA');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('CE');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('CE');
            $arIdentificacion->setNombre('CÉDULA DE EXTRANJERÍA');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('NI');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('NI');
            $arIdentificacion->setNombre('NIT');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('PE');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('PE');
            $arIdentificacion->setNombre('PASAPORTE');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('TDE');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('TDE');
            $arIdentificacion->setNombre('TIPO DOCUMENTO EXTRANJERO');
            $manager->persist($arIdentificacion);
        }

        $arIdentificacion = $manager->getRepository(\App\Entity\Identificacion::class)->find('PE');
        if(!$arIdentificacion) {
            $arIdentificacion = new \App\Entity\Identificacion();
            $arIdentificacion->setCodigoIdentificacionPk('PE');
            $arIdentificacion->setNombre('PERMISO ESPECIAL DE PERMANENCIA');
            $manager->persist($arIdentificacion);
        }

        $manager->flush();
    }
}
