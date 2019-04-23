<?php

namespace App\Repository\Compra;

use App\Entity\Compra\ComCuentaPagar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class ComCuentaPagarRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComCuentaPagar::class);
    }

    public function informe()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComCuentaPagar::class, 'cp')
            ->select('cp.codigoCuentaPagarPk')
            ->addSelect('cp.codigoCuentaPagarTipoFk')
            ->addSelect('cp.numeroDocumento')
            ->addSelect('cp.fecha')
            ->addSelect('cp.fechaVence')
            ->addSelect('cp.operacion')
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
            ->leftJoin('cp.terceroRel','cpt');
        if ($session->get('filtroInformeCuentasPagarFechaDesde') != null) {
            $queryBuilder->andWhere("cp.fecha >= '{$session->get('filtroInformeCuentasPagarFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroInformeCuentasPagarFechaHasta') != null) {
            $queryBuilder->andWhere("cp.fecha <= '{$session->get('filtroInformeCuentasPagarFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroInformeCuentasPagarNombreCorto') != '') {
            $queryBuilder->andWhere("cpt.nombreCorto like '%{$session->get('filtroInformeCuentasPagarNombreCorto')}%'");
        }
        $queryBuilder->orderBy('cp.fecha','DESC');
        return $queryBuilder;
    }
}