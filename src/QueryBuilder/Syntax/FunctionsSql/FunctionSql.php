<?php
    
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxFunctionSqlException;
    use jeyofdev\Php\Query\Builder\Helpers\QueryBuilderHelpers;


    /**
     * Manage sql functions of SQL queries
     */
    abstract class FunctionSql
    {
        /**
         * The aggregate sql functions allowed
         */
        const FUNCTION_SQL_AGGREGATE_ALLOWED = ["AVG", "COUNT", "MAX", "MIN", "SUM"];



        /**
         * The sql functions
         *
         * @var string
         */
        protected $functionSql;



        /**
         * The sql functions parts
         *
         * @var array
         */
        protected $functionSqlParts;



        /**
         * Set the sql functions
         *
         * @param string       $functionSqlName  The sql function 
         * @param string       $column           The column of the table  
         * @param string|null  $alias            The alias of the sql function
         * @return void
         */
        public function setFunctionSql (string $functionSqlName, string $column, ?string $alias = null) : void
        {
            $functionSqlName = strtoupper($functionSqlName);

            $this->addFunctionSql($functionSqlName, $column, $alias);
            $this->functionSql = implode(", ", $this->functionSqlParts);
        }



        /**
         * Get the sql function 
         *
         * @return string|null 
         */
        public function getFunctionSql () : ?string
        {
            return $this->functionSql;
        }



        /**
         * Empty the sql functions
         *
         * @return void
         */
        public function empty () : void
        {
            $this->functionSql = null;
            $this->functionSqlParts = [];
        }



        /**
         * Add a sql function
         *
         * @param string       $functionSqlName  The sql function 
         * @param string       $column           The column of the table  
         * @param string|null  $alias            The alias of the sql function
         * @return void
         */
        private function addFunctionSql (string $functionSqlName, string $column, ?string $alias = null) : void
        {
            if (QueryBuilderHelpers::checkStringIsInArray($functionSqlName, self::FUNCTION_SQL_AGGREGATE_ALLOWED)) {
                $method = strtolower($functionSqlName);

                if (!is_null($alias)) {
                    $alias = " AS $alias";
                }

                $this->functionSqlParts[] = $this->$method($column) . $alias;

            } else {
                throw new SyntaxFunctionSqlException("The sql function is not allowed");
            }
        }
    }