<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuContrato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuContratoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuContrato::class);
    }

    public function lista($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('Tipo.nombre as tipoContrato')
            ->addSelect('Empleado.nombreCorto as nombreCorto')
            ->addSelect('Empleado.numeroIdentificacion as numeroIdentificacion')
            ->addSelect('c.numero')
            ->addSelect('Grupo.nombre as grupo')
            ->addSelect('Cargo.nombre as cargo')
            ->addSelect('c.vrSalario')
            ->addSelect('c.tiempo')
            ->addSelect('c.estadoTerminado')
            ->addSelect('c.fechaDesde')
            ->addSelect('c.fechaHasta')
            ->addSelect('c.codigoEmpleadoFk')
            ->leftJoin('c.empleadoRel' , 'Empleado')
            ->leftJoin('c.contratoTipoRel' , 'Tipo')
            ->leftJoin('c.grupoRel' , 'Grupo')
            ->leftJoin('c.cargoRel' , 'Cargo')
            ->where("c.codigoEmpresaFk = {$codigoEmpresa}");
        $queryBuilder->orderBy('c.codigoContratoPk', 'DESC');

        if ($session->get('filtroRhuContratoCodigoContato') != '') {
            $queryBuilder->andWhere("c.codigoContratoPk = '{$session->get('filtroRhuContratoCodigoContato')}'");
        }
        if ($session->get('filtroRhuContratoNumeroIdentificacion') != '') {
            $queryBuilder->andWhere("Empleado.numeroIdentificacion LIKE '%{$session->get('filtroRhuContratoNumeroIdentificacion')}%'");
        }
        if ($session->get('filtroRhuContratoNombreCorto') != '') {
            $queryBuilder->andWhere("Empleado.nombreCorto LIKE '%{$session->get('filtroRhuContratoNombreCorto')}%'");
        }
        if ($session->get('filtroRhuContratoGrupo') != '') {
            $queryBuilder->andWhere("c.codigoGrupoFk = '{$session->get('filtroRhuContratoGrupo')}'");
        }
        if ($session->get('filtroRhuContratoEstado') != '') {
            $queryBuilder->andWhere("c.estadoTerminado LIKE '%{$session->get('filtroRhuContratoEstado')}%'");
        }


        return $queryBuilder;
    }
}