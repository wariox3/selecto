<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuCredito;
use App\Entity\RecursoHumano\RhuNovedad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuNovedadRepository extends ServiceEntityRepository
{

    /**
     * @return string
     */
    public function getRuta(){
        return 'recursohumano_movimiento_credito_credito_';
    }

    public function __construct(RegistryInterface $registry)
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

    /**
     * @return array
     */
    public function parametrosLista(){
        $arEmbargo = new RhuEmbargo();
        $queryBuilder = $this->_em->createQueryBuilder()->from(RhuEmbargo::class,'re')
            ->select('re.codigoEmbargoPk')
            ->addSelect('re.fecha')
            ->where('re.codigoEmbargoPk <> 0');
        $arrOpciones = ['json' =>'[{"campo":"codigoEmbargoPk","ayuda":"Codigo del embargo","titulo":"ID"},
        {"campo":"fecha","ayuda":"Fecha de registro","titulo":"FECHA"}]',
            'query' => $queryBuilder,'ruta' => $this->getRuta()];
        return $arrOpciones;
    }

    /**
     * @return mixed
     */
    public function parametrosExcel(){
        $queryBuilder = $this->_em->createQueryBuilder()->from(RhuEmbargo::class,'re')
            ->select('re.codigoEmbargoPk')
            ->addSelect('re.fecha')
            ->where('re.codigoEmbargoPk <> 0');
        return $queryBuilder->getQuery()->execute();
    }

    public function periodoEmpresa($fechaDesde, $fechaHasta, $codigoEmpleado = "")
    {
        $em = $this->getEntityManager();
        $strFechaDesde = $fechaDesde->format('Y-m-d');
        $strFechaHasta = $fechaHasta->format('Y-m-d');
        $dql = "SELECT incapacidad FROM RhuNovedad "
            . "WHERE incapacidad.pagarEmpleado = 1 AND (((incapacidad.fechaDesdeEmpresa BETWEEN '$strFechaDesde' AND '$strFechaHasta') OR (incapacidad.fechaHastaEmpresa BETWEEN '$strFechaDesde' AND '$strFechaHasta')) "
            . "OR (incapacidad.fechaDesdeEmpresa >= '$strFechaDesde' AND incapacidad.fechaDesdeEmpresa <= '$strFechaHasta') "
            . "OR (incapacidad.fechaHastaEmpresa >= '$strFechaHasta' AND incapacidad.fechaDesdeEmpresa <= '$strFechaDesde')) ";
        if ($codigoEmpleado != "") {
            $dql = $dql . "AND incapacidad.codigoEmpleadoFk = " . $codigoEmpleado . " ";
        }
        $objQuery = $em->createQuery($dql);
        $arIncapacidades = $objQuery->getResult();
        return $arIncapacidades;
    }


}