<?php
require_once '../vendor/autoload.php';
$mongo = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongo->test;
$collections = $database->listCollections();
$exists = false;
foreach ($collections as $collection) {
    if ($collection->getName() == "users") {
        $exists = true;
        break;
    }
}

if (!$exists) {
    $database->createCollection("users");
}

$collection = $database->users;
return $collection;


?>
