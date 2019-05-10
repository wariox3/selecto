<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuEmpleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuEmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuEmpleado::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuEmpleado::class, 'RhuEm')
            ->select('RhuEm.codigoEmpleadoPk')
            ->addSelect('RhuEm.numeroIdentificacion')
            ->addSelect('RhuEm.nombreCorto')
            ->addSelect('RhuEm.telefono')
            ->addSelect('RhuEm.celular')
            ->addSelect('RhuEm.direccion')
            ->addSelect('ciu.nombre as ciudad')
            ->addSelect('RhuEm.correo')
            ->addSelect('RhuEm.fechaNacimiento')
            ->leftJoin('RhuEm.ciudadRel', 'ciu');

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

    public function  listarContratos($id){

    }
}