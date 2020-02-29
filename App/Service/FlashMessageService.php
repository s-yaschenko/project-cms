<?php


namespace App\Service;


use App\Model\FlashMessage;

class FlashMessageService
{
    /**
     * @var FlashMessage
     */
    private $flash_message;

    /**
     * @param string $key
     * @param string $message
     */
    public function message(string $key, string $message)
    {
        $flash_message = new FlashMessage();
        $flash_message->setMessage($key, $message);
        $this->flash_message = $flash_message;
    }

}