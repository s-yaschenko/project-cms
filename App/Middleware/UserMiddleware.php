<?php


namespace App\Middleware;


use App\Router\Route;
use App\Service\UserService;

class UserMiddleware implements IMiddleware
{

    /**
     * @var UserService
     */
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * @param Route $route
     */
    public function run(Route $route)
    {
        $controller = $route->getController();

        $user = $this->getUserService()->getCurrentUser();

        $controller->setSharedData('user', $user);
    }

    /**
     * @return UserService
     */
    private function getUserService(): UserService
    {
        return $this->user_service;
    }
}