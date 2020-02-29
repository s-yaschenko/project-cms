<?php


namespace App\Middleware;


use App\Router\Route;

interface IMiddleware
{
    public function run(Route $route);
}