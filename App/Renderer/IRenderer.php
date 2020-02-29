<?php


namespace App\Renderer;


interface IRenderer
{
    public function addProperty($key, $value);

    public function addPropertyByRef($key, &$value);

    public function render(string $template_path);
}