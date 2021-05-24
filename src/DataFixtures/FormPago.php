<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FormPago extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arFormaPago = $manager->getRepository(\App\Entity\FormaPago::class)->find('CON');
        if(!$arFormaPago){
            $arFormaPago = new \App\Entity\General\GenFormaPago();
            $arFormaPago->setCodigoFormaPagoPk('CON');
            $arFormaPago->setNombre('CONTADO');
            $manager->persist($arFormaPago);
        }
        $arFormaPago = $manager->getRepository(\App\Entity\FormaPago::class)->find('CRE');
        if(!$arFormaPago){
            $arFormaPago = new \App\Entity\FormaPago();
            $arFormaPago->setCodigoFormaPagoPk('CRE');
            $arFormaPago->setNombre('CREDITO');
            $manager->persist($arFormaPago);
        }
        $manager->flush();
    }
}
