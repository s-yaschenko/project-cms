<?php


namespace App\Repository;


use App\Model\Folder;

/**
 * Class FolderRepository
 * @package App\Repository
 *
 * @method Folder find(int $id)
 * @method Folder[] findAll()
 * @method Folder createNewEntity()
 */
class FolderRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $model = Folder::class;
}