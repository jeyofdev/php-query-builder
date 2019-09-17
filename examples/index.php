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
        ->select()
        ->table("sale")
        ->toSQL();
    dump($query);


    $results = $queryBuilder
        ->query($query)
        ->fetchAll("FETCH_OBJ");
    dump($results);