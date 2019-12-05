<?php

namespace App\Repository\General;

use App\Entity\Empresa;
use App\Entity\General\GenConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class EmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empresa::class);
    }

    public function parametro($campo, $empresa): string
    {
        $em = $this->getEntityManager();
        $dato = "";
        $query = $em->createQuery(
            "SELECT e.".$campo."
        FROM App\Entity\Empresa e 
        WHERE e.codigoEmpresaPk = " . $empresa. ""
        );
        $arConfiguracion = $query->getSingleResult();
        if($arConfiguracion) {
            $dato = $arConfiguracion[$campo];
        }
        return $dato;

    }

    public function informacionFacturacion($empresa){
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Empresa::class, 'e')
            ->select('e.codigoEmpresaPk')
            ->addSelect('e.numeracionDesde')
            ->addSelect('e.numeracionHasta')
            ->addSelect('e.numeroResolucionDianFactura')
            ->addSelect('e.fechaDesdeVigencia')
            ->addSelect('e.fechaHastaVigencia')
            ->addSelect('e.prefijoFacturacion')
            ->addSelect('e.informacionCuentaPago')
            ->where('e.codigoEmpresaPk = '. $empresa);
        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function formato($codigoEmpresa) {
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Empresa::class, 'e')
            ->select('e.codigoEmpresaPk')
            ->addSelect('e.formatoFactura')
            ->where("e.codigoEmpresaPk = {$codigoEmpresa}");
        $arConfiguracion = $queryBuilder->getQuery()->getResult();
        return $arConfiguracion[0];
    }

    public function generarFacturaMasiva($codigoEmpresa) {
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(GenConfiguracion::class, 'c')
            ->select('c.codigoConfiguracionPk')
            ->addSelect('c.codigoItemInteresMora')
            ->addSelect('c.generaInteresMora')
            ->addSelect('c.porcentajeInteresMora')
            ->where("c.codigoConfiguracionPk = {$codigoEmpresa}");
        $arConfiguracion = $queryBuilder->getQuery()->getResult();
        return $arConfiguracion[0];
    }

}