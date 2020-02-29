<?php


namespace App\Middleware;


use App\Router\Route;
use App\Service\FlashMessageService;

class FlashMessageMiddleware implements IMiddleware
{

    /**
     * @var FlashMessageService
     */
    private $flash_message_service;

    public function __construct(FlashMessageService $flash_message_service)
    {
        $this->flash_message_service = $flash_message_service;
    }

    public function run(Route $route)
    {
        $controller = $route->getController();

        $message = $this->getFlashMessageService()->getMessage();

        $controller->setSharedData('message', $message);

        $this->getFlashMessageService()->clearMessage();
    }

    /**
     * @return FlashMessageService
     */
    private function getFlashMessageService(): FlashMessageService
    {
        return $this->flash_message_service;
    }
}