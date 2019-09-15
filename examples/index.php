<?php

    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Builder\Builder;
    use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\Syntax;


    // Autoloader
    require dirname(__DIR__) . '/vendor/autoload.php';


    // Connexion to the database
    $database = new Database("localhost", "root", "root", "demo");


    // Instance that we need
    $syntax = new Syntax();
    $builder = new Builder($database->getConnection("demo"));
    $queryBuilder = new QueryBuilder($database, $syntax, $builder);


    // Generate the query
    $query = $queryBuilder->getSyntax()
        ->select()
        ->table(" post")
        ->where("id", [5, 10], "BETWEEN")
        ->toSql();

    $results = $builder
        ->query($query)
        ->fetchAll();

    dump($results);