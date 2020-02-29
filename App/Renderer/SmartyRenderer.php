<?php


namespace App\Renderer;


use Smarty;

class SmartyRenderer implements IRenderer
{

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addProperty($key, $value)
    {
        $this->getSmarty()->assign($key, $value);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPropertyByRef($key, &$value)
    {
        $this->getSmarty()->assign_by_ref($key, $value);
    }

    public function render(string $template_path)
    {
        return $this->getSmarty()->fetch($template_path);
    }

    /**
     * @return Smarty
     */
    private function getSmarty(): Smarty
    {
        return $this->smarty;
    }
}