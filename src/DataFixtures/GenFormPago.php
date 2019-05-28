<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GenFormPago extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arFormaPago = $manager->getRepository(\App\Entity\General\GenFormaPago::class)->find(1);
        if(!$arFormaPago){
            $arFormaPago = new \App\Entity\General\GenFormaPago();
            $arFormaPago->setCodigoFormaPagoPk(1);
            $arFormaPago->setNombre('CREDITO');
            $manager->persist($arFormaPago);
        }
        $arFormaPago = $manager->getRepository(\App\Entity\General\GenFormaPago::class)->find(2);
        if(!$arFormaPago){
            $arFormaPago = new \App\Entity\General\GenFormaPago();
            $arFormaPago->setCodigoFormaPagoPk(2);
            $arFormaPago->setNombre('CONTADO');
            $manager->persist($arFormaPago);
        }

        $manager->flush();
    }
}
