<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use PDO;
    use PDOStatement;


    /**
     * Manage the results of a sql query
     */
    class Fetch
    {
        /**
         * The fetch mode allowed
         */
        const FETCH_MODES_ALLOWED = [
            "FETCH_ASSOC" => PDO::FETCH_ASSOC,
            "FETCH_BOTH" => PDO::FETCH_BOTH,
            "FETCH_CLASS" => PDO::FETCH_CLASS,
            "FETCH_INTO" => PDO::FETCH_INTO,
            "FETCH_LAZY" => PDO::FETCH_LAZY,
            "FETCH_NAMED" => PDO::FETCH_NAMED,
            "FETCH_NUM" => PDO::FETCH_NUM,
            "FETCH_OBJ" => PDO::FETCH_OBJ,
            "FETCH_PROPS_LATE" => PDO::FETCH_PROPS_LATE,
        ];



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
         * @param  integer  $fetchMode  The default fetch mode
         * @param  boolean  $unique     Execute a fetch or fetchAll
         * @return void
         */
        public function getResults (int $fetchMode = PDO::FETCH_BOTH, bool $unique = true)
        {
            $fetchMode = $this->SetFetchMode($fetchMode);

            if ($this->checkIntIsInArray($fetchMode, $this::FETCH_MODES_ALLOWED)) {
                if ($unique) {
                    $this->results = $this->statement->fetch($fetchMode);
                } else {
                    $this->results = $this->statement->fetchAll($fetchMode);
                }
            }

            return $this->results;
        }



        /**
         * Set the fetch mode
         *
         * @param  integer $fetchMode
         * @return integer
         */
        public function SetFetchMode (int $fetchMode = PDO::FETCH_BOTH) : int
        {
            if (array_key_exists($fetchMode, self::FETCH_MODES_ALLOWED)) {
                $fetchMode = self::FETCH_MODES_ALLOWED[$fetchMode];
            }

            return $fetchMode;
        }



        /**
         * Check that a value is contained in an array
         *
         * @param  integer  $value
         * @param  array    $datasAllowed
         * @return boolean
         */
        public static function checkIntIsInArray (int $value, array $datasAllowed) : bool
        {
            if (!in_array($value, $datasAllowed)) {
                return false;
            }

            return true;
        }
    }