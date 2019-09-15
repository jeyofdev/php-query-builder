<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use jeyofdev\Php\Query\Builder\Helpers\QueryBuilderHelpers;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Attributes\AttributesAbstract;
    use PDOStatement;


    /**
     * Manage the results of a sql query
     */
    class Fetch extends AttributesAbstract
    {
        /**
         * The result(s) of the sql query
         *
         * @var mixed
         */
        private $results;



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
         * Get the results of the sql query
         *
         * @param  string   $fetchMode  The default fetch mode
         * @param  boolean  $unique     Execute a fetch or fetchAll
         * @return mixed
         */
        public function getResults (string $fetchMode = "FETCH_BOTH", bool $unique = true)
        {
            $mode = $this->SetFetchMode($fetchMode);

            if (QueryBuilderHelpers::checkStringIsInArray($fetchMode, $this->ATTRIBUTES_DEFAULT_FETCH_MODE_ALLOWED)) {
                if ($unique) {
                    $this->results = $this->statement->fetch($mode);
                } else {
                    $this->results = $this->statement->fetchAll($mode);
                }
            }

            return $this->results;
        }



        /**
         * Set the fetch mode
         *
         * @param  string  $fetchMode
         * @return integer
         */
        public function SetFetchMode (string $fetchMode = "FETCH_BOTH") : int
        {
            $property = "ATTRIBUTES_DEFAULT_FETCH_MODE_ALLOWED";
            
            foreach ($this->$property as $value) {
                if ($value === $fetchMode) {
                    $fetchMode = constant("PDO::$value");
                }
            }

            return $fetchMode;
        }
    }