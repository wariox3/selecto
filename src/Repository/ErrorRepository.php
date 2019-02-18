<?php

namespace App\Repository;

use App\Entity\Error;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Error|null find($id, $lockMode = null, $lockVersion = null)
 * @method Error|null findOneBy(array $criteria, array $orderBy = null)
 * @method Error[]    findAll()
 * @method Error[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErrorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Error::class);
    }

    public function listaUnoApi($codigo)
    {
        return $this->createQueryBuilder('e')
            ->where('e.codigoErrorPk = :value')->setParameter('value', $codigo)
            ->getQuery()
            ->getSingleResult();
    }

    public function filtroErrores($cliente = "", $estadoAntendido = "", $estadoSolucionado = "")
    {
        $qb = $this->createQueryBuilder("e")
            ->select("e.codigoErrorPk as id")
            ->addSelect("e.codigo")
            ->addSelect("e.cliente")
            ->addSelect("e.mensaje")
            ->addSelect("e.linea")
            ->addSelect("e.archivo")
            ->addSelect("e.url")
            ->addSelect("e.estadoAtendido")
            ->addSelect("e.estadoSolucionado")
            ->addSelect("e.fecha");

        if($cliente != "") {
            $qb->where("e.codigoClienteFk = '{$cliente}'");
        }
        if($estadoAntendido != "") {
            $qb->andWhere("e.estadoAtendido = {$estadoAntendido}");
        }
        if($estadoSolucionado != "") {
            $qb->andWhere("e.estadoSolucionado = {$estadoSolucionado}");
        }
        return $qb->orderBy("e.fecha", 'DESC')
            ->getDQL();
    }

    /**
     * Esta funcion permite listar y filtrar todos los errores.
     * @param int $pagina
     * @param null $cliente
     * @param null $fecha
     * @param int $atendido
     * @param int $solucionado
     * @param int $limite
     * @return array|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function listaApi($pagina = 1, $cliente = null, $fecha = null, $atendido = 0, $solucionado = 0, $limite = 10)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from('App:Error', "e")
            ->select("COUNT(e.codigoErrorPk)");

        if(!empty($cliente) && $cliente != "none") {
            $qb->where("e.codigoClienteFk = {$cliente}");
        }

        if(!empty($fecha) && $fecha != "none") {
            $qb->andWhere("e.fecha LIKE '%{$fecha}%'");
        }

        if($atendido != 0) {
            $qb->andWhere("e.estadoAtendido = {$atendido}");
        }

        if($solucionado != 0) {
            $qb->andWhere("e.estadoSolucionado = {$solucionado}");
        }



        $total = $qb->getQuery()->getSingleScalarResult();

        if ($total > 0) {
            $qb->select("e.codigoErrorPk")
                ->addSelect("e.cliente as nombreCliente")
                ->addSelect("e.mensaje")
                ->addSelect("e.codigo")
                ->addSelect("e.ruta")
                ->addSelect("e.archivo")
                ->addSelect("e.traza")
                ->addSelect("e.fecha")
                ->addSelect("e.url")
                ->addSelect("e.usuario")
                ->addSelect("e.nombreUsuario")
                ->addSelect("e.email")
                ->addSelect("e.estadoAtendido")
                ->addSelect("e.estadoSolucionado")
                ->addSelect("e.codigoClienteFk")
                ->orderBy('e.codigoErrorPk', 'DESC')
                ->setFirstResult(($pagina - 1) * $limite)
                ->setMaxResults($limite);
            $registros = $qb->getQuery()->getResult();
            $totalPaginas = intval(ceil($total / $limite));
            $sig = intval($pagina + 1);
            $ant = intval($pagina - 1);
            return [
                'paginacion' => [
                    'total' => $total,
                    'paginas' => intval($totalPaginas),
                    'sig_pagina' => $sig > $totalPaginas? 1 : $sig,
                    'ant_pagina' => $ant <= 0? $totalPaginas : $ant,
                ],
                'registros' => $registros
            ];
        }
        return null;
    }

    public function tableroSinAtender() {
        $em = $this->getEntityManager();
        $arrSinAtender = array('numero' => 0, 'arrErrores' => array());
        $dql = "SELECT COUNT(e.codigoErrorPk) as numero FROM App:Error e "
            . "WHERE e.estadoAtendido = 0 ";
        $query = $em->createQuery($dql);
        $arrayResultado = $query->getResult();
        if ($arrayResultado) {
            $arrSinAtender['numero'] = $arrayResultado[0]['numero'];
        }
        $dql = "SELECT e.codigoErrorPk, e.fecha, cli.nombreComercial  FROM App:Error e JOIN e.clienteRel cli "
            . "WHERE e.estadoAtendido = 0 ORDER BY e.fecha";
        $query = $em->createQuery($dql);
        $query->setMaxResults(10);
        $arrayResultado = $query->getResult();
        if ($arrayResultado) {
            $arrSinAtender['arrErrores'] = $arrayResultado;
        }
        return $arrSinAtender;
    }

}
