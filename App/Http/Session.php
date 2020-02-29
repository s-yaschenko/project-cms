<?php


namespace App\Http;


class Session
{

    /**
     * @return array
     */
    public function getSession(): array
    {
        return $_SESSION;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setSessionByKey(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getDataSessionByKey(string $key)
    {
        if (!isset($_SESSION[$key])) {
            return null;
        }
        return $_SESSION[$key];
    }

    /**
     * @param string $key
     */
    public function unsetDataSessionByKey(string $key)
    {
        unset($_SESSION[$key]);
    }
}