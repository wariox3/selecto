<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class rhuEntidad extends Fixture
{
    public function load(ObjectManager $manager){
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(1);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setNombre("Empresas Públicas de Medellín Departamento Médico");
            $arEntidad->setNit("890904996-1");
            $arEntidad->setDireccion("Calle. 78b #69174");
            $arEntidad->setTelefono("");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EAS016");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(2);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setNombre("Fondo de Ferrocarriles Nacionales de Colombia (EPS)");
            $arEntidad->setNit("800112806-2");
            $arEntidad->setDireccion("Calle 13 No. 18-24 Estación de la Sabana (Bogota-Colombia)");
            $arEntidad->setTelefono("01-8000-09-12206");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EAS016");
            $manager->persist($arEntidad);
        }

        $manager->flush();

    }


}