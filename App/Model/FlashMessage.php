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


}