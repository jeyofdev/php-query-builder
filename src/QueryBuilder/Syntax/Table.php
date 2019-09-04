<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    /**
     * Manage the table that is used in a sql request
     */
    class Table
    {
        /**
         * The name of the table
         *
         * @var string
         */
        private $table;



        /**
         * Get the name of the table
         *
         * @return string
         */
        public function getTable () : string
        {
            return $this->table;
        }



        /**
         * Set the name of the table
         *
         * @param  string       $tableName
         * @param  string|null  $alias
         * @return void
         */
        public function setTable (string $tableName, ?string $alias = null) : void
        {
            if ($alias != null){
                $this->table = "$tableName AS $alias";
            } else {
                $this->table = $tableName;
            }
        }
    }
    