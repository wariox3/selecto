<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuCredito;
use App\Entity\RecursoHumano\RhuNovedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuNovedadRepository extends ServiceEntityRepository
{

    /**
     * @return string
     */
    public function getRuta(){
        return 'recursohumano_movimiento_credito_credito_';
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuNovedad::class);
    }

    /**
     * @param $codigoEmpresa
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select('n.codigoNovedadPk')
            ->addSelect('nt.nombre AS tipo')
            ->addSelect('n.fecha')
            ->addSelect('e.nombreCorto AS empleado')
            ->addSelect('e.numeroIdentificacion')
            ->addSelect('e.codigoContratoFk AS contrato')
            ->addSelect('n.fechaDesde')
            ->addSelect('n.fechaHasta')
            ->leftJoin('n.novedadTipoRel', 'nt')
            ->leftJoin('n.empleadoRel', 'e')
            ->where("n.codigoEmpresaFk = {$codigoEmpresa}");

        return $queryBuilder;
    }

//    public function periodoEmpresa($fechaDesde, $fechaHasta, $codigoEmpleado = "")
//    {
//        $em = $this->getEntityManager();
//        $strFechaDesde = $fechaDesde->format('Y-m-d');
//        $strFechaHasta = $fechaHasta->format('Y-m-d');
//        $dql = "SELECT incapacidad FROM RhuNovedad "
//            . "WHERE incapacidad.pagarEmpleado = 1 AND (((incapacidad.fechaDesdeEmpresa BETWEEN '$strFechaDesde' AND '$strFechaHasta') OR (incapacidad.fechaHastaEmpresa BETWEEN '$strFechaDesde' AND '$strFechaHasta')) "
//            . "OR (incapacidad.fechaDesdeEmpresa >= '$strFechaDesde' AND incapacidad.fechaDesdeEmpresa <= '$strFechaHasta') "
//            . "OR (incapacidad.fechaHastaEmpresa >= '$strFechaHasta' AND incapacidad.fechaDesdeEmpresa <= '$strFechaDesde')) ";
//        if ($codigoEmpleado != "") {
//            $dql = $dql . "AND incapacidad.codigoEmpleadoFk = " . $codigoEmpleado . " ";
//        }
//        $objQuery = $em->createQuery($dql);
//        $arIncapacidades = $objQuery->getResult();
//        return $arIncapacidades;
//    }

    public function periodoLicencias($fechaDesde, $fechaHasta, $codigoEmpleado)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select('n')
            ->leftJoin('n.novedadTipoRel', 'nt')
            ->where("n.fechaDesde BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaDesde >= '{$strFechaDesde}' AND n.fechaDesde <= '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta >= '{$strFechaHasta}' AND n.fechaDesde <= '{$strFechaDesde}'")
            ->andWhere('nt.licencia = true')
        ->andWhere("n.codigoEmpleadoFk = {$codigoEmpleado}");
        return $queryBuilder->getQuery()->getResult();
    }

    public function periodoIncapacidades($fechaDesde, $fechaHasta, $codigoEmpleado)
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select('n')
            ->leftJoin('n.novedadTipoRel', 'nt')
            ->where("n.fechaDesde BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaDesde >= '{$strFechaDesde}' AND n.fechaDesde <= '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta >= '{$strFechaHasta}' AND n.fechaDesde <= '{$strFechaDesde}'")
            ->andWhere('nt.incapacidad = true')
        ->andWhere("n.codigoEmpleadoFk = {$codigoEmpleado}");
        return $queryBuilder->getQuery()->getResult();
    }

    public function periodo($fechaDesde, $fechaHasta, $codigoEmpleado = "")
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select('n')
            ->leftJoin('n.novedadTipoRel', 'nt')
            ->where("n.fechaDesde BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaDesde >= '{$strFechaDesde}' AND n.fechaDesde <= '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta >= '{$strFechaHasta}' AND n.fechaDesde <= '{$strFechaDesde}'");
        return $queryBuilder->getQuery()->getResult();
    }

    public function programacionPago ($codigoEmpleado, $fechaDesde, $fechaHasta) {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select('n.codigoNovedadPk')
            ->addSelect('nt.codigoConceptoFk')
            ->addSelect('n.vrValor')
            ->addSelect('n.dias')
            ->leftJoin('n.novedadTipoRel', 'nt')
            ->where('n.estadoAnulado = 0')
            ->andWhere("n.codigoEmpleadoFk = {$codigoEmpleado} ")
            ->andWhere("n.fecha >= '{$fechaDesde}' AND n.fecha <= '{$fechaHasta}'");

        $arrResultado = $queryBuilder->getQuery()->getResult();
        return $arrResultado;
    }

    public function validarFecha($fechaDesde, $fechaHasta, $codigoEmpleado)
    {
        $em = $this->getEntityManager();
        $boolValidar = TRUE;
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $qb = $this->getEntityManager()->createQueryBuilder()->from(RhuNovedad::class, 'n')
            ->select("count(n.codigoNovedadPk) AS novedades")
            ->where("n.fechaDesde BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta BETWEEN '{$strFechaDesde}' AND '{$strFechaHasta}'")
            ->orWhere("n.fechaDesde >= '{$strFechaDesde}' AND n.fechaDesde <= '{$strFechaHasta}'")
            ->orWhere("n.fechaHasta >= '{$strFechaHasta}' AND n.fechaDesde <= '{$strFechaDesde}'")
            ->andWhere("n.codigoEmpleadoFk = '{$codigoEmpleado}'");
        $r = $qb->getQuery();
        $arrNovedades = $r->getResult();
        if ($arrNovedades[0]['novedades'] > 0) {
            $boolValidar = FALSE;
        }

        return $boolValidar;
    }

}