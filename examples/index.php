<?php

    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;


    // Autoloader
    require dirname(__DIR__) . '/vendor/autoload.php';


    // Initialize the query builder
    $database = new Database("localhost", "root", "root", "demo");
    $queryBuilder = new QueryBuilder($database);


    // Generate the query
    $query = $queryBuilder
    ->delete()
    ->table("post")
    ->where("id", 5, "<=")
    ->toSQL();

$results = $queryBuilder
    ->exec($query);
dump($results);