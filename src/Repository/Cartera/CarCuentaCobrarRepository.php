<?php

namespace App\Repository\Cartera;

use App\Entity\Cartera\CarCuentaCobrar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class CarCuentaCobrarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarCuentaCobrar::class);
    }

    public function informe()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarCuentaCobrar::class, 'cc')
            ->select('cc.codigoCuentaCobrarPk')
            ->addSelect('cc.codigoCuentaCobrarTipoFk')
            ->addSelect('cc.numeroDocumento')
            ->addSelect('cc.fecha')
            ->addSelect('cc.fechaVence')
            ->addSelect('cc.operacion')
            ->addSelect('cct.nombreCorto as nombre')
            ->addSelect('cc.vrSubtotal')
            ->addSelect('cc.vrTotalBruto')
            ->addSelect('cc.vrAbono')
            ->addSelect('cc.vrSaldoOriginal')
            ->addSelect('cc.vrSaldo')
            ->addSelect('cc.vrIva')
            ->addSelect('cc.vrSaldoOperado')
            ->addSelect('cc.estadoAutorizado')
            ->addSelect('cc.estadoAprobado')
            ->addSelect('cc.estadoAnulado')
            ->addSelect('cc.codigoEmpresaFk')
            ->leftJoin('cc.terceroRel','cct');
        if ($session->get('filtroInformeCuentasCobrarFechaDesde') != null) {
            $queryBuilder->andWhere("cc.fecha >= '{$session->get('filtroInformeCuentasCobrarFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroInformeCuentasCobrarFechaHasta') != null) {
            $queryBuilder->andWhere("cc.fecha <= '{$session->get('filtroInformeCuentasCobrarFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroInformeCuentasCobrarNombreCorto') != '') {
            $queryBuilder->andWhere("cct.nombreCorto like '%{$session->get('filtroInformeCuentasCobrarNombreCorto')}%'");
        }
        $queryBuilder->orderBy("cc.fecha", 'DESC');
        return $queryBuilder;
    }
}