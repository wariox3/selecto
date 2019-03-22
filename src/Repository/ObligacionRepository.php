<?php

namespace App\Repository;

use App\Entity\Obligacion;
use App\Utilidades\AyudaEliminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class ObligacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Obligacion::class);
    }

    public function lista()
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Obligacion::class, 'n')
            ->select('n.codigoObligacionPk')
            ->addSelect('n.codigoObligacionTipoFk')
            ->addSelect('n.numero')
            ->addSelect('n.nombre')
            ->addSelect('n.descripcion')
            ->addSelect('n.codigoGrupoFk')
            ->addSelect('n.codigoSubgrupoFk')
            ->addSelect('n.codigoEntidadFk')
            ->addSelect('n.codigoJurisdiccionFk')
            ->addSelect('n.codigoMatrizFk')
            ->addSelect('nt.nombre as obligacionTipoNombre')
            ->addSelect('n.estadoDerogado')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->addSelect('e.nombre as entidadNombre')
            ->addSelect('j.nombre as jurisdiccionNombre')
            ->addSelect('m.nombre as matrizNombre')
        ->leftJoin('n.grupoRel' , 'g')
        ->leftJoin('n.obligacionTipoRel', 'nt')
        ->leftJoin('n.subgrupoRel', 'sg')
        ->leftJoin('n.entidadRel', 'e')
        ->leftJoin('n.jurisdiccionRel', 'j')
        ->leftJoin('n.matrizRel', 'm');

        if ($session->get('filtroObligacionCodigo') != '') {
            $queryBuilder->andWhere("n.codigoObligacionPk = '{$session->get('filtroObligacionCodigo')}'");
        }
        if ($session->get('filtroObligacionNombre') != '') {
            $queryBuilder->andWhere("n.nombre LIKE '%{$session->get('filtroObligacionNombre')}%'");
        }
        if ($session->get('filtroObligacionDescripcion') != '') {
            $queryBuilder->andWhere("n.descripcion LIKE '%{$session->get('filtroObligacionDescripcion')}%'");
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
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Obligacion::class, 'o')
            ->select('o.codigoObligacionPk')
            ->addSelect('o.obligacion')
            ->addSelect('o.estadoDerogado')
            ->addSelect('o.verificable')
            ->addSelect('acc.nombre as accionNombre')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->addSelect('m.nombre as matrizNombre')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('o.accionRel' , 'acc')
            ->leftJoin('o.subgrupoRel' , 'sg')
            ->leftJoin('o.matrizRel' , 'm')
            ->leftJoin('o.grupoRel' , 'g')
        ->where('o.codigoNormaFk = ' . $codigoNorma);
        return $queryBuilder;
    }

    public function listaMatriz($codigoMatriz)
    {
        $session = new Session();
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Obligacion::class, 'o')
            ->select('o.codigoObligacionPk')
            ->addSelect('o.obligacion')
            ->addSelect('o.estadoDerogado')
            ->addSelect('o.verificable')
            ->addSelect('o.codigoNormaFk')
            ->addSelect('acc.nombre as accionNombre')
            ->addSelect('sg.nombre as subgrupoNombre')
            ->addSelect('m.nombre as matrizNombre')
            ->addSelect('g.nombre as grupoNombre')
            ->leftJoin('o.accionRel' , 'acc')
            ->leftJoin('o.subgrupoRel' , 'sg')
            ->leftJoin('o.matrizRel' , 'm')
            ->leftJoin('o.grupoRel' , 'g')
            ->where('o.codigoMatrizFk = ' . $codigoMatriz);
        return $queryBuilder;
    }

    public function Eliminar($arrVigenciasSeleccionados)
    {
        AyudaEliminar::eliminar(Obligacion::class, $arrVigenciasSeleccionados);

    }
}