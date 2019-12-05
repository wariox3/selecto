<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmbargo;
use App\Entity\RecursoHumano\RhuLiquidacion;
use App\Entity\RecursoHumano\RhuReclamo;
use function Complex\add;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuLiquidacionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuLiquidacion::class);
    }

    public function lista($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuLiquidacion::class, 'l')
            ->select('l.codigoLiquidacionPk')
            ->addSelect('l.numero')
            ->addSelect('l.fecha')
            ->addSelect('l.codigoEmpleadoFk')
            ->addSelect('l.codigoGrupoFk')
            ->addSelect('l.fechaDesde')
            ->addSelect('l.fechaHasta')
            ->addSelect('l.estadoAutorizado')
            ->addSelect('l.estadoAprobado')
            ->addSelect('l.estadoAnulado')
            ->where("l.codigoEmpresaFk = {$codigoEmpresa}");
        if ($session->get('filtroRhuLiquidacionEmpleado') != ''){
            $queryBuilder->andWhere("l.codigoEmpleadoFk LIKE '%{$session->get('filtroRhuLiquidacionEmpleado')}%'");
        }
        if ($session->get('filtroRhuLiquidacionCodigo') != '') {
            $queryBuilder->andWhere("l.codigoLiquidacionPk = '{$session->get('filtroRhuLiquidacionCodigo')}'");
        }
        if ($session->get('filtroRhuLiquidacionFechaDesde') != null) {
            $queryBuilder->andWhere("l.fechaDesde >= '{$session->get('filtroRhuLiquidacionFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroRhuLiquidacionFechaHasta') != null) {
            $queryBuilder->andWhere("l.fechaHasta <= '{$session->get('filtroRhuLiquidacionFechaHasta')} 23:59:59'");
        }
        switch ($session->get('filtroRhuLiquidacionEstadoAutorizado')) {
            case '0':
                $queryBuilder->andWhere("l.estadoAutorizado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("l.estadoAutorizado = 1");
                break;
        }
        switch ($session->get('filtroRhuLiquidacionEstadoAprobado')) {
            case '0':
                $queryBuilder->andWhere("l.estadoAprobado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("l.estadoAprobado = 1");
                break;
        }
        switch ($session->get('filtroRhuLiquidacionEstadAnulado')) {
            case '0':
                $queryBuilder->andWhere("l.estadoAnulado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("l.estadoAnulado = 1");
                break;
        }
        return $queryBuilder;
    }

    public function diasPrestacionesHasta($intDias, $dateFechaDesde)
    {
        $strFechaHasta = "";
        $intAnio = $dateFechaDesde->format('Y');
        $intMes = $dateFechaDesde->format('n');
        $intDia = $dateFechaDesde->format('j');
        $intDiasAcumulados = 1;
        $i = $intDia;
        while ($intDiasAcumulados <= $intDias) {
            //echo $intDiasAcumulados . "(" . $i . ")" . "(" . $intMes . ")" . "(" . $intAnio . ")" . "<br />";
            $fechaHastaPeriodo = $intAnio . "-" . $intMes . "-" . $i;
            if ($i == 30 || $i == 31) {
                $i = 1;
                if ($intMes == 12) {
                    $intMes = 1;
                    $intAnio++;
                } else {
                    $intMes++;
                }
            } else {
                $i++;
            }
            $intDiasAcumulados++;
        }
        $fechaHastaPeriodo = date_create_from_format('Y-n-j H:i', $fechaHastaPeriodo . " 00:00");
        // validacion para los meses de 31 dias
        if ($intDia == 31 && $intDias == 361) {
            $fechaHastaPeriodo = date_create(date('Y-m-j', strtotime('+1 day', strtotime($fechaHastaPeriodo->format('Y-m-d')))));
        }
        return $fechaHastaPeriodo;
    }

}