<?php


namespace App\Model;


class FlashMessage
{
    /**
     * @var array
     */
    private $message = [];

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function setMessage(string $key, string $message)
    {
        $this->message[$key] = $message;
    }

}