<?php
namespace App\Twig\Extension;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class AppExtension extends AbstractExtension
{
    private $em;

    public function __construct()
    {
        global $kernel;
        $this->em = $kernel->getContainer()->get("doctrine.orm.entity_manager");
    }


    public function getFilters()
    {
        return [];
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('calcularTiempo', [$this, "getCalcularTiempo"]),

        ];
    }


    public function getCalcularTiempo($codigoTarea){
        $dql = $this->em->createQueryBuilder()->from("App:TareaTiempo", "tt")
            ->select("SUM(tt.minutos) as Total")
            ->where("tt.codigoTareaFk = {$codigoTarea}")
            ->setMaxResults(1);
        $Tiempo = $dql->getQuery()->getOneOrNullResult();
        $result = 0;
        if ($Tiempo["Total"] != null){
            $result = $Tiempo["Total"];
        }
        return $result;
    }


}