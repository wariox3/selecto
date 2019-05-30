<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuConfiguracion;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuPagoDetalle;
use App\Entity\RecursoHumano\RhuProgramacionDetalle;
use App\Entity\RecursoHumano\RhuVacacion;
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

    public function cargarContratos($arProgramacion, $codigoEmpresa)
    {
        $em = $this->getEntityManager();
        $arConfiguracion = $em->getRepository(RhuConfiguracion::class)->cargarContratos();
        $arContratos = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'c')
            ->select("c")
            ->where("c.codigoEmpresaFk = {$codigoEmpresa}")
            ->andWhere("c.codigoGrupoFk = '{$arProgramacion->getCodigoGrupoFk()}'")
            ->andWhere("c.fechaDesde >= '{$arProgramacion->getFechaDesde()->format('Y-m-d')}'")
            ->andWhere("c.fechaHasta <= '{$arProgramacion->getFechaHasta()->format('Y-m-d')}'")
            ->andWhere("c.fechaUltimoPago < '{$arProgramacion->getFechaHastaPeriodo()->format('Y-m-d')}' OR c.indefinido = 1")
            ->getQuery()->execute();

        foreach ($arContratos as $arContrato){
            $arProgramacionDetalle = new RhuProgramacionDetalle();
            $arProgramacionDetalle->setProgramacionRel($arProgramacion);
            $arProgramacionDetalle->setEmpleadoRel($arContrato->getEmpleadoRel());
            $arProgramacionDetalle->setContratoRel($arContrato);
            $arProgramacionDetalle->setVrSalario($arContrato->getVrSalario());

            if ($arContrato->getContratoTipoRel()->getCodigoContratoClaseFk() == 'APR' || $arContrato->getContratoTipoRel()->getCodigoContratoClaseFk() == 'PRA') {
                $arProgramacionDetalle->setDescuentoPension(0);
                $arProgramacionDetalle->setDescuentoSalud(0);
                $arProgramacionDetalle->setPagoAuxilioTransporte(0);
            }

            if ($arContrato->getCodigoPensionFk() == 'PEN') {
                $arProgramacionDetalle->setDescuentoPension(0);
            }
            $fechaDesde = $this->fechaDesdeContrato($arProgramacion->getFechaDesde(), $arContrato->getFechaDesde());
            $fechaHasta = $this->fechaHastaContrato($arProgramacion->getFechaHasta(), $arContrato->getFechaHasta(), $arContrato->getIndefinido());
            $dias = $fechaDesde->diff($fechaHasta)->days + 1;
            $arProgramacionDetalle->setFechaDesde($arProgramacion->getFechaDesde());
            $arProgramacionDetalle->setFechaHasta($arProgramacion->getFechaHasta());
            $arProgramacionDetalle->setFechaDesdeContrato($fechaDesde);
            $arProgramacionDetalle->setFechaHastaContrato($fechaHasta);
            $arrIbc = $em->getRepository(RhuPagoDetalle::class)->ibcMes($fechaDesde->format('Y'), $fechaDesde->format('m'), $arContrato->getCodigoContratoPk(), $arConfiguracion['codigoConceptoFondoPensionFk']);
            $arProgramacionDetalle->setVrDeduccionFondoPensionAnterior($arrIbc['deduccionAnterior']);
            $arrVacaciones = $em->getRepository(RhuVacacion::class)->diasProgramacion($arContrato->getCodigoEmpleadoFk(), $arContrato->getCodigoContratoPk(), $arProgramacion->getFechaDesde()->format('Y-m-d'), $arProgramacion->getFechaHasta()->format('Y-m-d'));
            $arProgramacionDetalle->setDiasVacaciones($arrVacaciones['dias']);
            $dias -= $arrVacaciones['dias'];
            $horas = $dias * $arContrato->getFactorHorasDia();
            $arProgramacionDetalle->setDias($dias);
            $arProgramacionDetalle->setDiasTransporte($dias);
            $arProgramacionDetalle->setHorasDiurnas($horas);
            $em->persist($arProgramacionDetalle);
        }
        $em->flush();
    }

    private function fechaDesdeContrato($fechaDesdePeriodo, $fechaDesdeContrato)
    {
        $fechaDesde = $fechaDesdeContrato;
        if ($fechaDesdeContrato < $fechaDesdePeriodo) {
            $fechaDesde = $fechaDesdePeriodo;
        }
        return $fechaDesde;
    }

    private function fechaHastaContrato($fechaHastaPeriodo, $fechaHastaContrato, $indefinido)
    {
        $fechaHasta = $fechaHastaContrato;
        if ($indefinido) {
            $fecha = date_create(date('Y-m-d'));
            date_modify($fecha, '+100000 day');
            $fechaHasta = $fecha;
        }
        if ($fechaHasta > $fechaHastaPeriodo) {
            $fechaHasta = $fechaHastaPeriodo;
        }
        return $fechaHasta;
    }


}