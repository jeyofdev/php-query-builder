<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use PDO;
    use PDOStatement;


    /**
     * Manage the execution and get of the results of the SQL query
     */
    class Builder
    {
        /**
         * @var PDO
         */
        private static $pdo;


        /**
         * @var Fetch
         */
        private static $fetch;



        /**
         * @var Execute
         */
        private static $execute;



        /**
         * @var Attribute
         */
        private static $attribute;



        /**
         * The sql query
         *
         * @var string
         */
        private static $query;



        /**
         * Represents the executed sql query
         *
         * @var PDOStatement
         */
        private static $statement;
    


        /**
         * The result(s) of the sql query
         *
         * @var mixed
         */
        private static $results;



        /**
         * Set the value of an attribute
         *
         * @param  array  $attributes
         * @return void
         */
        public static function setAttribute (array $attributes = []) : void
        {
            self::$attribute = new Attribute(self::$pdo);
            self::$attribute->setAttribute($attributes);
        }



        /**
         * Get the value of an attribute
         *
         * @param  string  $attribute
         * @return int
         */
        public static function getAttribute (string $attribute) : int
        {
            self::$attribute = new Attribute(self::$pdo);
            return self::$attribute->getAttribute($attribute);
        }



        /**
         * Executes an SQL statement with the PDO::query method
         *
         * @param  string  $query  The sql query
         * @return void
         */
        public static function query (string $query) : void
        {
            self::$query = $query;
            self::$statement = self::$pdo->query(self::$query);
        }



        /**
         * Executes an SQL statement with the PDO::prepare method
         *
         * @param  string  $query  The sql query
         * @return void
         */
        public static function prepare (string $query) : void
        {
            self::$query = $query;
            self::$statement = self::$pdo->prepare(self::$query);
        }



        /**
         * Execute an SQL statement and return the number of affected rows
         *
         * @param  string  $query
         * @return integer
         */
        public static function exec (string $query) : int
        {
            self::$query = $query;
            self::$statement = self::$pdo->exec(self::$query);

            return self::$statement;
        }



        /**
         * Executes a prepared statement
         *
         * @param  array  $params  The values ​​of the sql query parameters
         * @return void
         */
        public static function execute (array $params = []) : void
        {
            self::$execute = new Execute(self::$statement);
            self::$execute->execute($params);
        }



        /**
         * Get the result of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return mixed
         */
        public static function fetch (string $fetchMode = "FETCH_BOTH")
        {
            self::$fetch = new Fetch(self::$statement);
            self::$results = self::$fetch->getResults($fetchMode, true);

            return self::$results;
        }



        /**
         * Get all the results of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return array
         */
        public static function fetchAll (string $fetchMode = "FETCH_BOTH") : array
        {
            self::$fetch = new Fetch(self::$statement);
            self::$results = self::$fetch->getResults($fetchMode, false);

            return self::$results;
        }



        /**
         * Get the id of the last record
         *
         * @return integer
         */
        public static function lastInsertId () : int
        {
            return (int)self::$pdo->lastInsertId();
        }



        /**
         * Quotes a string for use in a query
         *
         * @param string $string
         * @return string
         */
        public static function quote (string $string) : string
        {
            return self::$pdo->quote($string);
        }



        /**
         * Returns the number of rows affected by the SQL statement
         *
         * @return integer
         */
        public static function rowCount () : int
        {
            return self::$statement->rowCount();
        }



        /**
         * Définir la connexion PDO dans la propriété pdo
         *
         * @param PDO $pdo
         * @return void
         */
        public static function setPdo (PDO $pdo) : void
        {
            self::$pdo = $pdo;
        }
    }