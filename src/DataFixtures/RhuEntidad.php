<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RhuEntidad extends Fixture
{
    public function load(ObjectManager $manager){
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(1);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(1);
            $arEntidad->setNombre("Empresas Públicas de Medellín Departamento Médico");
            $arEntidad->setNit("890904996-1");
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
            $arEntidad->setCodigoEntidadPk(2);
            $arEntidad->setNombre("Fondo de Ferrocarriles Nacionales de Colombia");
            $arEntidad->setNit("800112806-2");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EAS027");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(3);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(3);
            $arEntidad->setNombre("Aliansalud (Antes Colmédica)");
            $arEntidad->setNit("830113831-0");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS001");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(4);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(4);
            $arEntidad->setNombre("Salud Total");
            $arEntidad->setNit("800130907-4");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS002");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(5);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(5);
            $arEntidad->setNombre("Cafesalud");
            $arEntidad->setNit("800251440-6");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS005");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(6);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(6);
            $arEntidad->setNombre("Sanitas");
            $arEntidad->setNit("800251440-6");

            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS005");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(7);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(7);
            $arEntidad->setNombre("Compensar");
            $arEntidad->setNit("860066942-7");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS008");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(8);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(8);
            $arEntidad->setNombre(" Sura");
            $arEntidad->setNit("800088702-2");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS010");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(9);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(9);
            $arEntidad->setNombre("Comfenalco Valle");
            $arEntidad->setNit("890303093-5");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS012");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(10);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(10);
            $arEntidad->setNombre(" Coomeva");
            $arEntidad->setNit("805000427-1");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS016");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(11);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(11);
            $arEntidad->setNombre("Famisanar");
            $arEntidad->setNit("830003564-7");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS017");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(12);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(12);
            $arEntidad->setNombre("S.O.S. Servicio Occidental de Salud S.A.");
            $arEntidad->setNit("805001157-2");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS018");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(13);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(13);
            $arEntidad->setNombre(" Cruz Blanca");
            $arEntidad->setNit("830009783-0");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS023");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(14);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(14);
            $arEntidad->setNombre("Saludvida");
            $arEntidad->setNit("830074184-5");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS033");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(15);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(15);
            $arEntidad->setNombre("Nueva E.P.S.");
            $arEntidad->setNit("900156264-2");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPS037");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(16);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(16);
            $arEntidad->setNombre("Fosyga");
            $arEntidad->setNit("900462447-5");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("MIN001");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(17);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(17);
            $arEntidad->setNombre(" Fosyga Régimen de Excepción");
            $arEntidad->setNit("900462447-5");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("MIN002");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(18);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(18);
            $arEntidad->setNombre("Fosyga Residente Exterior o Régimen Subsidiado");
            $arEntidad->setNit("900462447-5");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("MIN003");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(19);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(19);
            $arEntidad->setNombre("Universidad del Atlántico");
            $arEntidad->setNit("890102257-3");
            $arEntidad->setEps(     true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES005");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(20);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(20);
            $arEntidad->setNombre(" Universidad Industrial de Santander");
            $arEntidad->setNit("890203183-0");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES006");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(21);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(21);
            $arEntidad->setNombre("Universidad del Valle");
            $arEntidad->setNit("890399010-6");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES007");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(22);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(22);
            $arEntidad->setNombre(" Universidad Nacional de Colombia");
            $arEntidad->setNit("899999063-3");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES008");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(23);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(23);
            $arEntidad->setNombre("Universidad del Cauca");
            $arEntidad->setNit("891500319-2");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES009");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(24);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(24);
            $arEntidad->setNombre(" Universidad de Antioquia");
            $arEntidad->setNit("890980040-8");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES011");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(25);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(25);
            $arEntidad->setNombre("Universidad de Córdoba");
            $arEntidad->setNit("891080031-3");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES012");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(26);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(26);
            $arEntidad->setNombre("Universidad Pedagógica - UPTC");
            $arEntidad->setNit("891800330-1");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("RES014");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(27);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(27);
            $arEntidad->setNombre("Cafesalud- Movilidad");
            $arEntidad->setNit("8001409496");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSC03");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(28);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(28);
            $arEntidad->setNombre("Convida");
            $arEntidad->setNit("899999107");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSC22");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(29);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(29);
            $arEntidad->setNombre("Capresoca");
            $arEntidad->setNit("891856000");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSC25");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(30);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(30);
            $arEntidad->setNombre("Capital Salud");
            $arEntidad->setNit("900298372");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSC34");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(31);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(31);
            $arEntidad->setNombre("Dusakawi");
            $arEntidad->setNit("824001398");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC1");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(32);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(32);
            $arEntidad->setNombre("Manexka");
            $arEntidad->setNit("824001398");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC2");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(33);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(33);
            $arEntidad->setNombre("A.I.C.");
            $arEntidad->setNit("817001773");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC3");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(34);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(34);
            $arEntidad->setNombre("Anas Wayuu");
            $arEntidad->setNit("839000495");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC4");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(35);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(35);
            $arEntidad->setNombre("Mallamas");
            $arEntidad->setNit("837000084");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC5");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(36);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(36);
            $arEntidad->setNombre("Pijaosalud");
            $arEntidad->setNit("809008362");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("EPSIC6");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(37);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(37);
            $arEntidad->setNombre("Emdisalud");
            $arEntidad->setNit("ESSC02");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC02");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(38);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(38);
            $arEntidad->setNombre(" Mutual Ser");
            $arEntidad->setNit("806008394");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC07");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(39);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(39);
            $arEntidad->setNombre("Emssanar");
            $arEntidad->setNit("814000337");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC07");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(40);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(40);
            $arEntidad->setNombre("Coosalud");
            $arEntidad->setNit("800249241");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC24");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(41);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(41);
            $arEntidad->setNombre("Comparta");
            $arEntidad->setNit("804002105");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC33");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(42);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(42);
            $arEntidad->setNombre("Asmet Salud");
            $arEntidad->setNit("817000248");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC62");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(43);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(43);
            $arEntidad->setNombre("Ambuq");
            $arEntidad->setNit("818000140");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC76");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(44);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(44);
            $arEntidad->setNombre("Ecoopsos");
            $arEntidad->setNit("832000760");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC91");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(45);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(45);
            $arEntidad->setNombre("Savia Salud");
            $arEntidad->setNit("900604350");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("ESSC91");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(46);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(46);
            $arEntidad->setNombre("Comfaboy");
            $arEntidad->setNit("891800213");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC09");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(47);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(47);
            $arEntidad->setNombre("Comfacor");
            $arEntidad->setNit("891080005");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC15");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(48);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(48);
            $arEntidad->setNombre("Comfachoco");
            $arEntidad->setNit("891600091");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC20");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(49);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(49);
            $arEntidad->setNombre("Comfamiliar Guajira");
            $arEntidad->setNit("892115006");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC23");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(50);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(50);
            $arEntidad->setNombre("Comfamilar Huila");
            $arEntidad->setNit("891180008");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC24");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(51);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(51);
            $arEntidad->setNombre("Comfamiliar de Nariño");
            $arEntidad->setNit("891180008");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC27");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(52);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(52);
            $arEntidad->setNombre("Comfasucre");
            $arEntidad->setNit("892200015");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC33");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(53);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(53);
            $arEntidad->setNombre("Comfacundi");
            $arEntidad->setNit("860045904");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC53");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(54);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(54);
            $arEntidad->setNombre("Cajacopi Atlántico");
            $arEntidad->setNit("890102044");
            $arEntidad->setEps(true);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCFC55");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(55);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(55);
            $arEntidad->setNombre("Protección");
            $arEntidad->setNit("800229739-0");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("230201");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(56);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(56);
            $arEntidad->setNombre("Porvenir");
            $arEntidad->setNit("800224808-8");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("230301");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(57);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(57);
            $arEntidad->setNombre("Old Mutual");
            $arEntidad->setNit("800253055-2");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("230901");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(58);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(58);
            $arEntidad->setNombre("Old Mutual Alternativo");
            $arEntidad->setNit("830125132-2");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("230904");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(59);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(59);
            $arEntidad->setNombre("Colfondos");
            $arEntidad->setNit("800227940-6");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("231001");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(60);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(60);
            $arEntidad->setNombre("Caxdac");
            $arEntidad->setNit("860007379-8");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("25-2");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(61);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(61);
            $arEntidad->setNombre("Fonprecon");
            $arEntidad->setNit("899999734-7");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("25-3");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(62);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(62);
            $arEntidad->setNombre(" Pensiones de Antioquia");
            $arEntidad->setNit("800216278-0");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("25-7");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(63);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(63);
            $arEntidad->setNombre("Colpensiones");
            $arEntidad->setNit("900336004-7");
            $arEntidad->setEps(false);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(true);
            $arEntidad->setPen(true);
            $arEntidad->setCodigoInterface("25-14");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(64);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(64);
            $arEntidad->setNombre("Colpatria");
            $arEntidad->setNit("860002183-9");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-4");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(65);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(65);
            $arEntidad->setNombre("Seguros Bolívar");
            $arEntidad->setNit("860002503-2");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-7");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(66);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(66);
            $arEntidad->setNombre("Alfa");
            $arEntidad->setNit("860503617-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-17");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(67);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(67);
            $arEntidad->setNombre("Seguros de Vida Aurora");
            $arEntidad->setNit("860022137-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-8");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(68);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(68);
            $arEntidad->setNombre("Liberty");
            $arEntidad->setNit("860008645-7");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-18");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(69);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(69);
            $arEntidad->setNombre("Positiva Compañía de Seguros");
            $arEntidad->setNit("860011153-6");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-23");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(70);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(70);
            $arEntidad->setNombre("Colmena");
            $arEntidad->setNit("800226175-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-25");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(71);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(71);
            $arEntidad->setNombre("ARP Sura (Antes Suratep)");
            $arEntidad->setNit("800256161-9");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-28");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(72);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(72);
            $arEntidad->setNombre("La Equidad Seguros");
            $arEntidad->setNit("830008686-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-29");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(73);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(73);
            $arEntidad->setNombre("Mapfre Colombia Vida Seguros S.A.");
            $arEntidad->setNit("830054904-6");
            $arEntidad->setEps(False);
            $arEntidad->setArl(true);
            $arEntidad->setCcf(False);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("14-30");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(74);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(74);
            $arEntidad->setNombre("Comfamiliar Camacol");
            $arEntidad->setNit("890900840-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF02");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(75);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(75);
            $arEntidad->setNombre("Comfenalco Antioquia");
            $arEntidad->setNit("890900842-6");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF03");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(76);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(76);
            $arEntidad->setNombre("Comfama");
            $arEntidad->setNit("890900841-9");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF04");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(77);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(77);
            $arEntidad->setNombre("Cajacopi Atlántico");
            $arEntidad->setNit("890102044-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF05");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(78);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(78);
            $arEntidad->setNombre("Combarranquilla");
            $arEntidad->setNit("890102002-2");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF06");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(79);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(79);
            $arEntidad->setNombre("Comfamiliar Atlántico");
            $arEntidad->setNit("890101994-9");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF07");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(80);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(80);
            $arEntidad->setNombre("Comfenalco Cartagena");
            $arEntidad->setNit("890480023-7");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF08");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(81);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(81);
            $arEntidad->setNombre("Comfamiliar Cartagena");
            $arEntidad->setNit("890480110-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF09");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(82);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(82);
            $arEntidad->setNombre("Comfaboy");
            $arEntidad->setNit("891800213-8");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF10");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(83);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(83);
            $arEntidad->setNombre("Comfaca");
            $arEntidad->setNit("891190047-2");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF13");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(84);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(84);
            $arEntidad->setNombre("Confamiliares");
            $arEntidad->setNit("890806490-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF11");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(85);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(85);
            $arEntidad->setNombre("Comfacauca");
            $arEntidad->setNit("891500182-0");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF14");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(86);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(86);
            $arEntidad->setNombre("Comfacauca");
            $arEntidad->setNit("892399989-8");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF15");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(87);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(87);
            $arEntidad->setNombre("Comfacor");
            $arEntidad->setNit("891080005-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF16");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(88);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(88);
            $arEntidad->setNombre("Cafam");
            $arEntidad->setNit("860013570-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF21");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(89);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(89);
            $arEntidad->setNombre("Colsubsidio");
            $arEntidad->setNit("860007336-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF22");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(90);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(90);
            $arEntidad->setNombre("Compensar");
            $arEntidad->setNit("860066942-7");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF22");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(91);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(91);
            $arEntidad->setNombre("Comfacundi");
            $arEntidad->setNit("860045904-7");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF26");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(92);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(92);
            $arEntidad->setNombre("Comfachocó");
            $arEntidad->setNit("891600091-8");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF29");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(93);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(93);
            $arEntidad->setNombre("Comfamiliar Guajira");
            $arEntidad->setNit("892115006-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF30");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(94);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(94);
            $arEntidad->setNombre("Comfamiliar Huila");
            $arEntidad->setNit("891180008-2");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF32");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(95);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(95);
            $arEntidad->setNombre("Cajamag");
            $arEntidad->setNit("891780093-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF33");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(96);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(96);
            $arEntidad->setNombre("Cofrem");
            $arEntidad->setNit("892000146-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF34");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(97);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(97);
            $arEntidad->setNombre("Comfamiliar Nariño");
            $arEntidad->setNit("891280008-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF35");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(98);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(98);
            $arEntidad->setNombre("Comfaoriente");
            $arEntidad->setNit("890500675-6");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF36");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(99);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(99);
            $arEntidad->setNombre("Comfanorte");
            $arEntidad->setNit("890500516-3");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF37");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(100);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(100);
            $arEntidad->setNombre("Cafaba");
            $arEntidad->setNit("890270275-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF38");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(101);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(101);
            $arEntidad->setNombre("Cajasan");
            $arEntidad->setNit("890200106-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF39");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(102);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(101);
            $arEntidad->setNombre("Comfenalco Santander");
            $arEntidad->setNit("890201578-7");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF40");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(103);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(103);
            $arEntidad->setNombre("Comfasucre");
            $arEntidad->setNit("892200015-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF40");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(104);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(104);
            $arEntidad->setNombre("Comfenalco Quindío");
            $arEntidad->setNit("890000381-0");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF43");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(105);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(105);
            $arEntidad->setNombre("Comfamiliar Risaralda");
            $arEntidad->setNit("890000381-0");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF43");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(106);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(106);
            $arEntidad->setNombre("Cafasur");
            $arEntidad->setNit("890704737-0");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF46");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(107);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(107);
            $arEntidad->setNombre("Comfatolima");
            $arEntidad->setNit("800211025-1");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF48");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(108);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(108);
            $arEntidad->setNombre("Comfenalco Tolima");
            $arEntidad->setNit("890700148-4");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF50");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(109);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(109);
            $arEntidad->setNombre("Comfenalco Valle");
            $arEntidad->setNit("890303093-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF56");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(110);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(110);
            $arEntidad->setNombre("Comfandi");
            $arEntidad->setNit("890303208-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF57");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(111);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(111);
            $arEntidad->setNombre("Comfamiliar Putumayo");
            $arEntidad->setNit("891200337-8");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF63");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(112);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(112);
            $arEntidad->setNombre("Cajasai");
            $arEntidad->setNit("892400320-5");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF64");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(113);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(113);
            $arEntidad->setNombre("Cafamaz");
            $arEntidad->setNit("800003122-6");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF65");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(114);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(114);
            $arEntidad->setNombre("Comfiar");
            $arEntidad->setNit("800219488-4");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF67");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(115);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(115);
            $arEntidad->setNombre("Comcaja");
            $arEntidad->setNit("800231969-4");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF68");
            $manager->persist($arEntidad);
        }
        $arEntidad = $manager->getRepository(\App\Entity\RecursoHumano\RhuEntidad::class)->find(116);
        if(!$arEntidad) {
            $arEntidad = new \App\Entity\RecursoHumano\RhuEntidad();
            $arEntidad->setCodigoEntidadPk(116);
            $arEntidad->setNombre("Comfacasanare");
            $arEntidad->setNit("844003392-8");
            $arEntidad->setEps(False);
            $arEntidad->setArl(False);
            $arEntidad->setCcf(true);
            $arEntidad->setCes(False);
            $arEntidad->setPen(False);
            $arEntidad->setCodigoInterface("CCF69");
            $manager->persist($arEntidad);
        }
        $manager->flush();
    }
}