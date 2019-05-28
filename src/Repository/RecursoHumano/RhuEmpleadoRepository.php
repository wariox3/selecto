<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\Empleado;
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

        if ($session->get('filtroRhuCodigoEmpleado') != '') {
            $queryBuilder->andWhere("Em.codigoEmpleadoPk = '{$session->get('filtroRhuCodigoEmpleado')}'");
        }
        if ($session->get('filtroRhuNumeroIdentificacion') != '') {
            $queryBuilder->andWhere("Em.numeroIdentificacion LIKE '%{$session->get('filtroRhuNumeroIdentificacion')}%'");
        }
        if ($session->get('filtroRhuNombreCorto') != '') {
            $queryBuilder->andWhere("Em.nombreCorto LIKE '%{$session->get('filtroRhuNombreCorto')}%'");
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