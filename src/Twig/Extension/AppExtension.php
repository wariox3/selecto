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
            new TwigFunction('encriptar', [$this, 'encriptar']),
            new TwigFunction('notificar', [$this, 'getNotifies']),

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

    /**
     * Esta función se encarga de imprimir las notificaciones para usuario (Mensajes).
     * @return string
     */
    public function getNotifies()
    {
        $session = new Session();
        $flashes = $session->getFlashBag()->all();
        $html = [];
        foreach ($flashes as $type => $messages) {
            foreach ($messages AS $message) {
                $span = $this->createTag("span", "&times;", ['aria-hidden' => 'true']);
                $button = $this->createTag("button", $span, ['class' => 'close', 'data-dismiss' => 'alert', 'aria-label' => 'Close']);
                $alert = $this->createTag("div", $button . $message, ['class' => "alert alert-{$type}", 'data', 'style' => 'margin-top:5px;margin-bottom:5px;']);
                $html[] = $alert;
            }
        }
        $session->getFlashBag()->clear();
        return implode('', $html);
    }


    /**
     * Esta función nos permite obtener código html sin violar estandares de mezcla de código.
     * @param $tag
     * @param string $content
     * @param array $attrs
     * @return string
     */
    private function createTag($tag, $content = '', $attrs = [])
    {
        $attrs = implode(" ", array_map(function ($attr, $value) {
            return "{$attr}=\"{$value}\"";
        }, array_keys($attrs), $attrs));
        return "<{$tag}" . ($attrs ? " {$attrs}" : "") . ">{$content}</{$tag}>";
    }

    public function encriptar($dato)
    {
        return str_replace('/', '&', password_hash($dato, PASSWORD_BCRYPT));
    }



}