<?php

namespace App\Repository;

use App\Entity\Tercero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class TerceroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tercero::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Tercero::class, 't')
            ->select('t.codigoTerceroPk')
            ->addSelect('t.nombreCorto')
            ->addSelect('t.numeroIdentificacion')
            ->addSelect('t.telefono')
            ->addSelect('c.nombre AS ciudad')
            ->addSelect('t.direccion')
            ->addSelect('t.celular')
            ->addSelect('t.email')
            ->addSelect('t.digitoVerificacion')
            ->addSelect('t.cliente')
            ->addSelect('t.proveedor')
            ->addSelect('t.codigoIdentificacionFk')
            ->leftJoin('t.ciudadRel', 'c')
        ->where('t.codigoEmpresaFk = ' . $empresa );
        $queryBuilder->orderBy("t.codigoTerceroPk", 'DESC');
        if ($session->get('filtroTerceroCodigo') != '') {
            $queryBuilder->andWhere("t.codigoTerceroPk  ='{$session->get('filtroTerceroCodigo')}'");
        }
        if ($session->get('filtroTerceroNombreCorto') != '') {
            $queryBuilder->andWhere("t.nombreCorto like '%{$session->get('filtroTerceroNombreCorto')}%'");
        }
        switch ($session->get('filtroTerceroCliente')) {
            case '0':
                $queryBuilder->andWhere("t.cliente = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.cliente = 1");
                break;
        }
        switch ($session->get('filtroTerceroProveedor')) {
            case '0':
                $queryBuilder->andWhere("t.proveedor = 0");
                break;
            case '1':
                $queryBuilder->andWhere("t.proveedor = 1");
                break;
        }
        return $queryBuilder;
    }

    public function llenarCombo($empresa)
    {
        $session = new Session();
        $array = [
            'class' => Tercero::class,
            'query_builder' => function (EntityRepository $er) use ($empresa) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.nombreCorto', 'ASC')
                    ->where('t.codigoEmpresaFk = ' . $empresa);
            },
            'choice_label' => 'nombreCorto',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => "",
            'attr' => ['class' => 'form-control to-select-2']
        ];
        if ($session->get('filtroTercero')) {
            $array['data'] = $this->getEntityManager()->getReference(Tercero::class, $session->get('filtroTercero'));
        }
        return $array;
    }
}