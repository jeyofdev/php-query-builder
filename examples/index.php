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

    $builder->setAttribute([
        "DEFAULT_FETCH_MODE" => PDO::FETCH_OBJ,
        "ERRMODE" => PDO::ERRMODE_EXCEPTION,
        "CASE" => PDO::CASE_LOWER
    ]);

    dump($builder->getAttribute("DEFAULT_FETCH_MODE"));
    dump($builder->getAttribute("ERRMODE"));

    // Generate the query
    $query = $queryBuilder->getSyntax()
        ->select()
        ->table("post")
        ->where("id", 5, ">")
        ->toSql();

    $results = $builder
        ->query($query)
        ->fetchAll();
    dump($results);