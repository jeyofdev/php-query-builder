<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder;

    
    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\Syntax;


    /**
     * Query Builder
     */
    class QueryBuilder
    {
        /**
         * @var Database
         */
        private $database;



        /**
         * @var Syntax
         */
        private $syntax;



        /**
         * @param Database $database
         * @param Syntax   $Syntax
         */
        public function __construct (Database $database, Syntax $syntax)
        {
            $this->database = $database;
            $this->syntax = $syntax;
        }



        /**
         * Get the instance that handles the query
         *
         * @return void
         */
        public function getSyntax () : Syntax
        {
            return $this->syntax;
        }
    }
