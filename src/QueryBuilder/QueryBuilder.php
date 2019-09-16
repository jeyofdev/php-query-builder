<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder;

    
    use jeyofdev\Php\Query\Builder\Database\Database;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Builder\Builder;
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
         * @var Builder
         */
        private $builder;



        /**
         * @param Database $database
         * @param Syntax   $Syntax
         * @param Builder  $builder
         */
        public function __construct (Database $database, Syntax $syntax, Builder $builder)
        {
            $this->database = $database;
            $this->syntax = $syntax;
            $this->builder = $builder;
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



        /**
         * Get the instance that handles the query execution
         *
         * @return Builder
         */
        public function getBuilder () : Builder
        {
            return $this->builder;

        }
    }
