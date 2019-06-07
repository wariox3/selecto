<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RhuNovedadTipo extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('ING');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('ING');
            $arNovedadTipo->setNombre('INCAPACIDAD GENERAL');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(false);
            $arNovedadTipo->setIncapacidad(true);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('INL');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('INL');
            $arNovedadTipo->setNombre('INCAPACIDAD LABORAL');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(false);
            $arNovedadTipo->setIncapacidad(true);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('LNR');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('LNR');
            $arNovedadTipo->setNombre('LICENCIA NO REMUNERADA');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('LR');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('LR');
            $arNovedadTipo->setNombre('LICENCIA REMUNERADA');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('PNR');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('PNR');
            $arNovedadTipo->setNombre('PERMISO NO REMUNERADO');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('PR');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('PR');
            $arNovedadTipo->setNombre('PERMISO REMUNERADO');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('LPM');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('LPM');
            $arNovedadTipo->setNombre('LICENCIA POR MATERNIDAD');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('LPP');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('LPP');
            $arNovedadTipo->setNombre('LICENCIA POR PATERNIDAD');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $arNovedadTipo = $manager->getRepository(\App\Entity\RecursoHumano\RhuNovedadTipo::class)->find('LPL');
        if(!$arNovedadTipo){
            $arNovedadTipo = new \App\Entity\RecursoHumano\RhuNovedadTipo();
            $arNovedadTipo->setCodigoNovedadTipoPk('LPL');
            $arNovedadTipo->setNombre('LICENCIA POR LUTO');
            $arNovedadTipo->setConceptoRel(null);
            $arNovedadTipo->setLicencia(true);
            $arNovedadTipo->setIncapacidad(false);
            $manager->persist($arNovedadTipo);
        }
        $manager->flush();
    }
}
