<?php
/*
 © Copyright 2024 tuyck.com
 * by Alireza Nazari
 * email alireza.ginbox@gmail.com
 * version 1
 * last update 17-02-2024
*/

require './vendor/autoload.php';
dump("MongoDB connection ". (extension_loaded("mongodb") ? "loaded\n" : "not loaded\n") );
// connect to mongodb you can replace the root user and toor password with your credential
$m = new MongoDB\Client('mongodb://root:toor@127.0.0.1:27017', [
    'directConnection' => true,
    'serverSelectionTimeoutMS' => 2000
]);
if ($m) dump("Connection to database successfully");
else dump("Can not make Connection to database");
// select a database Demo (you need create required database before using it in here )
$db = $m->Demo;
if ($db) dump( "Database Demo selected");

// select a collection from our Demo database (you may change the DemoCollection your collection)
$collection = $db->DemoCollection;
if ($collection) dump("Collection selected succsessfully");

// make fake random data
$document = array(
    "title" => Faker\Factory::create()->city,
    "description" => Faker\Factory::create()->paragraph,
    "likes" => Faker\Factory::create()->numberBetween(1,1000000),
    "url" => Faker\Factory::create()->url,
    "by" => Faker\Factory::create()->name
);

// inset the fake data to the selected collection
$insertOneResult = $collection->insertOne($document);
if ($insertOneResult){
    dump($insertOneResult->getInsertedId() ." Document inserted successfully");
}

// search the selected collection for data for example "db.DemoCollection.find() or in sql select * form DemoCollection"
$cursor = $collection->find();
// iterate cursor to display title of documents
foreach ($cursor as $document) {
    dump($document->title);
}
