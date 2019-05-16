<?php

namespace App\Repository\Cartera;

use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CarReciboDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarReciboDetalle::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function lista($id)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarReciboDetalle::class, 'rd')
            ->select('rd.codigoReciboDetallePk')
            ->addSelect('rd.numeroFactura')
            ->addSelect('rd.vrPago')
            ->addSelect('rd.vrPagoAfectar')
            ->addSelect('rdcc.vrTotalBruto as total')
            ->addSelect('rdcct.nombre')
            ->leftJoin('rd.cuentaCobrarRel', 'rdcc')
            ->leftJoin('rd.cuentaCobrarTipoRel', 'rdcct')
            ->where('rd.codigoReciboFk = ' . $id);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $arrControles
     * @param $form
     * @param $arRecibos CarRecibo
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arRecibos)
    {
        $em = $this->getEntityManager();
        if ($this->getEntityManager()->getRepository(CarRecibo::class)->contarDetalles($arRecibos->getCodigoReciboPk()) > 0) {
            $arrCodigo = $arrControles['arrCodigo'];

            foreach ($arrCodigo as $codigoReciboDetalle) {
                $arReciboDetalle = $this->getEntityManager()->getRepository(CarReciboDetalle::class)->find($codigoReciboDetalle);
//                $arReciboDetalle->setCodigoReciboFk($arReciboDetalle->getCodigoReciboPk());
                $arReciboDetalle->setCodigoCuentaCobrarFk($arReciboDetalle->getCodigoCuentaCobrarFk());
                $arReciboDetalle->setCodigoCuentaCobrarTipoFk($arReciboDetalle->getCodigoCuentaCobrarTipoFk());
                $arReciboDetalle->setNumeroFactura($arReciboDetalle->getNumeroFactura());
                $arReciboDetalle->setVrPago($arReciboDetalle->getVrPago());
                $arReciboDetalle->setVrPagoAfectar($arReciboDetalle->getVrPagoAfectar());
                $arReciboDetalle->setUsuario($arReciboDetalle->getUsuario());
                $arReciboDetalle->setOperacion($arReciboDetalle->getOperacion());
                $em->persist($arReciboDetalle);
                $em->flush();
            }
            $em->getRepository(CarRecibo::class)->liquidar($arRecibos);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $arRecibo
     * @param $arrSeleccionados
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function eliminar($arRecibo, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoReciboDetalle) {
                $arReciboDetalle = $em->getRepository(CarReciboDetalle::class)->find($codigoReciboDetalle);
                if ($arReciboDetalle) {
                    $em->remove($arReciboDetalle);
                }
            }
            $em->flush();
        }
    }
}