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

        $url_path = parse_url($http_referer, PHP_URL_PATH);
        $url_query = parse_url($http_referer, PHP_URL_QUERY);

        return $url_path . '?' . $url_query;
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
     * @return string
     */
    public function getStringFromGet(string $key, $default = '')
    {
        return (string) $this->getRawFromGet($key, $default);
    }

    /**
     * @param string $key
     * @param int $default
     * @return float
     */
    public function getFloatFromPost(string $key, $default = 0)
    {
        return (float) $this->getRawFromPost($key, $default);
    }

    /**
     * @param string $key
     * @param array $default
     * @return array
     */
    public function getArrayFromPost(string $key, $default = [])
    {
        return (array) $this->getRawFromPost($key, $default);
    }

    /**
     * @param string $key
     * @param int $default
     * @return int
     */
    public function getIntFromPost(string $key, $default = 0)
    {
        return (int) $this->getRawFromPost($key, $default);
    }

    /**
     * @param string $key
     * @param int $default
     * @return int
     */
    public function getIntFromGet(string $key, $default = 0) {
        return (int) $this->getRawFromGet($key, $default);
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

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    private function getRawFromGet(string $key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    private function parseUrl()
    {
        $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;

        if (!is_null($request_uri)) {
            $request_data = explode('?', $request_uri);
            $this->url = $request_data[0];
        }
    }
}