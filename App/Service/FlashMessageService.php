<?php


namespace App\Service;


use App\Http\Session;
use App\Model\FlashMessage;

class FlashMessageService
{
    /**
     * @var string
     */
    private $session_key = 'flash';

    /**
     * @var FlashMessage
     */
    private $flash_message;

    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function message(string $key, string $message)
    {
        $flash_message = new FlashMessage();
        $flash_message->setMessage($key, $message);
        $this->getSession()->setSessionByKey($this->getSessionKey(), $flash_message);
        //$this->flash_message = $flash_message;
    }

    /**
     * @return mixed|null
     */
    public function getMessage()
    {
        return $this->getSession()->getDataSessionByKey($this->getSessionKey());
    }

    public function clearMessage()
    {
        $this->getSession()->unsetDataSessionByKey($this->getSessionKey());
    }

    /**
     * @return Session
     */
    private function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->session_key;
    }
}