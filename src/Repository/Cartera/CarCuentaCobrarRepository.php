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

    public function informe($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarCuentaCobrar::class, 'cc')
            ->select('cc.codigoCuentaCobrarPk')
            ->addSelect('cc.codigoCuentaCobrarTipoFk')
            ->addSelect('cc.numeroDocumento')
            ->addSelect('cc.fecha')
            ->addSelect('cc.fechaVence')
            ->addSelect('cc.operacion')
            ->addSelect('cct.numeroIdentificacion as nit')
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
            ->leftJoin('cc.terceroRel', 'cct')
            ->where('cc.codigoEmpresaFk = ' . $empresa);
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

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarCuentaCobrar::class, 'cc')
            ->select('cc.codigoCuentaCobrarPk')
            ->addSelect('cc.plazo')
            ->addSelect('cct.nombre as nombre')
            ->addSelect('cc.numeroDocumento')
            ->addSelect('cc.fecha')
            ->addSelect('cc.fechaVence')
            ->addSelect('cc.vrTotalBruto')
            ->addSelect('cc.vrSaldo')
            ->leftJoin('cc.cuentaCobrarTipoRel', 'cct')
            ->andWhere('cc.codigoEmpresaFk = ' . $empresa)
            ->OrderBy('cc.codigoCuentaCobrarPk', 'ASC');

        return $queryBuilder;
    }

    public function cuentasCobrar($empresa, $cliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarCuentaCobrar::class, 'cc')
            ->select('cc.codigoCuentaCobrarPk')
            ->addSelect('cc.plazo')
            ->addSelect('cct.nombre as nombre')
            ->addSelect('cc.numeroDocumento')
            ->addSelect('cc.fecha')
            ->addSelect('cc.fechaVence')
            ->addSelect('cc.vrTotalBruto')
            ->addSelect('cc.vrSaldo')
            ->leftJoin('cc.cuentaCobrarTipoRel', 'cct')
            ->where('cc.vrSaldo <> 0')
            ->andWhere('cc.codigoEmpresaFk = ' . $empresa)
            ->andWhere('cc.codigoTerceroFk = ' . $cliente)
            ->OrderBy('cc.codigoCuentaCobrarPk', 'ASC');

        return $queryBuilder;
    }
}