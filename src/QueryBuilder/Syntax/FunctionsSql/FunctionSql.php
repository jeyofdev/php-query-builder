<?php
    
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxFunctionSqlException;
    use jeyofdev\Php\Query\Builder\Helpers\SyntaxHelpers;


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
         * The sql function
         *
         * @var string
         */
        protected $aggregate;



        /**
         * Set the sql function
         *
         * @param string       $functionSql  The sql function 
         * @param string       $column       The column of the table  
         * @param string|null  $alias        The alias of the sql function
         * @return void
         */
        public function setFunctionSql (string $functionSql, $column, ?string $alias = null) : void
        {
            $functionSql = strtoupper($functionSql);

            if (SyntaxHelpers::checkStringIsInArray($functionSql, self::FUNCTION_SQL_AGGREGATE_ALLOWED)) {
                $method = strtolower($functionSql);
                $this->aggregate = $this->$method($column);

                if (!is_null($alias)) {
                    $this->aggregate .= " AS $alias";
                }

            } else {
                throw new SyntaxFunctionSqlException("The sql function is not allowed");
            }
        }



        /**
         * Get the sql function 
         *
         * @return string|null 
         */
        public function getFunctionSql () : ?string
        {
            return $this->aggregate;
        }
    }