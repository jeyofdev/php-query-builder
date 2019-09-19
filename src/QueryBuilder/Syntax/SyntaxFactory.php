<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql\AggregateFunctionSql;


    /**
     * Manage instances related to the syntax of the sql query
     */
    class SyntaxFactory
    {
        /**
         * @return Crud
         */
        public static function addCrud () : Crud
        {
            return new Crud();
        }



        /**
         * @return Columns
         */
        public static function addColumns () : Columns
        {
            return new Columns();
        }



        /**
         * @return AggregateFunctionSql
         */
        public static function addAggregateFunctionSql () : AggregateFunctionSql
        {
            return new AggregateFunctionSql();
        }



        /**
         * @return Table
         */
        public static function addTable () : Table
        {
            return new Table();
        }



        /**
         * @return Join
         */
        public static function addJoin () : Join
        {
            return new Join();
        }



        /**
         * @return Where
         */
        public static function addWhere () : Where
        {
            return new Where();
        }



        /**
         * @return GroupBy
         */
        public static function addGroupBy () : GroupBy
        {
            return new GroupBy();
        }



        /**
         * @param AggregateFunctionSql $aggregateFunctionSql
         * @return Having
         */
        public static function addHaving (AggregateFunctionSql $aggregateFunctionSql) : Having
        {
            return new Having($aggregateFunctionSql);
        }



        /**
         * @return OrderBy
         */
        public static function addOrderBy () : OrderBy
        {
            return new OrderBy();
        }



        /**
         * @return Limit
         */
        public static function addLimit () : Limit
        {
            return new Limit();
        }



        /**
         * @return Offset
         */
        public static function addOffset () : Offset
        {
            return new Offset();
        }
    }