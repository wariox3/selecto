<?php

namespace App\Repository\RecursoHumano;

use App\Entity\RecursoHumano\RhuAdicional;
use App\Entity\RecursoHumano\RhuConcepto;
use App\Entity\RecursoHumano\RhuConceptoHora;
use App\Entity\RecursoHumano\RhuConfiguracion;
use App\Entity\RecursoHumano\RhuConsecutivo;
use App\Entity\RecursoHumano\RhuContrato;
use App\Entity\RecursoHumano\RhuCredito;
use App\Entity\RecursoHumano\RhuCreditoPago;
use App\Entity\RecursoHumano\RhuPago;
use App\Entity\RecursoHumano\RhuPagoDetalle;
use App\Entity\RecursoHumano\RhuProgramacion;
use App\Entity\RecursoHumano\RhuProgramacionDetalle;
use App\Entity\RecursoHumano\RhuVacacion;
use App\Utilidades\Mensajes;
use function Complex\add;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class RhuAdicionalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RhuAdicional::class);
    }

    public function lista($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(RhuAdicional::class, 'a')
            ->select('a.codigoAdicionalPk')
            ->addSelect('a.fecha')
            ->addSelect('a.codigoConceptoFk')
            ->addSelect('cp.nombre AS concepto')
            ->addSelect('e.numeroIdentificacion AS identificacionEmpleado')
            ->addSelect('e.nombreCorto AS empleado')
            ->addSelect('a.detalle')
            ->addSelect('a.vrValor')
            ->addSelect('a.permanente')
            ->addSelect('a.aplicaNomina')
            ->addSelect('a.aplicaPrima')
            ->addSelect('a.estadoInactivo')
            ->leftJoin('a.conceptoRel', 'cp')
            ->leftJoin('a.empleadoRel', 'e')
            ->leftJoin('a.contratoRel', 'c')
            ->where("a.codigoEmpresaFk = {$codigoEmpresa}");

        return $queryBuilder;
    }

}