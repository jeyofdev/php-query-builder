<?php

    use jeyofdev\Php\Query\Builder\Database\Database;


    // Autoloader
    require dirname(__DIR__) . '/vendor/autoload.php';


    // Create the database
    $database = new Database("localhost", "root", "root");
    $database->addDatabase("demo");


    // Define the table "post"
    $postTable = "CREATE TABLE IF NOT EXISTS post (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        content TEXT(650000) NOT NULL,
        created_at DATETIME NOT NULL,
        PRIMARY KEY (id)
    )
    ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";


    // Define the table "category"
    $categoryTable = "CREATE TABLE IF NOT EXISTS category (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    )
    ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";


    // Define the table "post_category"
    $joinTable = "CREATE TABLE IF NOT EXISTS post_category (
        post_id INT UNSIGNED NOT NULL,
        category_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (post_id, category_id),
        CONSTRAINT fk_post
            FOREIGN KEY (post_id)
            REFERENCES post (id)
            ON DELETE CASCADE
            ON UPDATE RESTRICT,
        CONSTRAINT fk_category
            FOREIGN KEY (category_id)
            REFERENCES category (id)
            ON DELETE CASCADE
            ON UPDATE RESTRICT
    )
    ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";


    // Define the table "sale"
    $postTable = "CREATE TABLE IF NOT EXISTS sale (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        client VARCHAR(255) NOT NULL,
        price VARCHAR(255) NOT NULL,
        sold_at DATETIME NOT NULL,
        PRIMARY KEY (id)
    )
    ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";


    // Add the tables in the database
    $database
        ->addTable($postTable)
        ->addTable($categoryTable)
        ->addTable($joinTable);