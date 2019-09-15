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
        ->table(" post")
        ->columns([
            "name" => ":name",
            "slug" => ":slug",
            "content" => ":content"
        ])
        ->toSql();


    $pdo = $database->getConnection("demo");
    $builder = new Builder($pdo);

    $results = $builder
        ->prepare($query)
        ->execute([
            "name" => "lorem ipsum",
            "slug" => "lorem-ipsum",
            "content" => "Exercitationem veniam laboriosam dicta eius eos. V..."
        ])
        ->lastInsertId();

    dump($results);
    dump($builder->quote("test"));
