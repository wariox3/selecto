<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmbargo;
use App\Entity\RecursoHumano\RhuLiquidacion;
use App\Entity\RecursoHumano\RhuReclamo;
use function Complex\add;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuLiquidacionRepository extends ServiceEntityRepository
{

    /**
     * @return string
     */
    public function getRuta(){
        return 'recursohumano_movimiento_reclamo_reclamo_';
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

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuLiquidacion::class);
    }

//    /**
//     * @return \Doctrine\ORM\QueryBuilder
//     */
//    public function lista()
//    {
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuReclamo::class, 'e');
//        $queryBuilder
//            ->select('e.codigoEmbargoPk');
//        return $queryBuilder;
//    }

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


}