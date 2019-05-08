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
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'RhuCon')
            ->select('RhuCon.codigoContratoPk')
            ->addSelect('ct.nombre')
            ->addSelect('em.nombreCorto')
            ->addSelect('em.nombreCorto')
            ->leftJoin('RhuCon.empleadoRel', 'em')
            ->leftJoin('RhuCon.contratoTipoRel', 'ct');

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