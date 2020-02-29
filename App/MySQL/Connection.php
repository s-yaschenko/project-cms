<?php


namespace App\MySQL;


use App\MySQL\Exceptions\ConnectionException;
use App\MySQL\Interfaces\IConnection;

class Connection implements IConnection
{

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $user_name;

    /**
     * @var string
     */
    private $user_password;

    /**
     * @var resource
     */
    private $connection;

    public function __construct(string $host, string $database, string $user_name, string $user_password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->user_name = $user_name;
        $this->user_password = $user_password;
    }

    /**
     * @return resource
     * @throws ConnectionException
     */
    public function getConnect()
    {
        if (is_null($this->connection)) {
            $this->connect();
        }

        return $this->connection;
    }

    /**
     * @throws ConnectionException
     */
    private function connect()
    {
        $this->connection = mysqli_connect($this->getHost(), $this->getUserName(), $this->getUserPassword(), $this->getDatabase());

        $mysql_errno = mysqli_connect_errno();
        if ($mysql_errno > 0) {
            $mysql_error = mysqli_connect_error();
            $message = "MySQL connect error: ($mysql_errno) $mysql_error";

            throw new ConnectionException($message);
        }
        mysqli_set_charset($this->connection, 'utf8');
    }

    /**
     * @return string
     */
    private function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    private function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    private function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @return string
     */
    private function getUserPassword(): string
    {
        return $this->user_password;
    }
}