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
        private static $crud;



        /**
         * @var Columns
         */
        private static $columns;



        /**
         * @var AggregateFunctionSql
         */
        private static $aggregateFunctionSql;



        /**
         * @var Table
         */
        private static $table;



        /**
         * @var Join
         */
        private static $join;



        /**
         * @var Where;
         */
        private static $where;



        /**
         * @var GroupBy
         */
        private static $groupBy;



        /**
         * @var Having
         */
        private static $having;



        /**
         * @var OrderBy
         */
        private static $orderBy;



        /**
         * @var Limit
         */
        private static $limit;



        /**
         * @var Offset
         */
        private static $offset;



        /**
         * The different parts of the sql query
         *
         * @var array
         */
        private static $sqlParts = [];



        /**
         * The sql query
         *
         * @var string
         */
        private static $sql;



        /**
         * Initialize a sql query of type SELECT
         *
         * @param  array ...$options
         * @return void
         */
        public static function select (...$options) : void
        {
            self::getCrud("SELECT", $options);
        }



        /**
         * Initialize a sql query of type INSERT INTO
         *
         * @param  array ...$options
         * @return void
         */
        public static function insert (...$options) : void
        {
            self::getCrud("INSERT INTO", $options);
        }



        /**
         * Initialize a sql query of type UPDATE
         *
         * @param  array ...$options
         * @return void
         */
        public static function update (...$options) : void
        {
            self::getCrud("UPDATE", $options);
        }



        /**
         * Initialize a sql query of type DELETE
         *
         * @param  array ...$options
         * @return void
         */
        public static function delete (...$options) : void
        {
            self::getCrud("DELETE", $options);
        }



        /**
         * Set the columns to use in the sql query
         *
         * @param  mixed  ...$columns
         * @return void
         */
        public static function columns (...$columns) : void
        {
            self::$columns = new Columns();

            self::checkMethodIsCalled("crud");

            if (self::$crud->getCrud() === "INSERT INTO" || self::$crud->getCrud() === "UPDATE") {
                self::$columns->setColumnsWithClauseSET($columns);
            } else {
                self::$columns->setColumns($columns);
            }

            $columns = self::$columns->getColumns();
            self::$sqlParts[__FUNCTION__] = $columns;
        }



        /**
         * Set the sql function of the query
         *
         * @param  string       $functionSql  The sql function 
         * @param  string       $columns      The column of the table  
         * @param  string|null  $alias        The alias of the sql function
         * @return void
         */
        public static function functionSql (string $functionSql, string $columns, ?string $alias = null) : void
        {
            if (is_null(self::$aggregateFunctionSql)) {
                self::$aggregateFunctionSql = new AggregateFunctionSql();
            }

            self::$aggregateFunctionSql->setFunctionSql($functionSql, $columns, $alias);
            $function = self::$aggregateFunctionSql->getFunctionSql();

            self::$sqlParts[__FUNCTION__] = $function;
        }



        /**
         * Set the table to use in the sql query
         *
         * @param  string      $tableName
         * @param  string|null $alias
         * @return void
         */
        public static function table (string $tableName, ?string $alias = null) : void
        {
            self::$table = new Table();

            self::checkMethodIsCalled("crud");
            self::$table->setTable($tableName, $alias);
            
            if (self::$crud->getCrud() === "SELECT" || self::$crud->getCrud() === "DELETE") {
                $table = "FROM " . self::$table->getTable();
            } else {
                $table = self::$table->getTable();
            }

            self::$sqlParts[__FUNCTION__] = $table;
        }



        /**
         * Set the join between 2 tables in a sql query
         *
         * @param  string      $joinType   The type of join
         * @param  string      $joinTable  The join table
         * @param  string|null $joinAlias  The alias of the join table
         * @return void
         */
        public static function join (string $joinType, string $joinTable, ?string $joinAlias = null) : void
        {
            self::$join = new Join();

            self::$join->setJoin($joinType, $joinTable, $joinAlias);
            $join = self::$join->getJoin();

            self::$sqlParts[__FUNCTION__] = " {$join}";
        }



        /**
         * Set the columns that serve as a join between the 2 tables in a sql query
         *
         * @param  string  $relationA  The column that serve as a join of the table A
         * @param  string  $relationB  The column that serve as a join of the table B
         * @return void
         */
        public static function on (string $relationA, string $relationB) : void
        {
            if (!is_null(self::$join)) {
                self::$join->setOn($relationA, $relationB);

                $on = self::$join->getOn();
                self::$sqlParts[__FUNCTION__] = " ON {$on}";
            } else {
                throw new SyntaxException("join");
            }
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
         * @return void
         */
        public static function where (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            if (is_null(self::$where)) {
                self::$where = new Where();
            }

            self::$where->setCondition($column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
            $condition = self::$where->getCondition();

            self::$sqlParts[__FUNCTION__] = " WHERE {$condition}";
        }



        /**
         * Set the "GROUP BY" command in the sql query
         *
         * @param  string   $column  The column that groups the results of sql functions
         * @param  boolean  $rollup  Enable the rollup option
         * @return void
         */
        public static function groupBy (string $column, bool $rollup = false) : void
        {
            self::$groupBy = new GroupBy();

            self::$groupBy->setGroupBy($column);
            $groupBy = self::$groupBy->getGroupBy();

            self::$sqlParts[__FUNCTION__] = " GROUP BY {$groupBy}";

            if ($rollup) {
                self::$sqlParts[__FUNCTION__] .= " WITH ROLLUP";
            }
        }



        /**
         * Set the "HAVING" command in the sql query
         *
         * @param  string      $functionSql       The sql function 
         * @param  string      $column            The column of the table  
         * @param  string|int  $value             The parameter or the value of the condition
         * @param  string      $operator          The comparison operator used in the condition 
         * @param  string|null $logicOperator     The logic operator if necessary
         * @param  boolean     $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean     $begin             Activate the opening parenthesis
         * @param  boolean     $end               Activate the closing parenthesis       
         * @return void
         */
        public static function having (string $functionSql, string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            if (is_null(self::$aggregateFunctionSql)) {
                self::$aggregateFunctionSql = new AggregateFunctionSql();
            }

            if (is_null(self::$having)) {
                self::$having = new Having(self::$aggregateFunctionSql);
            }

            self::$having->setHaving($functionSql, $column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
            $having = self::$having->getHaving();

            self::$sqlParts[__FUNCTION__] = " HAVING {$having}";
        }



        /**
         * Set the "ORDER BY" command in the sql query
         *
         * @param  string|array $column    The column of the table
         * @param  string|null  $direction The direction (ASC or DESC)
         * @return void
         */
        public static function orderBy ($column, ?string $direction = "ASC") : void
        {
            if (is_null(self::$orderBy)) {
                self::$orderBy = new OrderBy();
            }

            self::$orderBy->setColumnAndDirection($column, $direction);
            $orderBy = self::$orderBy->getColumnAndDirection();

            self::$sqlParts[__FUNCTION__] = " ORDER BY {$orderBy}";
        }



        /**
         * Set the "LIMIT" command in the sql query
         * @param  integer $limit
         * @return void
         */
        public static function limit (int $limit) : void
        {
            self::$limit = new Limit();

            self::$limit->setLimit($limit);
            $limit = (self::$limit->getLimit() > 0) ? self::$limit->getLimit() : null;

            self::$sqlParts[__FUNCTION__] = $limit ? " LIMIT {$limit}" : null;
        }



        /**
         * Set the "OFFSET" command in the sql query
         *
         * @param  integer $offset
         * @return void
         */
        public static function offset (int $offset) : void
        {
            self::$offset = new Offset();

            self::$offset->setOffset($offset);

            if (self::$offset->getOffset() > 0) {
                if (self::$offset->checkThatLimitIsGreaterThanZero(self::$limit->getLimit())) {
                    $offset = self::$offset->getOffset();
                    self::$sqlParts[__FUNCTION__] = " OFFSET {$offset}";
                }
            }
        }



        /**
         * Set the OFFSET command corresponding to a page in the sql query
         *
         * @param  integer $page
         * @return void
         */
        public static function page (int $page) : void
        {
            self::$offset = new Offset();
            
            if (self::$offset->checkThatLimitIsGreaterThanZero(self::$limit->getLimit())) {
                self::offset(self::$limit->getLimit() * ($page - 1));
            }
        }



        /**
         * Generate the sql query
         *
         * @return string
         */
        public static function toSql () : string
        {
            list($functionSql, $join, $on, $where, $groupBy, $having, $orderBy, $limit, $offset) = null;

            $columns = "*";

            self::checkMethodIsCalled("crud");
            extract(self::$sqlParts);

            if ((self::$crud->getCrud() === "INSERT INTO") || (self::$crud->getCrud() === "UPDATE")) {
                self::checkMethodIsCalled("columns", "table");
                self::$sql = "$crud $table $columns";
            } if (self::$crud->getCrud() === "UPDATE") {
                self::$sql .= $where;
            } else if (self::$crud->getCrud() === "SELECT") {
                self::checkMethodIsCalled("table");

                if (!is_null($functionSql)) {
                    $columns = "$columns, $functionSql";
                }

                if (isset($columns)) {
                    self::$sql = "$crud $columns $table" .  $join . $on . $where . $groupBy . $having . $orderBy . $limit . $offset;
                } else {
                    self::$sql = "$crud $table";
                }
            } else if (self::$crud->getCrud() === "DELETE") {
                self::$sql = "$crud $table" . $where;
            }

            self::$sqlParts = [];
            
            if (!is_null($where)) self::$where->empty();
            if (!is_null($columns)) $columns = null;
            if (!is_null($functionSql)) self::$aggregateFunctionSql->empty();
            if (!is_null($having)) self::$having->empty();

            return self::$sql;
        }


        /**
         * Get the value of the crud
         *
         * @param  string $crud        SELECT, INSERT INTO, UPDATE or DELETE
         * @param  array  ...$options  DISTINCT, SQL_CACHE, SQL_NO_CACHE...
         * @return void
         */
        private static function getCrud (string $crud, ...$options) : void
        {
            self::$crud = new Crud();

            self::$crud->setCrud($crud);
            self::$crud->setOption($options);

            $crud = self::$crud->getCrud();
            $options = self::$crud->getOption();

            self::$sqlParts["crud"] = !is_null($options) ? "$crud $options" : $crud;
        }



        /**
         * Check if a method is called
         *
         * @param  string  ...$methods
         * @return void
         */
        private static function checkMethodIsCalled (string ...$methods) : void
        {
            foreach ($methods as $method) {
                if (!array_key_exists($method, self::$sqlParts)) {
                    throw new SyntaxException($method);
                }
            }
        }
    }