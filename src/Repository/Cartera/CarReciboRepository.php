<?php

namespace App\Repository\Cartera;

use App\Entity\Cartera\CarCuentaCobrarTipo;
use App\Entity\Cartera\CarRecibo;
use App\Entity\Cartera\CarReciboDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class CarReciboRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CarRecibo::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarRecibo::class, 'r')
            ->select('r.codigoReciboPk')
            ->addSelect('r.fecha')
            ->addSelect('r.numero')
            ->addSelect('r.fechaPago')
            ->addSelect('r.vrPago')
            ->addSelect('r.vrPagoTotal')
            ->addSelect('rt.numeroIdentificacion as identificacion')
            ->addSelect('rt.nombreCorto as nombre')
            ->addSelect('rc.cuenta')
            ->addSelect('r.usuario')
            ->addSelect('rc.tipo ')
            ->addSelect('r.estadoAutorizado')
            ->addSelect('r.estadoAprobado')
            ->addSelect('r.estadoAnulado')
            ->leftJoin('r.cuentaRel', 'rc')
            ->leftJoin('r.terceroRel', 'rt')
        ->where('r.codigoEmpresaFk = ' . $empresa);
        if ($session->get('filtroReciboFechaDesde') != null) {
            $queryBuilder->andWhere("r.fecha >= '{$session->get('filtroReciboFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroReciboFechaHasta') != null) {
            $queryBuilder->andWhere("r.fecha <= '{$session->get('filtroReciboFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroMovimientoTercero')) {
            $queryBuilder->andWhere("r.codigoTerceroFk = '{$session->get('filtroMovimientoTercero')}'");
        }
        $queryBuilder->orderBy("r.codigoReciboPk", 'DESC');
        return $queryBuilder;
    }

    /**
     * @param $arRecibos
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function autorizar($arRecibos)
    {
        if ($this->getEntityManager()->getRepository(CarRecibo::class)->contarDetalles($arRecibos->getCodigoReciboPk()) > 0) {
            $arRecibos->setEstadoAutorizado(1);
            $this->getEntityManager()->persist($arRecibos);
            $this->getEntityManager()->flush();
        }
    }

    public function desautorizar($arRecibos)
    {
        if ($arRecibos->getEstadoAprobado() == 0) {
            $arRecibos->setEstadoAutorizado(0);
            $this->getEntityManager()->persist($arRecibos);
            $this->getEntityManager()->flush();

        } else {
            Mensajes::error('El registro ya se encuentra aprobado');
        }
    }

    /**
     * @param $codigoRecibo
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function contarDetalles($codigoRecibo)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(CarReciboDetalle::class, 'rd')
            ->select("COUNT(rd.codigoReciboDetallePk)")
            ->where("rd.codigoReciboFk = {$codigoRecibo} ");
        $resultado = $queryBuilder->getQuery()->getSingleResult();
        return $resultado[1];
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($id)
    {
        $em = $this->getEntityManager();
        $pago = 0;
        $pagoTotal = 0;
        $arRecibo = $em->getRepository(CarRecibo::class)->find($id);
        $arRecibosDetalles = $em->getRepository(CarReciboDetalle::class)->findBy(array('codigoReciboFk' => $id));
        foreach ($arRecibosDetalles as $arReciboDetalle) {
            $pago += $arReciboDetalle->getVrPago() * $arReciboDetalle->getOperacion();
            $pagoTotal += $arReciboDetalle->getVrPagoAfectar();
        }
        $arRecibo->setVrPago($pago);
        $arRecibo->setVrPagoTotal($pagoTotal);
        $em->persist($arRecibo);
        $em->flush();
        return true;
    }

}