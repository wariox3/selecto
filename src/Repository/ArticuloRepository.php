<?php

namespace App\Repository;

use App\Entity\Articulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticuloRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articulo::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Articulo::class, 'n')
            ->select('n.codigoArticuloPk')
            ->addSelect('n.codigoArticuloTipoFk')
            ->addSelect('n.numero')
            ->addSelect('n.nombre')
            ->addSelect('n.descripcion')
            ->addSelect('n.codigoGrupoFk')
            ->addSelect('n.codigoSubgrupoFk')
            ->addSelect('n.codigoEntidadFk')
            ->addSelect('n.codigoJurisdiccionFk')
            ->addSelect('n.codigoMatrizFk')
            ->addSelect('nt.nombre as articuloTipoNombre')
            ->addSelect('n.estadoDerogado')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->addSelect('e.nombre as entidadNombre')
            ->addSelect('j.nombre as jurisdiccionNombre')
            ->addSelect('m.nombre as matrizNombre')
        ->leftJoin('n.grupoRel' , 'g')
        ->leftJoin('n.articuloTipoRel', 'nt')
        ->leftJoin('n.subgrupoRel', 'sg')
        ->leftJoin('n.entidadRel', 'e')
        ->leftJoin('n.jurisdiccionRel', 'j')
        ->leftJoin('n.matrizRel', 'm');

        if ($session->get('filtroArticuloCodigo') != '') {
            $queryBuilder->andWhere("n.codigoArticuloPk = '{$session->get('filtroArticuloCodigo')}'");
        }
        if ($session->get('filtroArticuloNombre') != '') {
            $queryBuilder->andWhere("n.nombre LIKE '%{$session->get('filtroArticuloNombre')}%'");
        }
        if ($session->get('filtroArticuloDescripcion') != '') {
            $queryBuilder->andWhere("n.descripcion LIKE '%{$session->get('filtroArticuloDescripcion')}%'");
        }
        switch ($session->get('estadoDerogado')) {
            case '0':
                $queryBuilder->andWhere("n.estadoDerogado = 0");
                break;
            case '1':
                $queryBuilder->andWhere("n.estadoDerogado = 1");
                break;
        }
        return $queryBuilder;
    }

    public function listaNorma($codigoNorma)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Articulo::class, 'a')
            ->select('a.codigoArticuloPk')
            ->addSelect('a.obligacion')
            ->addSelect('a.estadoDerogado')
            ->addSelect('a.verificable')
            ->addSelect('acc.nombre as accionNombre')
            ->leftJoin('a.accionRel' , 'acc')
        ->where('a.codigoNormaFk = ' . $codigoNorma);
        return $queryBuilder;
    }

}