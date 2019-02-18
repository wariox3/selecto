<?php


namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Documento implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $arDocumento = $manager->getRepository("App:Documento")->find(1);
        if (!$arDocumento) {
            $arDocumento = new \App\Entity\Documento();
            $arDocumento->setCodigoDocumentoPk(1);
            $arDocumento->setNombre("Casos");
            $manager->persist($arDocumento);
        }
        $arDocumento = $manager->getRepository("App:Documento")->find(2);
        if (!$arDocumento) {
            $arDocumento = new \App\Entity\Documento();
            $arDocumento->setCodigoDocumentoPk(2);
            $arDocumento->setNombre("Solicitudes");
            $manager->persist($arDocumento);
        }
        $arDocumento = $manager->getRepository("App:Documento")->find(3);
        if (!$arDocumento) {
            $arDocumento = new \App\Entity\Documento();
            $arDocumento->setCodigoDocumentoPk(3);
            $arDocumento->setNombre("Implementacion");
            $manager->persist($arDocumento);
        }
        $manager->flush();
    }
}

