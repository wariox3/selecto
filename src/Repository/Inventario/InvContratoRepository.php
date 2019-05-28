<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvContrato;
use App\Entity\Inventario\InvContratoDetalle;
use App\Entity\General\GenDocumento;
use App\Entity\Inventario\InvItem;
use App\Entity\Inventario\InvMovimiento;
use App\Entity\Inventario\InvMovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class InvContratoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvContrato::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.numero')
            ->addSelect('c.fecha')
            ->addSelect('c.referencia')
            ->addSelect('ct.nombreCorto AS cliente')
            ->addSelect('c.estadoAutorizado')
            ->addSelect('c.estadoAprobado')
            ->addSelect('c.estadoAnulado')
            ->leftJoin('c.terceroRel', 'ct')
            ->andWhere('c.codigoEmpresaFk = ' . $empresa);
        if ($session->get('filtroContratoFechaDesde') != null) {
            $queryBuilder->andWhere("c.fecha >= '{$session->get('filtroContratoFechaDesde')} 00:00:00'");
        }
        if ($session->get('filtroContratoFechaHasta') != null) {
            $queryBuilder->andWhere("c.fecha <= '{$session->get('filtroContratoFechaHasta')} 23:59:59'");
        }
        if ($session->get('filtroContratoTercero')) {
            $queryBuilder->andWhere("c.codigoTerceroFk = '{$session->get('filtroContratoTercero')}'");
        }
        $queryBuilder->orderBy("c.codigoContratoPk", 'DESC');
        return $queryBuilder;
    }

    public function listaGenerarFactura($codigoEmpresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->addSelect('c.numero')
            ->addSelect('c.fecha')
            ->addSelect('c.referencia')
            ->addSelect('ct.nombreCorto AS clienteNombre')
            ->addSelect('ct.numeroIdentificacion AS clienteIdentificacion')
            ->addSelect('c.vrSubtotal')
            ->addSelect('c.vrIva')
            ->addSelect('c.vrTotalNeto')
            ->addSelect('c.estadoAutorizado')
            ->addSelect('c.estadoAprobado')
            ->addSelect('c.estadoAnulado')
            ->leftJoin('c.terceroRel', 'ct')
        ->where("c.codigoEmpresaFk = ${codigoEmpresa}" );
        $queryBuilder->orderBy("c.codigoContratoPk", 'DESC');
        return $queryBuilder;
    }

    public function generarFacturaTodos($codigoEmpresa)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $em->createQueryBuilder()->from(InvContrato::class, 'c')
            ->select('c.codigoContratoPk')
            ->where("c.codigoEmpresaFk = ${codigoEmpresa}")
            ->andWhere("c.estadoAprobado=1");
        $arContratos = $queryBuilder->getQuery()->getResult();
        foreach ($arContratos as $arContrato) {
            $this->generarFactura($codigoEmpresa, $arContrato['codigoContratoPk']);
        }
        $em->flush();
    }

    public function generarFacturaSeleccionados($codigoEmpresa, $arrSeleccionados)
    {
        $em = $this->getEntityManager();
        if($arrSeleccionados) {
            foreach ($arrSeleccionados as $codigo) {
                $this->generarFactura($codigoEmpresa, $codigo);
            }
        }
        $em->flush();
    }

    private function generarFactura($codigoEmpresa, $codigoContrato)
    {
        $em = $this->getEntityManager();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContratoDetalle::class, 'cd')
            ->select('cd.codigoContratoDetallePk')
            ->addSelect('cd.codigoItemFk')
            ->addSelect('cd.cantidad')
            ->addSelect('cd.porcentajeIva')
            ->addSelect('cd.vrPrecio')
            ->addSelect('cd.vrIva')
            ->addSelect('cd.vrSubtotal')
            ->addSelect('cd.vrTotal')
            ->where('cd.codigoContratoFk = ' . $codigoContrato);
        $arContratoDetalles = $queryBuilder->getQuery()->getResult();
        if($arContratoDetalles) {
            /** @var $arContrato InvContrato */
            $arContrato = $em->getRepository(InvContrato::class)->find($codigoContrato);
            $arDocumento = $em->getRepository(GenDocumento::class)->find('FAC');
            $arFactura = new InvMovimiento();
            $arFactura->setCodigoEmpresaFk($codigoEmpresa);
            $arFactura->setDocumentoRel($arDocumento);
            $arFactura->setTerceroRel($arContrato->getTerceroRel());
            $arFactura->setPlazoPago($arContrato->getTerceroRel()->getPlazoPago());
            $arFactura->setFormaPagoRel($arContrato->getTerceroRel()->getFormaPagoRel());
            $arFactura->setFecha(new \DateTime('now'));
            $arFactura->setVrSubtotal($arContrato->getVrSubtotal());
            $arFactura->setVrTotalBruto($arContrato->getVrTotalBruto());
            $arFactura->setVrTotalNeto($arContrato->getVrTotalNeto());
            $arFactura->setVrIva($arContrato->getVrIva());
            $arFactura->setEstadoAutorizado(1);
            $em->persist($arFactura);
            /** @var $arContratoDetalle InvContratoDetalle */
            foreach ($arContratoDetalles as $arContratoDetalle) {
                $arItem = $em->getRepository(InvItem::class)->find($arContratoDetalle['codigoItemFk']);
                $arFacturaDetalle = new InvMovimientoDetalle();
                $arFacturaDetalle->setItemRel($arItem);
                $arFacturaDetalle->setMovimientoRel($arFactura);
                $arFacturaDetalle->setCodigoEmpresaFk($codigoEmpresa);
                $arFacturaDetalle->setCantidad($arContratoDetalle['cantidad']);
                $arFacturaDetalle->setPorcentajeIva($arContratoDetalle['porcentajeIva']);
                $arFacturaDetalle->setVrPrecio($arContratoDetalle['vrPrecio']);
                $arFacturaDetalle->setVrIva($arContratoDetalle['vrIva']);
                $arFacturaDetalle->setVrSubtotal($arContratoDetalle['vrSubtotal']);
                $arFacturaDetalle->setVrTotal($arContratoDetalle['vrTotal']);
                $em->persist($arFacturaDetalle);
            }
            $em->getRepository(InvMovimiento::class)->aprobar($arFactura);
        }
    }


    /**
     * @param $arContrato InvContrato
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function liquidar($arContrato)
    {
        $em = $this->getEntityManager();
        $vrSubtotalGlobal = 0;
        $vrTotalBrutoGlobal = 0;
        $vrIvaGlobal = 0;
        $arContratoDetalles = $this->getEntityManager()->getRepository(InvContratoDetalle::class)->findBy(['codigoContratoFk' => $arContrato->getCodigoContratoPk()]);
        foreach ($arContratoDetalles as $arContratoDetalle) {
            $vrSubtotal = $arContratoDetalle->getVrSubtotal();
            $vrSubtotalGlobal += $vrSubtotal;
            $vrTotal = $arContratoDetalle->getVrTotal();
            $vrTotalBrutoGlobal += $vrTotal;
            $vrIva = $arContratoDetalle->getVrIva();
            $vrIvaGlobal += $vrIva;
        }
        $arContrato->setVrSubtotal($vrSubtotalGlobal);
        $arContrato->setVrTotalBruto($vrTotalBrutoGlobal);
        $arContrato->setVrIva($vrIvaGlobal);
        $arContrato->setVrTotalNeto($vrTotalBrutoGlobal);
        $em->persist($arContrato);
        $em->flush();
    }

    /**
     * @param $codigoContrato
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function contarDetalles($codigoContrato)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvContratoDetalle::class, 'cd')
            ->select("COUNT(cd.codigoContratoDetallePk)")
            ->where("cd.codigoContratoFk = {$codigoContrato} ");
        $resultado = $queryBuilder->getQuery()->getSingleResult();
        return $resultado[1];
    }

    /**
     * @param $arContrato InvContrato
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function desautorizar($arContrato)
    {
        if ($arContrato->getEstadoAprobado() == 0) {
            $arContrato->setEstadoAutorizado(0);
            $this->getEntityManager()->persist($arContrato);
            $this->getEntityManager()->flush();

        } else {
            Mensajes::error('El registro ya se encuentra aprobado');
        }
    }

    /**
     * @param $arContrato InvContrato
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function autorizar($arContrato)
    {
        if ($this->getEntityManager()->getRepository(InvContrato::class)->contarDetalles($arContrato->getCodigoContratoPk()) > 0) {
            $arContrato->setEstadoAutorizado(1);
            $this->getEntityManager()->persist($arContrato);
            $this->getEntityManager()->flush();
        } else {
            Mensajes::error("El registro no tiene detalles");
        }
    }
}