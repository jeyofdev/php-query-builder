<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Builder;


    use PDO;
    use PDOStatement;


    /**
     * Manage instances related to the builder of the sql query
     */
    class BuilderFactory
    {
        /**
         * @param PDO $pdo
         * @return void
         */
        public static function addAttribute (PDO $pdo)
        {
            return new Attribute($pdo);
        }



        /**
         * @param PDOStatement $statement
         * @return void
         */
        public static function addFetch (PDOStatement $statement)
        {
            return new Fetch($statement);
        }



        /**
         * @param PDOStatement $statement
         * @return void
         */
        public static function addExecute (PDOStatement $statement)
        {
            return new Execute($statement);
        }
    }