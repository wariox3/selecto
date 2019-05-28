<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GenBanco extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(1);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(1);
            $arBanco->setNombre('BANCO DE BOGOTA');
            $arBanco->setCodigoGeneral(1);
            $arBanco->setNit(860002964-4);
            $arBanco->setDireccion('CALLE 36 No. 7-47');
            $arBanco->setTelefono(3383396);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(2);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(2);
            $arBanco->setNombre('BANCO POPULAR S.A');
            $arBanco->setCodigoGeneral(2);
            $arBanco->setNit(860007738-9);
            $arBanco->setDireccion('CALLE 17 No. 7- 35-43');
            $arBanco->setTelefono(7560000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(3);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(3);
            $arBanco->setNombre('ITAU CORBANCA COLOMBIA S.A');
            $arBanco->setCodigoGeneral(6);
            $arBanco->setNit(890903937-0);
            $arBanco->setDireccion('CARRERA 7 No. 99 - 53');
            $arBanco->setTelefono(6448500);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(4);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(4);
            $arBanco->setNombre('BANCOLOMBIA S.A');
            $arBanco->setCodigoGeneral(7);
            $arBanco->setNit(890903938-8);
            $arBanco->setDireccion('CARRERA 48 No. 26 - 85 AVENIDA LOS INDUSTRIALES');
            $arBanco->setTelefono(4040000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(5);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(5);
            $arBanco->setNombre('CITYBANK COLOMBIA');
            $arBanco->setCodigoGeneral(9);
            $arBanco->setNit(860051135-4);
            $arBanco->setDireccion('CARRERA 9A No. 99 - 02 PISO 3');
            $arBanco->setTelefono(4854000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(6);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(6);
            $arBanco->setNombre('BANCO GNB SUDAMERIS S.A.');
            $arBanco->setCodigoGeneral(12);
            $arBanco->setNit(860050750-1);
            $arBanco->setDireccion('CARRERA 7  No 75-85-87 ');
            $arBanco->setTelefono(2750000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(7);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(7);
            $arBanco->setNombre('BANCO BBVA');
            $arBanco->setCodigoGeneral(13);
            $arBanco->setNit(860003020-1);
            $arBanco->setDireccion('CARRERA 9 No. 72-21');
            $arBanco->setTelefono(3471600);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(8);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(8);
            $arBanco->setNombre('BANCO DE OCCIDENTE');
            $arBanco->setCodigoGeneral(23);
            $arBanco->setNit(890300279-4);
            $arBanco->setDireccion('CARRERA 4 No. 7-61 PISO 15 ');
            $arBanco->setTelefono(8861111);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(9);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(9);
            $arBanco->setNombre('BANCO CAJA SOCIAL');
            $arBanco->setCodigoGeneral(30);
            $arBanco->setNit(860007335-4);
            $arBanco->setDireccion('CARRERA 7 No. 77- 65 TORRE COLMENA');
            $arBanco->setTelefono(3138000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(10);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(10);
            $arBanco->setNombre('BANCO DAVIVIENDA');
            $arBanco->setCodigoGeneral(39);
            $arBanco->setNit(860034313-7);
            $arBanco->setDireccion('AVENIDA EL DORADO No. 68 C -61 Piso 10');
            $arBanco->setTelefono(3138000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(11);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(11);
            $arBanco->setNombre('SCOTIABANK COLPATRIA S.A.');
            $arBanco->setCodigoGeneral(42);
            $arBanco->setNit(860034594-1);
            $arBanco->setDireccion('CARRERA 7 No. 24 - 89 Piso 10');
            $arBanco->setTelefono(3386300);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(12);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(12);
            $arBanco->setNombre('BANCO AGRARIO DE COLOMBIA');
            $arBanco->setCodigoGeneral(43);
            $arBanco->setNit(800037800-8);
            $arBanco->setDireccion('CARRERA 8 No. 15 - 43');
            $arBanco->setTelefono(3821400);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(13);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(13);
            $arBanco->setNombre('BANCO AV VILLAS');
            $arBanco->setCodigoGeneral(49);
            $arBanco->setNit(860035827-5);
            $arBanco->setDireccion('CARRERA 13 No. 27- 47');
            $arBanco->setTelefono(2875411);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(14);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(14);
            $arBanco->setNombre('BANCO PROCREDIT');
            $arBanco->setCodigoGeneral(51);
            $arBanco->setNit(900200960-9);
            $arBanco->setDireccion('CALLE 39 No. 13A - 16');
            $arBanco->setTelefono(2875411);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(15);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(15);
            $arBanco->setNombre('BANCAMIA SAS');
            $arBanco->setCodigoGeneral(52);
            $arBanco->setNit(900215071-1);
            $arBanco->setDireccion('CARRERA 9 No. 66 - 25');
            $arBanco->setTelefono(3139300);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(16);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(16);
            $arBanco->setNombre('BANCO W');
            $arBanco->setCodigoGeneral(53);
            $arBanco->setNit(900378212-2);
            $arBanco->setDireccion('AVENIDA 5 NORTE No. 16N - 57 PISO 4');
            $arBanco->setTelefono(6083947);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(17);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(17);
            $arBanco->setNombre('BANCO COOMEVA');
            $arBanco->setCodigoGeneral(54);
            $arBanco->setNit(900406150-5);
            $arBanco->setDireccion('CASA PRINCIPAL CALLE 13 No. 57 -50  PISO 2');
            $arBanco->setTelefono(1);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(18);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(18);
            $arBanco->setNombre('BANCO FINANDINA');
            $arBanco->setCodigoGeneral(55);
            $arBanco->setNit(860051894-6);
            $arBanco->setDireccion('KILOMETRO 17 CARRERTERA CENTRAL DEL NORTE VIA A CHIA');
            $arBanco->setTelefono(6511919);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(19);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(19);
            $arBanco->setNombre('BANCO FALABELLA');
            $arBanco->setCodigoGeneral(56);
            $arBanco->setNit(900047981-8);
            $arBanco->setDireccion('AVENIDA 19 No. 120 - 71 Piso 3');
            $arBanco->setTelefono(5878787);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(20);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(20);
            $arBanco->setNombre('BANCO PICHINCHA');
            $arBanco->setCodigoGeneral(57);
            $arBanco->setNit(890200756-7);
            $arBanco->setDireccion('CARRERA 35 No. 42 - 39');
            $arBanco->setTelefono(6501000);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(21);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(21);
            $arBanco->setNombre('BANCO COOPCENTRAL');
            $arBanco->setCodigoGeneral(58);
            $arBanco->setNit(890203088-9);
            $arBanco->setDireccion('CARRERA 35 No. 42 - 39');
            $arBanco->setTelefono(7431088);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(22);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(22);
            $arBanco->setNombre('BANCO SANTANDER');
            $arBanco->setCodigoGeneral(59);
            $arBanco->setNit(900628110-3);
            $arBanco->setDireccion('CALLE 93 A No. 13-24 PISO 4');
            $arBanco->setTelefono(8399900);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(23);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(23);
            $arBanco->setNombre('BANCO MUNDO MUJER S.A');
            $arBanco->setCodigoGeneral(60);
            $arBanco->setNit(900628110-3);
            $arBanco->setDireccion('CARRERA 11 No. 5 - 56 ');
            $arBanco->setTelefono(3256600);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(24);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(24);
            $arBanco->setNombre('BANCO MULTIBANK S.A');
            $arBanco->setCodigoGeneral(61);
            $arBanco->setNit(860024414-1);
            $arBanco->setDireccion('CARRERA 7 No. 73 - 47 PISO 6 ');
            $arBanco->setTelefono(3256600);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(25);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(25);
            $arBanco->setNombre('BANCO COMPARTIR S.A');
            $arBanco->setCodigoGeneral(62);
            $arBanco->setNit(860025971-5);
            $arBanco->setDireccion('CALLE 16 No. 6 - 66 PISO 4 EDIFICIO AVIANCA');
            $arBanco->setTelefono(2868609);
            $manager->persist($arBanco);
        }
        $arBanco = $manager->getRepository(\App\Entity\General\GenBanco::class)->find(26);
        if(!$arBanco){
            $arBanco = new \App\Entity\General\GenBanco();
            $arBanco->setCodigoBancoPk(26);
            $arBanco->setNombre('BANCO COMPARTIR S.A');
            $arBanco->setCodigoGeneral(63);
            $arBanco->setNit(860043186-6);
            $arBanco->setDireccion('CALLE 72 No. 54 - 63');
            $arBanco->setTelefono(3509131);
            $manager->persist($arBanco);
        }

        $manager->flush();
    }
}
