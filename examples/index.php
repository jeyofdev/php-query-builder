<?php

    use jeyofdev\Php\Query\Builder\Database\Database;
use jeyofdev\Php\Query\Builder\QueryBuilder\Builder\Builder;
use jeyofdev\Php\Query\Builder\QueryBuilder\Builder\Statement;
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
        ->table("post")
        ->where("id", ":id", ">")
        ->toSql();


    $pdo = $database->getConnection("demo");
    $builder = new Builder($pdo);

    $results = $builder
        ->prepare($query)
        ->execute(["id" => 5])
        ->fetchAll(PDO::FETCH_OBJ);

    dump($results);