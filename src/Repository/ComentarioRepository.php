<?php

namespace App\Repository;


class ComentarioRepository extends \Doctrine\ORM\EntityRepository
{
    public function apiLista($codigoCaso, $codigoSolicitud)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from("App:Comentario", "c")
            ->select("c.codigoComentarioPk")
            ->addSelect("c.fechaRegistro")
            ->addSelect("c.comentario")
            ->addSelect("c.codigoUsuarioFk")
            ->addSelect("c.cliente");
        if ($codigoCaso != 0) {
            $qb->where("c.codigoCasoFk = {$codigoCaso}");
        }
        if ($codigoSolicitud != 0) {
            $qb->where("c.codigoSolicitudFk = {$codigoSolicitud}");
        }
        return $qb->getQuery()->getResult();
    }
}
