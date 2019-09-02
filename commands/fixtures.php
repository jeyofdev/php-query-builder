<?php

    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\Fixtures\Fixtures;

    
    // Autoloader
    require dirname(__DIR__) . '/vendor/autoload.php';


    // Clear the datas in the tables of the database
    $database = new Database("localhost", "root", "root", "demo");
    $database->getDatabase();

    $database
        ->clear($database->getTableName("post"))
        ->clear($database->getTableName("category"))
        ->clear($database->getTableName("post_category"));


    
    // Add fake datas in the tables of the database
    $fixtures = new Fixtures($database);
    $fixtures->add("fr_FR", "post", "category", "post_category");