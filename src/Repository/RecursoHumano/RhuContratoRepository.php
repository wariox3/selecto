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

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'rhuCon')
            ->select('rhuCon.codigoContratoPk')
            ->addSelect('Tipo.nombre as tipoContrato')
            ->addSelect('Empleado.nombreCorto as nombreCorto')
            ->addSelect('Empleado.numeroIdentificacion as numeroIdentificacion')
            ->addSelect('rhuCon.numero')
            ->addSelect('Grupo.nombre as grupo')
            ->addSelect('Cargo.nombre as cargo')
            ->addSelect('rhuCon.vrSalario')
            ->addSelect('rhuCon.tiempo')
            ->addSelect('rhuCon.estadoTerminado')
            ->addSelect('rhuCon.fechaDesde')
            ->addSelect('rhuCon.fechaHasta')
            ->addSelect('rhuCon.codigoEmpleadoFk')
            ->leftJoin('rhuCon.empleadoRel' , 'Empleado')
            ->leftJoin('rhuCon.contratoTipoRel' , 'Tipo')
            ->leftJoin('rhuCon.grupoRel' , 'Grupo')
            ->leftJoin('rhuCon.cargoRel' , 'Cargo');
        $queryBuilder->orderBy('rhuCon.codigoContratoPk', 'DESC');

        if ($session->get('filtroRhuContratoCodigoContato') != '') {
            $queryBuilder->andWhere("rhuCon.codigoContratoPk = '{$session->get('filtroRhuContratoCodigoContato')}'");
        }
        if ($session->get('filtroRhuContratoNumeroIdentificacion') != '') {
            $queryBuilder->andWhere("Empleado.numeroIdentificacion LIKE '%{$session->get('filtroRhuContratoNumeroIdentificacion')}%'");
        }
        if ($session->get('filtroRhuContratoNombreCorto') != '') {
            $queryBuilder->andWhere("Empleado.nombreCorto LIKE '%{$session->get('filtroRhuContratoNombreCorto')}%'");
        }
        if ($session->get('filtroRhuContratoGrupo') != '') {
            $queryBuilder->andWhere("rhuCon.codigoGrupoFk = '{$session->get('filtroRhuContratoGrupo')}'");
        }
        if ($session->get('filtroRhuContratoEstado') != '') {
            $queryBuilder->andWhere("rhuCon.estadoTerminado LIKE '%{$session->get('filtroRhuContratoEstado')}%'");
        }


        return $queryBuilder;
    }
}