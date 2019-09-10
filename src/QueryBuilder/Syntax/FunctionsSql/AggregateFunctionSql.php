<?php
    
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql;


    /**
     * Manage SQL aggregate functions
     */
    class AggregateFunctionSql extends FunctionSql
    {
        /**
         * Get the number of total records from a table
         *
         * @param  string $column 
         * @return string
         */
        public function count (string $column) : string
        {
            return "COUNT($column)";
        }



        /**
         * Get the average value on a set of numeric and non-zero type record
         *
         * @param  string $column
         * @return string
         */
        public function avg (string $column) : string
        {
            return "AVG($column)";
        }



        /**
         * Get the maximum value of a column on record set
         *
         * @param  string $column
         * @return string
         */
        public function max (string $column) : string
        {
            return "MAX($column)";
        }



        /**
         * Get the minimum value of a column on record set
         *
         * @param  string $column
         * @return string
         */
        public function min (string $column) : string
        {
            return "MIN($column)";
        }



        /**
         * Get the sum total of a column containing numeric values
         *
         * @param  string $column
         * @return string
         */
        public function sum (string $column) : string
        {
            return "SUM($column)";
        }
    }