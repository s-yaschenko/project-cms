<?php

use App\Model\Vendor;
use App\MySQL\ObjectDataManager;

require_once __DIR__ . '/../App/bootstrap.php';

$faker = Faker\Factory::create();
$company = new Faker\Provider\en_US\Company($faker);

/**
 * @var ObjectDataManager $odm
 */
$odm = $container->get(ObjectDataManager::class);

for ($i = 0; $i < $faker->numberBetween(10, 30); $i++) {
    $vendor = new Vendor();
    $vendor->setName($company->company());

    $result = $odm->save($vendor);

    echo  $result->getName() . "\n";
}