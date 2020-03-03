<?php


namespace App\Http;


class Request
{

    /**
     * @var string
     */
    private $url;

    public function __construct()
    {
        $this->parseUrl();
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getRefererUrl(): string
    {
        $http_referer = $_SERVER['HTTP_REFERER'];

        return parse_url($http_referer, PHP_URL_PATH);
    }

    /**
     * @return bool
     */
    public function isPostData(): bool
    {
        return !empty($_POST);
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getStringFromPost(string $key, $default = '')
    {
        return (string) $this->getRawFromPost($key, $default);
    }

    /**
     * @param string $key
     * @param string $default
     * @return int
     */
    public function getIntFromPost(string $key, $default = '')
    {
        return (int) $this->getRawFromPost($key, $default);
    }

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    private function getRawFromPost(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    private function parseUrl()
    {
        $request_uri = $_SERVER['REQUEST_URI'];

        $request_data = explode('?', $request_uri);
        $this->url = $request_data[0];
    }
}