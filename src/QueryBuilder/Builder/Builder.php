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
        private $pdo;


        /**
         * @var Fetch
         */
        private $fetch;



        /**
         * @var Execute
         */
        private $execute;



        /**
         * @var Attribute
         */
        private $attribute;



        /**
         * The sql query
         *
         * @var string
         */
        private $query;



        /**
         * Represents the executed sql query
         *
         * @var PDOStatement
         */
        private $statement;
    


        /**
         * The result(s) of the sql query
         *
         * @var mixed
         */
        private $results;



        /**
         * @param PDO $pdo The connection to the database
         */
        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }



        /**
         * Set the value of an attribute
         *
         * @param  array  $attributes
         * @return self
         */
        public function setAttribute (array $attributes = []) : self
        {
            $this->attribute = new Attribute($this->pdo);
            $this->attribute->setAttribute($attributes);

            return $this;
        }


        /**
         * Get the value of an attribute
         *
         * @param  string  $attribute
         * @return int
         */
        public function getAttribute (string $attribute) : int
        {
            $this->attribute = new Attribute($this->pdo);
            return $this->attribute->getAttribute($attribute);
        }



        /**
         * Executes an SQL statement with the PDO::query method
         *
         * @param  string  $query  The sql query
         * @return self
         */
        public function query (string $query) : self
        {
            $this->query = $query;
            $this->statement = $this->pdo->query($this->query);

            return $this;
        }



        /**
         * Executes an SQL statement with the PDO::prepare method
         *
         * @param  string  $query  The sql query
         * @return self
         */
        public function prepare (string $query) : self
        {
            $this->query = $query;
            $this->statement = $this->pdo->prepare($this->query);

            return $this;
        }



        /**
         * Execute an SQL statement and return the number of affected rows
         *
         * @param  string  $query
         * @return integer
         */
        public function exec (string $query) : int
        {
            $this->query = $query;
            $this->statement = $this->pdo->exec($this->query);

            return $this->statement;
        }



        /**
         * Executes a prepared statement
         *
         * @param  array  $params  The values ​​of the sql query parameters
         * @return self
         */
        public function execute (array $params = []) : self
        {
            $this->execute = new Execute($this->statement);
            $this->execute->execute($params);

            return $this;
        }



        /**
         * Get the result of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return mixed
         */
        public function fetch (string $fetchMode = "FETCH_BOTH")
        {
            $this->fetch = new Fetch($this->statement);
            $this->results = $this->fetch->getResults($fetchMode, true);

            return $this->results;
        }



        /**
         * Get all the results of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return mixed
         */
        public function fetchAll (string $fetchMode = "FETCH_BOTH")
        {
            $this->fetch = new Fetch($this->statement);
            $this->results = $this->fetch->getResults($fetchMode, false);

            return $this->results;
        }



        /**
         * Get the id of the last record
         *
         * @return integer
         */
        public function lastInsertId () : int
        {
            return (int)$this->pdo->lastInsertId();
        }



        /**
         * Quotes a string for use in a query
         *
         * @param string $string
         * @return void
         */
        public function quote (string $string)
        {
            return $this->pdo->quote($string);
        }
    }