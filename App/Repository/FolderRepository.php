<?php


namespace App\Repository;


use App\Model\Folder;

/**
 * Class FolderRepository
 * @package App\Repository
 *
 * @method Folder[] findAll()
 */
class FolderRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $model = Folder::class;
}