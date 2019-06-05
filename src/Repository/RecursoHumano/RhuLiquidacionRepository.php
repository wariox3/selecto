<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuEmbargo;
use App\Entity\RecursoHumano\RhuLiquidacion;
use App\Entity\RecursoHumano\RhuReclamo;
use function Complex\add;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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