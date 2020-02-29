<?php


namespace App\Router;

use App\Http\Request;
use Exception;

class Router
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Router constructor.
     * @param Request $request
     * @param Dispatcher $dispatcher
     */
    public function __construct(Request $request, Dispatcher $dispatcher)
    {
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return Route
     * @throws Exception
     */
    public function dispatch(): Route
    {
        $url = $this->getRequest()->getUrl();

        $route = $this->getDispatcher()->getRoute($url);

        if (is_null($route)) {
            $this->notFound();
        }

        return $route;
    }

    /**
     * @return Dispatcher
     */
    private function getDispatcher(): Dispatcher
    {
        return $this->dispatcher;
    }

    /**
     * @return Request
     */
    private function getRequest(): Request
    {
        return $this->request;
    }


    private function notFound()
    {
        die('404');
    }
}