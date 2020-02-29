<?php


namespace App\MySQL\Interfaces;


interface IConnection
{
    public function __construct(string $host, string $database, string $user_name, string $user_password);

    public function getConnect();
}