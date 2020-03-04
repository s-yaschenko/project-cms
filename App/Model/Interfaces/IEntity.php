<?php


namespace App\Model\Interfaces;


use App\MySQL\Interfaces\ITableRow;

interface IEntity extends ITableRow, \ArrayAccess
{

}