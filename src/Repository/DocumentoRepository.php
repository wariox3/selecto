<?php

namespace App\Repository;

use App\Entity\Documento;
use App\Entity\Item;
use App\Entity\Movimiento;
use App\Entity\MovimientoDetalle;
use App\Utilidades\Mensajes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class DocumentoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Documento::class);
    }
}