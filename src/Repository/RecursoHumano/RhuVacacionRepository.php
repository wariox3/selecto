<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuCredito;
use App\Entity\RecursoHumano\RhuVacacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RhuVacacionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuVacacion::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuVacacion::class, 'v');
        $queryBuilder
            ->select('v');
        return $queryBuilder;
    }

    public function diasProgramacion($codigoEmpleado, $codigoContrato, $fechaDesde, $fechaHasta)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()->from(RhuVacacion::class, 'v')
            ->select('v.codigoVacacionPk')
            ->addSelect('v.fechaDesdeDisfrute')
            ->addSelect('v.fechaHastaDisfrute')
            ->andWhere("(((v.fechaDesdeDisfrute BETWEEN '$fechaDesde' AND '$fechaHasta') OR (v.fechaHastaDisfrute BETWEEN '$fechaDesde' AND '$fechaHasta')) "
                . "OR (v.fechaDesdeDisfrute >= '$fechaDesde' AND v.fechaDesdeDisfrute <= '$fechaHasta') "
                . "OR (v.fechaHastaDisfrute >= '$fechaHasta' AND v.fechaDesdeDisfrute <= '$fechaDesde')) "
                . "AND v.codigoEmpleadoFk = '" . $codigoEmpleado . "' AND v.diasDisfrutados > 0 AND v.estadoAnulado = 0");
        if ($codigoContrato) {
            $query->andWhere("v.codigoContratoFk = " . $codigoContrato);
        }
        $arVacaciones = $query->getQuery()->getResult();
        $intDiasDevolver = 0;
        $vrIbc = 0;
        foreach ($arVacaciones as $arVacacion) {
            $intDias = 0;
            $dateFechaDesde = date_create($fechaDesde);
            $dateFechaHasta = date_create($fechaHasta);
            if ($arVacacion['fechaDesdeDisfrute'] < $dateFechaDesde) {
                $dateFechaDesde = $dateFechaDesde;
            } else {
                $dateFechaDesde = $arVacacion['fechaDesdeDisfrute'];
            }

            if ($arVacacion['fechaHastaDisfrute'] > $dateFechaHasta) {
                $dateFechaHasta = $dateFechaHasta;
            } else {
                $dateFechaHasta = $arVacacion['fechaHastaDisfrute'];
            }
            if ($dateFechaDesde != "" && $dateFechaHasta != "") {
                $intDias = $dateFechaDesde->diff($dateFechaHasta);
                $intDias = $intDias->format('%a');
                $intDias = $intDias + 1;
                $intDiasDevolver += $intDias;
            }
            $vrIbc += 0;
            //$vrIbc += $intDias * $arVacacion->getVrIbcPromedio();
        }
        $arrDevolver = array('dias' => $intDiasDevolver, 'ibc' => $vrIbc);
        return $arrDevolver;

    }

    public function dias($codigoEmpleado, $codigoContrato, $fechaDesde, $fechaHasta)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuVacacion::class, 'v')
            ->select('v')
            ->where("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaHastaDisfrute >= '{$strFechaDesde}' AND v.fechaHastaDisfrute <= '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute >= '{$strFechaHasta}' AND v.fechaDesdeDisfrute <= '{$strFechaDesde}'")
            ->andWhere('v.diasDisfrutados > 0')
            ->andWhere('v.estadoAnulado = 0');

