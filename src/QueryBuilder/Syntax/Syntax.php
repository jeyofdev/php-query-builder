<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    /**
     * Manage the sql queries
     */
    class Syntax
    {
        /**
         * @var Crud
         */
        private $crud;



        /**
         * @var Columns
         */
        private $columns;



        /**
         * The different parts of the query
         *
         * @var array
         */
        private $sqlParts = [];



        /**
         * The sql query
         *
         * @var string
         */
        private $sql;



        /**
         * Initialize a query of type SELECT
         *
         * @return self
         */
        public function select () : self
        {
            $this->getCrud("SELECT");
            return $this;
        }



        /**
         * Initialize a query of type INSERT INTO
         *
         * @return self
         */
        public function insert () : self
        {
            $this->getCrud("INSERT INTO");
            return $this;
        }



        /**
         * Initialize a query of type UPDATE
         *
         * @return self
         */
        public function update () : self
        {
            $this->getCrud("UPDATE");
            return $this;
        }



        /**
         * Initialize a query of type DELETE
         *
         * @return self
         */
        public function delete () : self
        {
            $this->getCrud("DELETE");
            return $this;
        }



        /**
         * Set the columns to use in the query
         *
         * @param mixed ...$columns
         * @return self
         */
        public function columns (...$columns) : self
        {
            $this->columns = new Columns();

            if ($this->crud->getCrud() === "INSERT INTO" || $this->crud->getCrud() === "UPDATE") {
                $this->columns->setColumnsWithClauseSET($columns);
            } else {
                $this->columns->setColumns($columns);
            }

            $columns = $this->columns->getColumns();
            $this->sqlParts[__FUNCTION__] = $columns;

            return $this;
        }



        /**
         * Generate the sql query
         *
         * @return string
         */
        public function toSql () : string
        {
            $this->sql = implode(" ", $this->sqlParts);
            return $this->sql;
        }



        /**
         * Get the value of the crud
         *
         * @param  string $crud
         * @return void
         */
        private function getCrud (string $crud) : void
        {
            $this->crud = new Crud();

            $this->crud->setCrud($crud);
            $this->sqlParts["crud"] = $this->crud->getCrud();
        }
    }