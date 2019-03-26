<?php

namespace App\Repository;

use App\Entity\Obligacion;
use App\Utilidades\Modelo;
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

        if ($session->get('filtroObligacionMatriz') != '') {
            $queryBuilder->andWhere("m.nombre = '{$session->get('filtroObligacionMatriz')}'");
        }
        if ($session->get('filtroGrupo') != '') {
            $queryBuilder->andWhere("o.codigoGrupoFk = '{$session->get('filtroGrupo')}'");
        }
        if ($session->get('filtroObligacionSubgrupo') != '') {
            $queryBuilder->andWhere("sg.nombre = '{$session->get('filtroObligacionSubgrupo')}'");
        }
        if ($session->get('filtroObligacionAccion') != '') {
            $queryBuilder->andWhere("acc.nombre = '{$session->get('filtroObligacionAccion')}'");
        }
        if ($session->get('filtroObligacion') != '') {
            $queryBuilder->andWhere("o.obligacion LIKE '%{$session->get('filtroObligacion')}%'");
        }
        if ($session->get('filtroObligacionVerificable') != '') {
            switch ($session->get('filtroObligacionVerificable')){
                case 0:
                    $queryBuilder->andWhere('o.verificable = 0');
                    break;
                case 1:
                    $queryBuilder->andWhere('o.verificable = 1');
                    break;
            }
        }
        if ($session->get('filtroObligacionDerogado') != '') {
            switch ($session->get('filtroObligacionDerogado')){
                case 0:
                    $queryBuilder->andWhere('o.estadoDerogado = 0');
                    break;
                case 1:
                    $queryBuilder->andWhere('o.estadoDerogado = 1');
                    break;
            }
        }



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
        Modelo::eliminar(Obligacion::class, $arrVigenciasSeleccionados);

    }
}