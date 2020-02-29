<?php


namespace App\Http;


use App\Http\ResponseBody\AbstractBody;

class Response
{

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var AbstractBody
     */
    private $body;

    public function send()
    {
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo (string) $this->body;
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        $this->setHeader('Location', $url);
    }

    /**
     * @param AbstractBody $body
     */
    public function setBody(AbstractBody $body)
    {
        $this->body = $body;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function setHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }
}