<?php

use App\Model\Folder;
use App\MySQL\ObjectDataManager;

require_once __DIR__ . '/../App/bootstrap.php';

$faker = Faker\Factory::create();
$address = new Faker\Provider\en_US\Address($faker);

/**
 * @var ObjectDataManager $odm
 */
$odm = $container->get(ObjectDataManager::class);

for ($i = 0; $i < $faker->numberBetween(10, 30); $i++) {
    $folder = new Folder();
    $folder->setName($address->city());

    /**
     * @var Folder $result
     */
    $result = $odm->save($folder);

    echo  $result->getName() . "\n";
}