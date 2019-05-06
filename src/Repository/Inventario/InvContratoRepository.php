<?php

namespace App\Repository\Inventario;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Compra\ComCuentaPagar;
use App\Entity\Compra\ComCuentaPagarTipo;
use App\Entity\Inventario\InvContrato;
use App\Entity\Inventario\InvContratoDetalle;
use App\Entity\Inventario\InvDocumento;
use App\Entity\Inventario\InvItem;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class InvContratoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvContrato::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.estadoAutorizado')
            ->addSelect('c.estadoAprobado')
            ->addSelect('c.estadoAnulado')
            ->addSelect('t.nombreCorto AS tercero')
            ->leftJoin('c.terceroRel', 't');
        if ($session->get('filtroContratoTercero')) {
            $queryBuilder->andWhere("c.codigoTerceroFk = '{$session->get('filtroContratoTercero')}'");
        }
        $queryBuilder->orderBy("c.codigoContratoPk", 'DESC');
        return $queryBuilder;
    }

    public function generarFactura($codigoEmpresa)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(InvContrato::class, 'c')
            ->select('c.codigoContratoPk');
        $arContratos = $queryBuilder->getQuery()->getResult();
        foreach ($arContratos as $arContrato) {
            $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContratoDetalle::class, 'cd')
                ->select('cd.codigoContratoDetallePk');
            $arContratoDetalles = $queryBuilder->getQuery()->getResult();
            if($arContratoDetalles) {
                $arContrato = $em->getRepository(InvContrato::class)->find($arContrato['codigoContratoPk']);
                $arDocumento = $em->getRepository(InvDocumento::class)->find('FAC');
                $arFactura = new InvMovimiento();
                $arFactura->setCodigoEmpresaFk($codigoEmpresa);
                $arFactura->setDocumentoRel($arDocumento);
                $arFactura->setTerceroRel($arContrato->getTerceroRel());
                $em->persist($arFactura);
            }
        }
        $em->flush();
    }
}