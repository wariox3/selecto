<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvContrato;
use App\Entity\Inventario\InvContratoDetalle;
use App\Entity\Inventario\InvMovimiento;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class InvContratoDetalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvContratoDetalle::class);
    }

    public function lista($id)
    {
//        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContratoDetalle::class, 'cd')
            ->select('cd.codigoContratoDetallePk')
            ->addSelect('i.codigoItemPk AS item')
            ->addSelect('i.descripcion')
            ->addSelect('i.referencia AS referencia')
            ->addSelect(' cd.cantidad')
            ->addSelect('cd.vrPrecio')
            ->addSelect('cd.vrSubtotal')
            ->addSelect('cd.porcentajeIva')
            ->addSelect('cd.vrIva')
            ->addSelect('cd.vrTotal')
            ->leftJoin("cd.itemRel", "i")
            ->where('cd.codigoContratoFk = ' . $id);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $arrControles
     * @param $form
     * @param $arContrato InvContrato
     * @param $arContratoDetalle InvContratoDetalle
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function actualizarDetalles($arrControles, $form, $arContrato)
    {
        $em = $this->getEntityManager();
        if ($this->getEntityManager()->getRepository(InvContrato::class)->contarDetalles($arContrato->getCodigoContratoPk()) > 0) {
            $arrCantidad = $arrControles['arrCantidad'];
            $arrPrecio = $arrControles['arrValor'];
            $arrCodigo = $arrControles['arrCodigo'];
            foreach ($arrCodigo as $codigoContratoDetalle) {
                $arContratoDetalle = $this->getEntityManager()->getRepository(InvContratoDetalle::class)->find($codigoContratoDetalle);
                $arContratoDetalle->setCantidad($arrCantidad[$codigoContratoDetalle]);
                $arContratoDetalle->setVrPrecio($arrPrecio[$codigoContratoDetalle]);
                $arContratoDetalle->setVrSubtotal($arContratoDetalle->getVrPrecio() * $arContratoDetalle->getCantidad());
                $arContratoDetalle->setVrIva($arContratoDetalle->getVrSubtotal() * $arContratoDetalle->getPorcentajeIva() / 100);
                $arContratoDetalle->setvrTotal($arContratoDetalle->getVrSubtotal() + $arContratoDetalle->getVrIva());
                $em->persist($arContratoDetalle);
                $em->flush();
            }
            $em->getRepository(InvContrato::class)->liquidar($arContrato);
            $this->getEntityManager()->flush();
        }
    }

    public function eliminar($arContrato, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if (count($arrSeleccionados) > 0) {
            foreach ($arrSeleccionados as $codigoContratoDetalle) {
                $arContratoDetalle = $em->getRepository(InvContratoDetalle::class)->find($codigoContratoDetalle);
                if ($arContratoDetalle) {
                    $em->remove($arContratoDetalle);
                }
            }
            $em->flush();
        }
    }

}