//        $em = $this->getEntityManager();
//        $strFechaDesde = $fechaDesde->format('Y-m-d');
//        $strFechaHasta = $fechaHasta->format('Y-m-d');
//        $dql = "SELECT v FROM App/Entity/RecursoHumano/RhuVacacion v "
//            . "WHERE (((v.fechaDesdeDisfrute BETWEEN '$strFechaDesde' AND '$strFechaHasta') OR (v.fechaHastaDisfrute BETWEEN '$strFechaDesde' AND '$strFechaHasta')) "
//            . "OR (v.fechaDesdeDisfrute >= '$strFechaDesde' AND v.fechaDesdeDisfrute <= '$strFechaHasta') "
//            . "OR (v.fechaHastaDisfrute >= '$strFechaHasta' AND v.fechaDesdeDisfrute <= '$strFechaDesde')) "
//            . "AND v.codigoEmpleadoFk = '" . $codigoEmpleado . "' AND v.diasDisfrutados > 0 AND v.estadoAnulado = 0";
//        if ($codigoContrato != "") {
//            $dql .= " AND v.codigoContratoFk = {$codigoContrato}";
//        }

        $arVacaciones = $queryBuilder->getQuery()->getResult();
        $intDiasDevolver = 0;
        $vrIbc = 0;
        foreach ($arVacaciones as $arVacacion) {
            $intDias = 0;
            $dateFechaDesde = "";
            $dateFechaHasta = "";
            if ($arVacacion->getFechaDesdeDisfrute() < $fechaDesde == true) {
                $dateFechaDesde = $fechaDesde;
            } else {
                $dateFechaDesde = $arVacacion->getFechaDesdeDisfrute();
            }

            if ($arVacacion->getFechaHastaDisfrute() > $fechaHasta == true) {
                $dateFechaHasta = $fechaHasta;
            } else {
                $dateFechaHasta = $arVacacion->getFechaHastaDisfrute();
            }
            if ($dateFechaDesde != "" && $dateFechaHasta != "") {
                $intDias = $dateFechaDesde->diff($dateFechaHasta);
                $intDias = $intDias->format('%a');
                $intDias = $intDias + 1;
                $intDiasDevolver += $intDias;
            }
            $vrIbc += $intDias * $arVacacion->getVrIbcPromedio();
        }
        $arrDevolver = array('dias' => $intDiasDevolver, 'ibc' => $vrIbc);
        return $arrDevolver;
    }

    public function diasPeriodo($fechaDesde, $fechaHasta)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuVacacion::class, 'v')
            ->select('v')
            ->where("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaHastaDisfrute >= '{$strFechaDesde}' AND v.fechaHastaDisfrute <= '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute >= '{$strFechaHasta}' AND v.fechaDesdeDisfrute <= '{$strFechaDesde}'")
            ->andWhere('v.diasDisfrutados > 0')
            ->andWhere('v.estadoAnulado = 0');
        return $queryBuilder;
    }

    public function validarVacacion($fechaDesde, $fechaHasta, $codigoEmpleado)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $boolValidar = TRUE;

        $qb = $this->getEntityManager()->createQueryBuilder()->from(RhuVacacion::class, 'v')
            ->select("count(v.codigoVacacionPk) AS vacaciones")
            ->where("v.fechaDesdeDisfrute <= '{$strFechaHasta}' AND  v.fechaHastaDisfrute >= '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute <= '{$strFechaDesde}' AND  v.fechaHastaDisfrute >='{$strFechaDesde}' AND v.codigoEmpleadoFk = '{$codigoEmpleado}'")
            ->orWhere("v.fechaDesdeDisfrute >= '{$strFechaDesde}' AND  v.fechaHastaDisfrute <='{$strFechaHasta}' AND v.codigoEmpleadoFk = '{$codigoEmpleado}'")
            ->andWhere("v.codigoEmpleadoFk = '{$codigoEmpleado}' AND v.estadoAnulado = 0 ");
        $r = $qb->getQuery();
        $arrVacaciones = $r->getResult();
        if ($arrVacaciones[0]['vacaciones'] > 0) {
            $boolValidar = FALSE;
        }

        return $boolValidar;
    }

    public function periodo($fechaDesde, $fechaHasta, $codigoEmpleado)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuVacacion::class, 'v')
            ->select('v')
            ->where("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("v.fechaHastaDisfrute >= '{$strFechaDesde}' AND v.fechaHastaDisfrute <= '{$strFechaHasta}'")
            ->orWhere("v.fechaDesdeDisfrute >= '{$strFechaHasta}' AND v.fechaDesdeDisfrute <= '{$strFechaDesde}'")
            ->andWhere('v.diasDisfrutados > 0')
            ->andWhere('v.estadoAnulado = 0')
        ->andWhere("v.codigoEmpleadoFk = {$codigoEmpleado}");
        return $queryBuilder->getQuery()->getResult();
    }

}