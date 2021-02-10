<?php

namespace App\Repository\Inventario;

use App\Entity\Inventario\InvItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Session\Session;


class InvItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvItem::class);
    }

    public function lista($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvItem::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.nombre')
            ->addSelect('i.codigo')
            ->addSelect('i.referencia')
            ->addSelect('i.vrPrecio')
            ->addSelect('i.cantidadExistencia')
            ->addSelect('i.porcentajeIva')
            ->addSelect('i.servicio')
            ->addSelect('i.producto')
            ->addSelect('i.afectaInventario')
            ->orderBy('i.codigoItemPk', 'ASC')
            ->where('i.codigoEmpresaFk = '. $empresa);
        if ($session->get('filtroItemId') != '') {
            $queryBuilder->andWhere("i.codigoItemPk = {$session->get('filtroItemId')}");
        }
        if ($session->get('filtroItemCodigo') != '') {
            $queryBuilder->andWhere("i.codigo like '%{$session->get('filtroItemCodigo')}%'");
        }
        if ($session->get('filtroItemReferencia') != '') {
            $queryBuilder->andWhere("i.referencia like '%{$session->get('filtroItemReferencia')}%'");
        }
        if ($session->get('filtroItemNombre') != '') {
            $queryBuilder->andWhere("i.nombre like '%{$session->get('filtroItemNombre')}%'");
        }
        return $queryBuilder;
    }

    public function existencia($empresa)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(InvItem::class, 'i')
            ->select('i.codigoItemPk')
            ->addSelect('i.referencia')
            ->addSelect('i.descripcion')
            ->addSelect('i.cantidadExistencia')
            ->orderBy('i.codigoItemPk', 'ASC')
            ->where('i.servicio = false')
        ->andWhere('i.codigoEmpresaFk = ' . $empresa)
        ->andWhere('i.cantidadExistencia > 0');
        if ($session->get('filtroItemReferencia') != '') {
            $queryBuilder->andWhere("i.referencia like '%{$session->get('filtroItemReferencia')}%'");
        }
        if ($session->get('filtroItemDescripcion') != '') {
            $queryBuilder->andWhere("i.descripcion like '%{$session->get('filtroItemDescripcion')}%'");
        }
        return $queryBuilder;
    }

    public function llenarCombo($empresa)
    {
        $session = new Session();
        $array = [
            'class' => InvItem::class,
            'query_builder' => function (EntityRepository $er) use ($empresa) {
                return $er->createQueryBuilder('i')
                    ->orderBy('i.nombre', 'ASC')
                    ->where('i.codigoEmpresaFk = ' . $empresa);
            },
            'choice_label' => 'nombre',
            'required' => false,
            'empty_data' => "",
            'placeholder' => "TODOS",
            'data' => "",
            'attr' => ['class' => 'form-control to-select-2']
        ];
        if ($session->get('filtroitem')) {
            $array['data'] = $this->getEntityManager()->getReference(InvItem::class, $session->get('filtroitem'));
        }
        return $array;
    }
}