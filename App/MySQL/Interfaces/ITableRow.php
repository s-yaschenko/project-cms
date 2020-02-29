<?php


namespace App\MySQL\Interfaces;


interface ITableRow
{
    public function getTableName(): string;

    public function getPrimaryKey(): string;

    public function getPrimaryKeyValue(): ?string;

    public function getColumnValue(string $key): ?string;

    public function getColumnsForUpdate(): array;

    public function getColumnsForInsert(): array;
}