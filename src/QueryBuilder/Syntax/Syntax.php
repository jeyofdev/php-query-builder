<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxException;


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
         * @var Table
         */
        private $table;



        /**
         * @var Where;
         */
        private $where;



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
         * Set the columns to use in the queries
         *
         * @param  mixed  ...$columns
         * @return self
         */
        public function columns (...$columns) : self
        {
            $this->columns = new Columns();

            $this->checkMethodIsCalled("crud");

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
         * Set the table to use in the queries
         *
         * @param  string      $tableName
         * @param  string|null $alias
         * @return self
         */
        public function table (string $tableName, ?string $alias = null) : self
        {
            $this->table = new Table();

            $this->checkMethodIsCalled("crud");
            $this->table->setTable($tableName, $alias);
            
            if ($this->crud->getCrud() === "SELECT" || $this->crud->getCrud() === "DELETE") {
                $table = "FROM {$this->table->getTable()}";
            } else {
                $table = $this->table->getTable();
            }

            $this->sqlParts[__FUNCTION__] = $table;

            return $this;
        }



        /**
         * Set the condition of the query
         *
         * @param  string      $column            The column of the table  
         * @param  string|int  $value             The parameter or the value of the condition
         * @param  string      $operator          The comparison operator used in the condition 
         * @param  string|null $logicOperator     The logic operator if necessary
         * @param  boolean     $logicOperatorNOT  The Logic Operator NOT if necessary
         * @return self
         */
        public function where (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false) : self
        {
            if (is_null($this->where)) {
                $this->where = new Where();
            }

            $this->where->setCondition($column, $value, $operator, $logicOperator, $logicOperatorNOT);
            $condition = $this->where->getCondition();

            $this->sqlParts[__FUNCTION__] = " WHERE {$condition}";

            return $this;
        }



        /**
         * Generate the sql query
         *
         * @return string
         */
        public function toSql () : string
        {
            $where = null;
            $columns = "*";
            
            $this->checkMethodIsCalled("crud");
            extract($this->sqlParts);

            if (($this->crud->getCrud() === "INSERT INTO") || ($this->crud->getCrud() === "UPDATE")) {
                $this->checkMethodIsCalled("columns", "table");
                $this->sql = "$crud $table $columns";
            } if ($this->crud->getCrud() === "UPDATE") {
                $this->sql .= $where;
            }else if ($this->crud->getCrud() === "SELECT") {
                $this->checkMethodIsCalled("table");
                if (isset($columns)) {
                    $this->sql = "$crud $columns $table" . $where;
                } else {
                    $this->sql = "$crud $table";
                }
            } else if ($this->crud->getCrud() === "DELETE") {
                $this->sql = "$crud $table" . $where;
            }

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



        /**
         * check if a method is called
         *
         * @param  string  ...$methods
         * @return void
         */
        private function checkMethodIsCalled (string ...$methods)
        {
            foreach ($methods as $method) {
                if (!array_key_exists($method, $this->sqlParts)) {
                    throw new SyntaxException($method);
                }
            }
        }
    }