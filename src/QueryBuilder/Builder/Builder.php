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
         * @param  integer  $fetchMode  The default fetch mode
         * @return mixed
         */
        public function fetch (int $fetchMode = PDO::FETCH_BOTH)
        {
            $this->fetch = new Fetch($this->statement);
            $this->results = $this->fetch->getResults($fetchMode, true);

            return $this->results;
        }



        /**
         * Get all the results of the sql query
         *
         * @param  integer  $fetchMode  The default fetch mode
         * @return mixed
         */
        public function fetchAll (int $fetchMode = PDO::FETCH_BOTH)
        {
            $this->fetch = new Fetch($this->statement);
            $this->results = $this->fetch->getResults($fetchMode, false);

            return $this->results;
        }
    }