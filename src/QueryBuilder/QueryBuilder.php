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
         * @param Database $database
         */
        public function __construct (Database $database)
        {
            $this->database = $database;

            $db_name = $this->database->getDatabaseName();
            Builder::setPdo($database->getConnection($db_name));
        }



        /**
         * Initialize a sql query of type SELECT
         *
         * @param  array ...$options
         * @return self
         */
        public function select (...$options) : self
        {
            Syntax::select(...$options);
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
            Syntax::insert(...$options);
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
            Syntax::update(...$options);
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
            Syntax::delete(...$options);
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
            Syntax::columns(...$columns);
            return $this;
        }



        /**
         * Set the sql function of the query
         *
         * @param  string       $functionSql  The sql function 
         * @param  string       $columns      The column of the table  
         * @param  string|null  $alias        The alias of the sql function
         * @return self
         */
        public function functionSql (string $functionSql, string $columns, ?string $alias = null) : self
        {
            Syntax::functionSql($functionSql, $columns, $alias);
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
            Syntax::table($tableName, $alias);
            return $this;
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
            Syntax::join($joinType, $joinTable, $joinAlias);
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
            Syntax::on($relationA, $relationB);
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
            Syntax::where($column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
            return $this;
        }



        /**
         * Set the "GROUP BY" command in the sql query
         *
         * @param  string   $column  The column that groups the results of sql functions
         * @param  boolean  $rollup  Enable the rollup option
         * @return self
         */
        public function groupBy (string $column, bool $rollup = false) : self
        {
            Syntax::groupBy($column, $rollup);
            return $this;
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
         * @return self
         */
        public function having (string $functionSql, string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : self
        {
            Syntax::having($functionSql, $column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
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
            Syntax::orderBy($column, $direction);
            return $this;
        }



        /**
         * Set the "LIMIT" command in the sql query
         * 
         * @param  integer $limit
         * @return self
         */
        public function limit (int $limit) : self
        {
            Syntax::limit($limit);
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
            Syntax::offset($offset);
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
            Syntax::page($page);
            return $this;
        }



        /**
         * Generate the sql query
         *
         * @return string
         */
        public function toSql () : string
        {
            return Syntax::toSql();
        }



        /**
         * Get the value of an attribute
         *
         * @param  string  $attribute
         * @return int
         */
        public function getAttribute (string $attribute) : int
        {
            return Builder::getAttribute($attribute);
        }



        /**
         * Set the value of an attribute
         *
         * @param  array  $attributes
         * @return self
         */
        public function setAttribute (array $attributes = []) : self
        {
            Builder::setAttribute($attributes);
            return $this;
        }



        /**
         * Executes an SQL statement with the PDO::query method
         *
         * @param  string  $query  The sql query
         * @return self
         */
        public function query (string $query) : self
        {
            Builder::query($query);
            return $this;
        }



        /**
         * Executes an SQL statement with the PDO::prepare method
         *
         * @param  string  $query  The sql query
         * @return self
         */
        public function prepare (string $query) : self
        {
            Builder::prepare($query);
            return $this;
        }



        /**
         * Execute an SQL statement and return the number of affected rows
         *
         * @param  string  $query
         * @return integer
         */
        public function exec (string $query) : int
        {
            
            return Builder::exec($query);
        }



        /**
         * Executes a prepared statement
         *
         * @param  array  $params  The values ​​of the sql query parameters
         * @return self
         */
        public function execute (array $params = []) : self
        {
            Builder::execute($params);
            return $this;
        }



        /**
         * Get the result of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return mixed
         */
        public function fetch (string $fetchMode = "FETCH_BOTH")
        {
            return Builder::fetch($fetchMode);
        }



        /**
         * Get all the results of the sql query
         *
         * @param  string  $fetchMode  The default fetch mode
         * @return array
         */
        public function fetchAll (string $fetchMode = "FETCH_BOTH") : array
        {
            return Builder::fetchAll($fetchMode);
        }



        /**
         * Get the id of the last record
         *
         * @return integer
         */
        public function lastInsertId () : int
        {
            return Builder::lastInsertId();
        }



        /**
         * Quotes a string for use in a query
         *
         * @param string $string
         * @return string
         */
        public function quote (string $string) : string
        {
            return Builder::quote($string);
        }



        /**
         * Returns the number of rows affected by the SQL statement
         *
         * @return integer
         */
        public function rowCount () : int
        {
            return Builder::rowCount();
        }
    }
