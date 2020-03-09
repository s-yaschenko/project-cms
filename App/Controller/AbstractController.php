<?php


namespace App\Controller;


use App\Http\Request;
use App\Http\Response;
use App\Http\ResponseBody\JSONBody;
use App\Http\ResponseBody\TextBody;
use App\Http\Session;
use App\Renderer\IRenderer;
use App\Router\Route;
use App\Service\FlashMessageService;
use App\Service\UserService;

/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{

    /**
     * @var IRenderer
     */
    private $renderer;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Route
     */
    private $route;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var FlashMessageService
     */
    private $flash_message_service;

    /**
     * @var array
     */
    protected $shared_data = [];

    /**
     * AbstractController constructor.
     * @param IRenderer $renderer
     * @param Request $request
     * @param Response $response
     * @param Session $session
     * @param FlashMessageService $flash_message_service
     */
    public function __construct(IRenderer $renderer, Request $request,Response $response, Session $session, FlashMessageService $flash_message_service)
    {
        $this->renderer = $renderer;
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->flash_message_service = $flash_message_service;
    }

    /**
     * @param Route $route
     */
    public function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setSharedData(string $key, $value)
    {
        $this->shared_data[$key] = $value;
    }

    /**
     * @param string $template_name
     * @param array $params
     * @return Response
     */
    protected function render(string $template_name, array $params): Response
    {
        $this->setProperty($this->getSharedData());
        $this->setProperty($params);

        $body = new TextBody($this->getRenderer()->render($template_name));
        $this->getResponse()->setBody($body);

        return $this->response;
    }

    /**
     * @param array $params
     * @return Response
     */
    protected function json(array $params): Response
    {
        $body = new JSONBody($params);
        $this->getResponse()->setBody($body);

        $this->getResponse()->setHeader('Content-type', 'application/json');

        return $this->response;
    }


    /**
     * @param UserService $user_service
     * @param string $info_message
     * @return Response|bool
     */
    protected function checkUserAccess(UserService $user_service, string $info_message = null)
    {
        $user = $user_service->getCurrentUser();

        if (!$user->getId()) {
            if ($info_message) {
                $this->getFlashMessageService()->message('info', $info_message);
            }
            return $this->redirect($this->getRequest()->getRefererUrl());
        }

        return true;
    }

    /**
     * @param string $url
     * @return Response
     */
    protected function redirect(string $url): Response
    {
        $this->getResponse()->redirect($url);

        return $this->response;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return FlashMessageService
     */
    protected function getFlashMessageService(): FlashMessageService
    {
        return $this->flash_message_service;
    }

    /**
     * @return Route
     */
    protected function getRoute()
    {
        return $this->route;
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->session;
    }

    /**
     * @param array $property
     */
    private function setProperty(array $property)
    {
        foreach ($property as $key => &$value) {
            if (is_scalar($value)) {
                $this->getRenderer()->addProperty($key, $value);
            } else {
                $this->getRenderer()->addPropertyByRef($key, $value);
            }
        }
    }

    /**
     * @return array
     */
    private function getSharedData(): array
    {
        return $this->shared_data;
    }

    /**
     * @return IRenderer
     */
    private function getRenderer(): IRenderer
    {
        return $this->renderer;
    }

    /**
     * @return Response
     */
    private function getResponse(): Response
    {
        return $this->response;
    }
}