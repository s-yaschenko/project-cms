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
        if (!$this->isDataSessionByKey($key)) {
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

    /**
     * @param string $key
     * @return bool
     */
    public function isDataSessionByKey(string $key)
    {
        return isset($_SESSION[$key]);
    }
}