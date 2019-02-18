<?php
/**
 * Created by PhpStorm.
 * User: avera
 * Date: 5/12/17
 * Time: 08:20 AM
 */

namespace App\Repository;


class CasoCategoriaRepository extends \Doctrine\ORM\EntityRepository
{

	public function listarCategorias(){

		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		$qb->from("App:CasoCategoria", "a")
		   ->select("a.codigoCategoriaCasoPk")
		   ->addSelect("a.descripcion")
		   ->addSelect("a.color");
		return $qb->getQuery()->getResult();
	}

}