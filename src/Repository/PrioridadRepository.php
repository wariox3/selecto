<?php
/**
 * Created by PhpStorm.
 * User: avera
 * Date: 6/12/17
 * Time: 08:55 AM
 */

namespace App\Repository;


class PrioridadRepository extends \Doctrine\ORM\EntityRepository{
	public function listarPrioridades(){

		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		$qb->from("App:Prioridad", "a")
		   ->select("a.codigo_prioridad_pk")
		   ->addSelect("a.color")
		   ->addSelect("a.nombre");
		return $qb->getQuery()->getResult();
	}

}