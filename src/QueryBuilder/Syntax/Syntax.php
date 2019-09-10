<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxException;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql\AggregateFunctionSql;


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
         * @var AggregateFunctionSql
         */
        private $aggregateFunctionSql;



        /**
         * @var Table
         */
        private $table;



        /**
         * @var Where;
         */
        private $where;



        /**
         * @var OrderBy
         */
        private $orderBy;



        /**
         * @var Limit
         */
        private $limit;



        /**
         * @var Offset
         */
        private $offset;



        /**
         * @var Join
         */
        private $join;



        /**
         * The different parts of the sql query
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
         * Initialize a sql query of type SELECT
         *
         * @param  array ...$options
         * @return self
         */
        public function select (...$options) : self
        {
            $this->getCrud("SELECT", $options);
            return $this;
        }



        /**
         * Initialize a sql query of type INSERT INTO
         *
         * @param  array ...$options
         * @return self
         */
        public function insert (...$options) : self
        {
            $this->getCrud("INSERT INTO", $options);
            return $this;
        }



        /**
         * Initialize a sql query of type UPDATE
         *
         * @param  array ...$options
         * @return self
         */
        public function update (...$options) : self
        {
            $this->getCrud("UPDATE", $options);
            return $this;
        }



        /**
         * Initialize a sql query of type DELETE
         *
         * @param  array ...$options
         * @return self
         */
        public function delete (...$options) : self
        {
            $this->getCrud("DELETE", $options);
            return $this;
        }



        /**
         * Set the columns to use in the sql query
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
         * Set the sql function of the query
         *
         * @param  string       $functionSql  The sql function 
         * @param  string       $columns      The column of the table  
         * @param  string|null  $alias        The alias of the sql function
         * @param  boolean|null $unique       Use the sql function as unique column
         * @return self
         */
        public function functionSql (string $functionSql, string $columns, ?string $alias = null, ?bool $unique = false) : self
        {
            $this->aggregateFunctionSql = new AggregateFunctionSql();

            $this->aggregateFunctionSql->setFunctionSql($functionSql, $columns, $alias);
            $function = $this->aggregateFunctionSql->getFunctionSql();

            $this->sqlParts[__FUNCTION__] = $function;
            $this->sqlParts["aggregate"] = $unique;

            return $this;
        }



        /**
         * Set the table to use in the sql query
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
         * Set the condition in the sql query
         *
         * @param  string      $column            The column of the table  
         * @param  string|int  $value             The parameter or the value of the condition
         * @param  string      $operator          The comparison operator used in the condition 
         * @param  string|null $logicOperator     The logic operator if necessary
         * @param  boolean     $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean     $begin             Activate the opening parenthesis
         * @param  boolean     $end               Activate the closing parenthesis       
         * @return self
         */
        public function where (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : self
        {
            if (is_null($this->where)) {
                $this->where = new Where();
            }

            $this->where->setCondition($column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
            $condition = $this->where->getCondition();

            $this->sqlParts[__FUNCTION__] = " WHERE {$condition}";

            return $this;
        }



        /**
         * Set the "ORDER BY" command in the sql query
         *
         * @param  string|array $column    The column of the table
         * @param  string|null  $direction The direction (ASC or DESC)
         * @return self
         */
        public function orderBy ($column, ?string $direction = "ASC") : self
        {
            if (is_null($this->orderBy)) {
                $this->orderBy = new OrderBy();
            }

            $this->orderBy->setColumnAndDirection($column, $direction);
            $orderBy = $this->orderBy->getColumnAndDirection();

            $this->sqlParts[__FUNCTION__] = " ORDER BY {$orderBy}";

            return $this;
        }



        /**
         * Set the "LIMIT" command in the sql query
         * @param  integer $limit
         * @return self
         */
        public function limit (int $limit) : self
        {
            $this->limit = new Limit();

            $this->limit->setLimit($limit);
            $limit = ($this->limit->getLimit() > 0) ? $this->limit->getLimit() : null;

            $this->sqlParts[__FUNCTION__] = $limit ? " LIMIT {$limit}" : null;

            return $this;
        }



        /**
         * Set the "OFFSET" command in the sql query
         *
         * @param  integer $offset
         * @return self
         */
        public function offset (int $offset) : self
        {
            $this->offset = new Offset();

            $this->offset->setOffset($offset);

            if ($this->offset->getOffset() > 0) {
                if ($this->offset->checkThatLimitIsGreaterThanZero($this->limit->getLimit())) {
                    $offset = $this->offset->getOffset();
                    $this->sqlParts[__FUNCTION__] = " OFFSET {$offset}";
                }
            }

            return $this;
        }



        /**
         * Set the OFFSET command corresponding to a page in the sql query
         *
         * @param  integer $page
         * @return self
         */
        public function page (int $page) : self
        {
            $this->offset = new Offset();
            
            if ($this->offset->checkThatLimitIsGreaterThanZero($this->limit->getLimit())) {
                return $this->offset($this->limit->getLimit() * ($page - 1));
            }
        }



        /**
         * Set the join between 2 tables in a sql query
         *
         * @param  string      $joinType   The type of join
         * @param  string      $joinTable  The join table
         * @param  string|null $joinAlias  The alias of the join table
         * @return self
         */
        public function join (string $joinType, string $joinTable, ?string $joinAlias = null) : self
        {
            $this->join = new Join();

            $this->join->setJoin($joinType, $joinTable, $joinAlias);
            $join = $this->join->getJoin();

            $this->sqlParts[__FUNCTION__] = " {$join}";

            return $this;
        }



        /**
         * Set the columns that serve as a join between the 2 tables in a sql query
         *
         * @param  string  $relationA  The column that serve as a join of the table A
         * @param  string  $relationB  The column that serve as a join of the table B
         * @return self
         */
        public function on (string $relationA, string $relationB) : self
        {
            if (!is_null($this->join)) {
                $this->join->setOn($relationA, $relationB);

                $on = $this->join->getOn();
                $this->sqlParts[__FUNCTION__] = " ON {$on}";
            } else {
                throw new SyntaxException("join");
            }

            return $this;
        }



        /**
         * Generate the sql query
         *
         * @return string
         */
        public function toSql () : string
        {
            list($functionSql, $join, $on, $where, $orderBy, $limit, $offset) = null;

            $columns = "*";

            $this->checkMethodIsCalled("crud");
            extract($this->sqlParts);

            if (!is_null($functionSql)) {
                $columns = null;
            }

            if (($this->crud->getCrud() === "INSERT INTO") || ($this->crud->getCrud() === "UPDATE")) {
                $this->checkMethodIsCalled("columns", "table");
                $this->sql = "$crud $table $columns";
            } if ($this->crud->getCrud() === "UPDATE") {
                $this->sql .= $where;
            }else if ($this->crud->getCrud() === "SELECT") {
                $this->checkMethodIsCalled("table");
                if (isset($aggregate)) {
                    if($aggregate === true) {
                        $columns = $functionSql;
                    } else {
                        $columns = "$columns, $functionSql";
                    }
                } 
                if (isset($columns)) {
                    $this->sql = "$crud $columns $table" .  $join . $on . $where . $orderBy . $limit . $offset;
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
         * @param  string $crud        SELECT, INSERT INTO, UPDATE or DELETE
         * @param  array  ...$options  DISTINCT, SQL_CACHE, SQL_NO_CACHE...
         * @return void
         */
        private function getCrud (string $crud, ...$options) : void
        {
            $this->crud = new Crud();

            $this->crud->setCrud($crud);
            $this->crud->setOption($options);

            $crud = $this->crud->getCrud();
            $options = $this->crud->getOption();

            $this->sqlParts["crud"] = !is_null($options) ? "$crud $options" : $crud;
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