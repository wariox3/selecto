<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\Empleado;
use App\Entity\RecursoHumano\RhuEmpleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class RhuEmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RhuEmpleado::class);
    }

    public function lista($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuEmpleado::class, 'em')
            ->select('em.codigoEmpleadoPk')
            ->addSelect('em.numeroIdentificacion')
            ->addSelect('em.nombreCorto')
            ->addSelect('em.telefono')
            ->addSelect('em.celular')
            ->addSelect('em.direccion')
            ->addSelect('ciu.nombre as ciudad')
            ->addSelect('em.correo')
            ->addSelect('em.fechaNacimiento')
            ->leftJoin('em.ciudadRel', 'ciu')
            ->where("em.codigoEmpresaFk = {$codigoEmpresa}");

        if ($session->get('filtroRhuEmpleadoCodigo') != '') {
            $queryBuilder->andWhere("em.codigoEmpleadoPk = '{$session->get('filtroRhuEmpleadoCodigo')}'");
        }
        if ($session->get('filtroRhuEmpleadoNumeroIdentificacion') != '') {
            $queryBuilder->andWhere("em.numeroIdentificacion LIKE '%{$session->get('filtroRhuEmpleadoNumeroIdentificacion')}%'");
        }
        if ($session->get('filtroRhuEmpleadoNombreCorto') != '') {
            $queryBuilder->andWhere("em.nombreCorto LIKE '%{$session->get('filtroRhuEmpleadoNombreCorto')}%'");
        }


        return $queryBuilder;
    }

    public function  listarContratos($id, $codigoEmpresa){
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'C')
            ->select('C.codigoContratoPk')
            ->addSelect('Tipo.nombre as tipoContrato')
            ->addSelect('C.numero')
            ->addSelect('Grupo.nombre as grupo')
            ->addSelect('Cargo.nombre as cargo')
            ->addSelect('Riesgo.nombre as riesgo')
            ->addSelect('C.fechaDesde')
            ->addSelect('C.fechaHasta')
            ->addSelect('C.vrSalario')
            ->addSelect('C.estadoTerminado')
            ->leftJoin('C.contratoTipoRel' , 'Tipo')
            ->leftJoin('C.grupoRel' , 'Grupo')
            ->leftJoin('C.clasificacionRiesgoRel' , 'Riesgo')
            ->leftJoin('C.cargoRel' , 'Cargo')
            ->leftJoin('C.empleadoRel' , 'emp')
            ->where("C.codigoEmpleadoFk = {$id}")
            ->andWhere("emp.codigoEmpresaFk = {$codigoEmpresa}");
        
        $queryBuilder->orderBy('C.codigoContratoPk', 'DESC');
        return $queryBuilder;
    }

    public function llenarCombo($empresa)
    {
        $session = new Session();
        $array = [
            'class' => RhuEmpleado::class,
            'query_builder' => function (EntityRepository $er) use ($empresa) {
                return $er->createQueryBuilder('e')
                    ->orderBy('e.nombreCorto', 'ASC')
                    ->where('e.codigoEmpresaFk = ' . $empresa);
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => ""
        ];
        if ($session->get('filtroEmpleado')) {
            $array['data'] = $this->getEntityManager()->getReference(RhuEmpleado::class, $session->get('filtroEmpleado'));
        }
        return $array;
    }
}