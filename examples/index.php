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
        ->columns("c.*", "pc.post_id")
        ->table("post_category", "pc")
        ->join("left join", "category", "c")
        ->on("c.id", "pc.category_id")
        ->toSql();

    dump($query);