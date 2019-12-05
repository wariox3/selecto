<?php

namespace App\Repository\Compra;

use App\Entity\Cartera\CarCuentaCobrar;
use App\Entity\Compra\ComCuentaPagar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class ComCuentaPagarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComCuentaPagar::class);
    }

    public function informe($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComCuentaPagar::class, 'cp')
            ->select('cp.codigoCuentaPagarPk')
            ->addSelect('cp.codigoCuentaPagarTipoFk')
            ->addSelect('cp.numeroDocumento')
            ->addSelect('cp.fecha')
            ->addSelect('cp.fechaVence')
            ->addSelect('cp.operacion')
            ->addSelect('cpt.numeroIdentificacion as nit')
            ->addSelect('cpt.nombreCorto as nombre')
            ->addSelect('cp.vrSubtotal')
            ->addSelect('cp.vrTotalBruto')
            ->addSelect('cp.vrAbono')
            ->addSelect('cp.vrSaldoOriginal')
            ->addSelect('cp.vrSaldo')
            ->addSelect('cp.vrIva')
            ->addSelect('cp.vrSaldoOperado')
            ->addSelect('cp.estadoAutorizado')
            ->addSelect('cp.estadoAprobado')
            ->addSelect('cp.estadoAnulado')
            ->addSelect('cp.codigoEmpresaFk')
            ->leftJoin('cp.terceroRel', 'cpt')
        ->where('cp.codigoEmpresaFk = ' . $empresa);
        if ($session->get('filtroInformeCuentasPagarFechaDesde') != null) {
            $queryBuilder->andWhere("cp.fecha >= '{$session->get('filtroInformeCuentasPagarFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroInformeCuentasPagarFechaHasta') != null) {
            $queryBuilder->andWhere("cp.fecha <= '{$session->get('filtroInformeCuentasPagarFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroInformeCuentasPagarNombreCorto') != '') {
            $queryBuilder->andWhere("cpt.nombreCorto like '%{$session->get('filtroInformeCuentasPagarNombreCorto')}%'");
        }
        $queryBuilder->orderBy('cp.fecha', 'DESC');
        return $queryBuilder;
    }

    public function cuentasPagar($empresa, $cliente)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComCuentaPagar::class, 'cp')
            ->select('cp.codigoCuentaPagarPk')
            ->addSelect('cp.plazo')
            ->addSelect('cpt.nombre')
            ->addSelect('cp.numeroDocumento')
            ->addSelect('cp.fecha')
            ->addSelect('cp.fechaVence')
            ->addSelect('cp.vrTotalBruto')
            ->addSelect('cp.vrSaldo')
            ->leftJoin('cp.cuentaPagarTipoRel', 'cpt')
            ->where('cp.vrSaldo <> 0')
            ->andWhere('cp.codigoEmpresaFk = ' . $empresa)
            ->andWhere('cp.codigoTerceroFk = ' . $cliente)
            ->OrderBy('cp.codigoCuentaPagarPk', 'ASC');

        return $queryBuilder;
    }
}