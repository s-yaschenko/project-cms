<?php


namespace App\Repository;


use App\Model\Vendor;

/**
 * Class VendorRepository
 * @package App\Repository
 *
 * @method Vendor find(int $id)
 * @method Vendor[] findAll()
 * @method Vendor createNewEntity()
 */
class VendorRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected $model = Vendor::class;
}