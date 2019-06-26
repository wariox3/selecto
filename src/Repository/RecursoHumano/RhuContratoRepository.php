<?php


namespace App\Repository\RecursoHumano;


use App\Entity\RecursoHumano\RhuConfiguracion;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuNovedad;
use App\Entity\RecursoHumano\RhuPagoDetalle;
use App\Entity\RecursoHumano\RhuProgramacion;
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
            ->leftJoin('c.empleadoRel', 'Empleado')
            ->leftJoin('c.contratoTipoRel', 'Tipo')
            ->leftJoin('c.grupoRel', 'Grupo')
            ->leftJoin('c.cargoRel', 'Cargo')
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

    /**
     * @param $arProgramacion RhuProgramacion
     * @param $codigoEmpresa
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function cargarContratos($arProgramacion, $codigoEmpresa)
    {
        /**
         * @var $arProgramacionDetalle RhuProgramacionDetalle
         */
        $em = $this->getEntityManager();
        $arConfiguracion = $em->getRepository(RhuConfiguracion::class)->cargarContratos();
        $em->getRepository(RhuProgramacionDetalle::class)->eliminarTodoDetalles($arProgramacion);
        $arContratos = $this->getEntityManager()->createQueryBuilder()->from(RhuContrato::class, 'c')
            ->select("c")
            ->where("c.codigoEmpresaFk = {$codigoEmpresa}")
            ->andWhere("c.codigoGrupoFk = '{$arProgramacion->getCodigoGrupoFk()}'")
            ->andWhere("c.fechaUltimoPago < '{$arProgramacion->getFechaHastaPeriodo()->format('Y-m-d')}'")
            ->andWhere("c.fechaDesde <= '{$arProgramacion->getFechaHastaPeriodo()->format('Y-m-d')}'")
            ->andWhere("(c.fechaHasta >= '{$arProgramacion->getFechaDesde()->format('Y-m-d')}' OR c.indefinido=1)")
            ->getQuery()->execute();

        foreach ($arContratos as $arContrato) {
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
            $dateFechaDesde = "";
            $dateFechaHasta = "";
            $intDiasDevolver = 0;
            $fechaFinalizaContrato = $arContrato->getFechaHasta();
            if ($arContrato->getIndefinido() == 1) {
                $fecha = date_create(date('Y-m-d'));
                date_modify($fecha, '+100000 day');
                $fechaFinalizaContrato = $fecha;
            }
            if ($arContrato->getFechaDesde() < $arProgramacion->getFechaDesde() == true) {
                $dateFechaDesde = $arProgramacion->getFechaDesde();
            } else {
                if ($arContrato->getFechaDesde() > $arProgramacion->getFechaHasta() == true) {
                    if ($arContrato->getFechaDesde() == $arProgramacion->getFechaHastaReal()) {
                        $dateFechaDesde = $arProgramacion->getFechaHastaReal();
                        $intDiasDevolver = 1;
                    } else {
                        $intDiasDevolver = 0;
                    }
                } else {
                    $dateFechaDesde = $arContrato->getFechaDesde();
                }
            }
            if ($fechaFinalizaContrato > $arProgramacion->getFechaHasta() == true) {
                $dateFechaHasta = $arProgramacion->getFechaHasta();
            } else {
                if ($fechaFinalizaContrato < $arProgramacion->getFechaDesde() == true) {
                    $intDiasDevolver = 0;
                } else {
                    $dateFechaHasta = $fechaFinalizaContrato;
                }
            }
            if ($dateFechaDesde != "" && $dateFechaHasta != "") {
                $intDias = $dateFechaDesde->diff($dateFechaHasta);
                $intDias = $intDias->format('%a');
                $intDiasDevolver = $intDias + 1;
                $intDiasPeriodoReales = $intDias + 1;
                //Mes de febrero para periodos NO continuos
                $intDiasInhabilesFebrero = 0;
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
//            $arrVacaciones = $em->getRepository(RhuVacacion::class)->diasProgramacion($arContrato->getCodigoEmpleadoFk(), $arContrato->getCodigoContratoPk(), $arProgramacion->getFechaDesde()->format('Y-m-d'), $arProgramacion->getFechaHasta()->format('Y-m-d'));
//            $arProgramacionDetalle->setDiasVacaciones($arrVacaciones['dias']);
//            $dias -= $arrVacaciones['dias'];

            /*
             * Se cargan los dias correspondientes a vacaciones del periodo
             */
            $arrVacaciones = $em->getRepository(RhuVacacion::class)->diasProgramacion($arContrato->getCodigoEmpleadoFk(), $arContrato->getCodigoContratoPk(), $arProgramacion->getFechaDesde()->format('Y-m-d'), $arProgramacion->getFechaHasta()->format('Y-m-d'));
            $intDiasVacaciones = $arrVacaciones['dias'];
            if ($intDiasVacaciones > 0) {
                $arProgramacionDetalle->setDiasVacacion($intDiasVacaciones);
                $arProgramacionDetalle->setIbcVacacion($arrVacaciones['ibc']);
            }

            /*
             * Se cargan las licencias correspondientes al periodo
             */
            $intDiasLicencia = 0;
            $arLicencias = new RhuNovedad();
            $arLicencias = $em->getRepository(RhuNovedad::class)->periodoLicencias($arProgramacionDetalle->getFechaDesde(), $arProgramacionDetalle->getFechaHasta(), $arContrato->getCodigoEmpleadoFk());
            foreach ($arLicencias as $arLicencia) {
                $fechaDesde = $arProgramacionDetalle->getFechaDesde();
                $fechaHasta = $arProgramacionDetalle->getFechaHasta();
                if ($arLicencia->getFechaDesde() > $fechaDesde) {
                    $fechaDesde = $arLicencia->getFechaDesde();
                }
                if ($arLicencia->getFechaHasta() < $fechaHasta) {
                    $fechaHasta = $arLicencia->getFechaHasta();
                }
                $intDias = $fechaDesde->diff($fechaHasta);
                $intDias = $intDias->format('%a');
                $intDias += 1;
                $intDiasLicencia += $intDias;
            }
            if ($intDiasLicencia > 0) {
                $arProgramacionDetalle->setDiasLicencia($intDiasLicencia);
            }

            /*
             * Se cargan las incapacidades correspondientes al periodo
             */
            $intDiasIncapacidad = 0;
            $arIncapacidades = new RhuNovedad();
            $arIncapacidades = $em->getRepository(RhuNovedad::class)->periodoIncapacidades($arProgramacionDetalle->getFechaDesde(), $arProgramacionDetalle->getFechaHasta(), $arContrato->getCodigoEmpleadoFk());
            foreach ($arIncapacidades as $arIncapacidad) {
                $fechaDesde = $arProgramacionDetalle->getFechaDesde();
                $fechaHasta = $arProgramacionDetalle->getFechaHasta();
                if ($arIncapacidad->getFechaDesde() > $fechaDesde) {
                    $fechaDesde = $arIncapacidad->getFechaDesde();
                }
                if ($arIncapacidad->getFechaHasta() < $fechaHasta) {
                    $fechaHasta = $arIncapacidad->getFechaHasta();
                }
                $intDias = $fechaDesde->diff($fechaHasta);
                $intDias = $intDias->format('%a');
                $intDias += 1;
                $intDiasIncapacidad += $intDias;
            }
            if ($intDiasIncapacidad > 0) {
                $arProgramacionDetalle->setDiasIncapacidad($intDiasIncapacidad);
            }

            $diasNovedad = $intDiasIncapacidad + $intDiasLicencia + $intDiasVacaciones;
            $dias = $intDiasDevolver - $diasNovedad;
            $horasNovedad = ($intDiasIncapacidad + $intDiasLicencia + $intDiasVacaciones) * $arContrato->getFactorHorasDia();
            $horasDiurnas = ($intDiasDevolver * $arContrato->getFactorHorasDia()) - $horasNovedad;
            if ($intDiasPeriodoReales == $diasNovedad) {
                $dias = 0;
                $horasDiurnas = 0;
            }

            $horas = $dias * $arContrato->getFactorHorasDia();
            $arProgramacionDetalle->setDias($dias);
            $arProgramacionDetalle->setDiasTransporte($dias);
            $arProgramacionDetalle->setHorasDiurnas($horas);
            $arProgramacionDetalle->setFactorDia($arContrato->getFactorHorasDia());


            $em->persist($arProgramacionDetalle);
            $em->flush();
        }

        $cantidad = $em->getRepository(RhuProgramacion::class)->cantidadRegistros($arProgramacion->getCodigoProgramacionPk());
        $arProgramacion->setCantidad($cantidad);
        $arProgramacion->setEmpleadosGenerados(1);
        $em->persist($arProgramacion);
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