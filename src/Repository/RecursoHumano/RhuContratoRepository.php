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

        if ($session->get('filtroRhuCodigoEmpleado') != '') {
            $queryBuilder->andWhere("RhuEm.codigoEmpleadoPk = '{$session->get('filtroRhuCodigoEmpleado')}'");
        }
        if ($session->get('filtroRhuNumeroIdentificacion') != '') {
            $queryBuilder->andWhere("RhuEm.numeroIdentificacion LIKE '%{$session->get('filtroRhuNumeroIdentificacion')}%'");
        }
        if ($session->get('filtroRhuNombreCorto') != '') {
            $queryBuilder->andWhere("RhuEm.nombreCorto LIKE '%{$session->get('filtroRhuNombreCorto')}%'");
        }


        return $queryBuilder;
    }
}