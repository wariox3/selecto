<?php

namespace App\Repository;

use App\Entity\General\GenBanco;
use App\Entity\Resolucion;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class ResolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resolucion::class);
    }

    public function lista($empresa)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Resolucion::class, 'r')
            ->select('r.codigoResolucionPk')
            ->addSelect('r.nombre')
            ->addSelect('r.numero')
            ->addSelect('r.fecha')
            ->addSelect('r.fechaDesde')
            ->addSelect('r.fechaHasta')
            ->addSelect('r.prefijo')
            ->addSelect('r.numeroDesde')
            ->addSelect('r.numeroHasta')
            ->addSelect('r.ambiente')
            ->where('r.codigoEmpresaFk = ' . $empresa );

        $queryBuilder->addOrderBy('r.codigoResolucionPk', 'DESC');
        return $queryBuilder->getQuery()->getResult();
    }

    public function eliminar($arrDetallesSeleccionados)
    {
        $em = $this->getEntityManager();
        if ($arrDetallesSeleccionados) {
            if (count($arrDetallesSeleccionados)) {
                foreach ($arrDetallesSeleccionados as $codigo) {
                    $ar = $em->getRepository(Resolucion::class)->find($codigo);
                    if ($ar) {
                        $em->remove($ar);
                    }
                }
                try {
                    $em->flush();
                } catch (\Exception $e) {
                    Mensajes::error('No se puede eliminar, el registro se encuentra en uso en el sistema');
                }
            }
        }
    }
}