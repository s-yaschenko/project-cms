<?php

use App\Model\Product;
use App\MySQL\ObjectDataManager;

require_once __DIR__ . '/../App/bootstrap.php';

$faker = Faker\Factory::create();
$person = new Faker\Provider\en_US\Person($faker);
/**
 * @var ObjectDataManager $odm
 */
$odm = $container->get(ObjectDataManager::class);
$product_repository = $container->get(\App\Repository\ProductRepository::class);

for ($i = 0; $i < $faker->numberBetween(100, 200); $i++) {
    $product = new Product();

    $product->setName($person->name());
    $product->setAmount($faker->numberBetween(0, 90));
    $product->setPrice($faker->randomFloat(2, 9, 100));
    $product->setDescription($faker->realText());


    $vendor = getRandomVendor($odm);
    $product->setVendorId($vendor->getId());

    for ($i2 = 0; $i2 < $faker->numberBetween(1, 5); $i2++) {
        $folder = getRandomFolder($odm);
        $product->addFolderId($folder->getId());
    }

    /**
     * @var \App\Repository\ProductRepository $product_repository
     */
    $product_repository->save($product);

    echo $product->getName();
    echo "\n";

};

function getRandomVendor(ObjectDataManager $odm) {
    $query = "SELECT * FROM vendors ORDER BY RAND() LIMIT 1";
    return $odm->fetchRow($query, \App\Model\Vendor::class);
}

function getRandomFolder(ObjectDataManager $odm) {
    $query = "SELECT * FROM folders ORDER BY RAND() LIMIT 1";
    return $odm->fetchRow($query, \App\Model\Folder::class);
}