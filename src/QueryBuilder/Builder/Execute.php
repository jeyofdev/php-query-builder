<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use jeyofdev\Php\Query\Builder\Exception\Builder\BuilderExecuteException;
    use PDOStatement;


    /**
     * Manage the parameters of the sql query
     */
    class Execute
    {
        /**
         * Represents the executed sql query
         *
         * @var PDOStatement
         */
        private $statement;



        /**
         * @param PDOStatement $statement
         */
        public function __construct ($statement)
        {
            $this->statement = $statement;
        }



        /**
         * Executes a prepared statement
         *
         * @param  array  $params  The value of the parameters of the SQL query
         * @return void
         */
        public function execute (array $params = []) : void
        {
            $count = count($params);

            if ($this->countQueryParams($this->statement->queryString) === $count) {
                $this->statement->execute($params);
            } else {
                throw new BuilderExecuteException("All the parameters of the query have not been defined in the execute method");
            }
        }



        /**
         * Get the number of parameters in the sql query
         *
         * @param  string  $query  The sql query
         * @return integer
         */
        private function countQueryParams(string $query) : int
        {
            $sqlParts = explode(" ", $query);
            $sqlParams = [];

            foreach ($sqlParts as $part) {
                if (strpos($part, ":") === 0) {
                    $sqlParams[] = $part;
                }
            }

            return count($sqlParams);
        }
    }