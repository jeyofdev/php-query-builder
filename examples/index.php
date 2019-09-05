<?php

    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\QueryBuilder;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\Syntax;


    // Autoloader
    require dirname(__DIR__) . '/vendor/autoload.php';


    // Connexion to the database
    $database = new Database("localhost", "root", "root", "demo");


    // Instance of the class that handles the sql query
    $syntax = new Syntax();


    // Generate the query
    $queryBuilder = new QueryBuilder($database, $syntax);
    $query = $queryBuilder->getSyntax()
        ->select()
        ->columns("id", "category", "content")
        ->table("post")
        ->where("id", ":id", "<=")
        ->where("category", ":category", "=", "and", true)
        ->toSql();

    dd($query);
