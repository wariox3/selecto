<?php

namespace App\Repository\Compra;

use App\Entity\Compra\ComEgreso;
use App\Entity\Compra\ComEgresoDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ComEgresoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComEgresoDetalle::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($id)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComEgresoDetalle::class, 'ed')
            ->select('ed.codigoEgresoDetallePk')
            ->addSelect('ed.numeroCompra')
            ->addSelect('ed.vrPago')
            ->addSelect('ed.vrPagoAfectar')
            ->addSelect('edcp.vrTotalBruto as total')
            ->leftJoin('ed.cuentaPagarRel', 'edcp')
            ->where('ed.codigoEgresoFk = ' . $id);
        return $queryBuilder->getQuery()->getResult();
    }
//
    /**
     * @param $arrControles
     * @param $form
     * @param $arEgresos ComEgreso
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arEgresos)
    {
        $em = $this->getEntityManager();
        if ($this->getEntityManager()->getRepository(ComEgreso::class)->contarDetalles($arEgresos->getCodigoEgresoPk()) > 0) {
            $arrCodigo = $arrControles['arrCodigo'];

            foreach ($arrCodigo as $codigoEgresoDetalle) {
                $arEgresoDetalle = $this->getEntityManager()->getRepository(ComEgresoDetalle::class)->find($codigoEgresoDetalle);
                $arEgresoDetalle->setCodigoCuentaPagarFk($arEgresoDetalle->getCodigoCuentaPagarFk());
                $arEgresoDetalle->setCodigoCuentaPagarTipoFk($arEgresoDetalle->getCodigoCuentaPagarTipoFk());
                $arEgresoDetalle->setNumeroCompra($arEgresoDetalle->getNumeroCompra());
                $arEgresoDetalle->setVrPago($arEgresoDetalle->getVrPago());
                $arEgresoDetalle->setVrPagoAfectar($arEgresoDetalle->getVrPagoAfectar());
                $arEgresoDetalle->setUsuario($arEgresoDetalle->getUsuario());
                $arEgresoDetalle->setOperacion($arEgresoDetalle->getOperacion());
                $em->persist($arEgresoDetalle);
                $em->flush();
            }
            $em->getRepository(ComEgreso::class)->liquidar($arEgresos);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $arRecibo
     * @param $arrSeleccionados
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function eliminar($arEgreso, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoEgresoDetalle) {
                $codigoEgresoDetalle = $em->getRepository(ComEgresoDetalle::class)->find($codigoEgresoDetalle);
                if ($codigoEgresoDetalle) {
                    $em->remove($codigoEgresoDetalle);
                }
            }
            $em->flush();
        }
    }

    public function listaFormato($codigoEgreso)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(ComEgresoDetalle::class, 'ed');
        $queryBuilder
            ->select('ed.codigoEgresoDetallePk')
            ->addSelect('tr.nombreCorto AS clienteNombreCorto')
            ->addSelect('cpt.nombre AS cuentaPagarTipo')
            ->addSelect('ed.numeroCompra')
            ->addSelect('cp.fecha')
            ->addSelect('ed.vrPagoAfectar')
            ->leftJoin('ed.egresoRel', 'e')
            ->leftJoin('e.terceroRel', 'tr')
            ->leftJoin('ed.cuentaPagarRel', 'cp')
            ->leftJoin('ed.cuentaPagarTipoRel', 'cpt')
            ->where('ed.codigoEgresoFk = ' . $codigoEgreso);
        $queryBuilder->orderBy('ed.codigoEgresoDetallePk', 'ASC');

        return $queryBuilder->getQuery()->getResult() ;
    }
}