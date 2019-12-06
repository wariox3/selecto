<?php

namespace App\Repository\General;

use App\Entity\General\GenBanco;
use App\Entity\General\GenResolucion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class GenResolucionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenResolucion::class);
    }

    public function lista($empresa)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(GenResolucion::class, 'r')
            ->select('r.codigoResolucionPk')
            ->addSelect('r.numero')
            ->addSelect('r.fecha')
            ->addSelect('r.fechaDesde')
            ->addSelect('r.fechaHasta')
            ->addSelect('r.prefijo')
            ->addSelect('r.numeroDesde')
            ->addSelect('r.numeroHasta')
            ->addSelect('r.llaveTecnica')
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
                    $ar = $em->getRepository(GenResolucion::class)->find($codigo);
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