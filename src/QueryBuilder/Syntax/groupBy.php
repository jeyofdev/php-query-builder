<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    /**
     * Manage the "GROUP BY" command of SQL queries
     */
    class GroupBy
    {
        /**
         * The column that groups the results of sql functions
         *
         * @var string
         */
        private $groupBy;



        /**
         * Get the column that groups the results of sql functions
         *
         * @return string|null
         */
        public function getGroupBy () : ?string
        {
            return $this->groupBy;
        }



        /**
         * Set the column that groups the results of sql functions
         *
         * @param string $column
         * @return void
         */
        public function setGroupBy (string $column) : void
        {
            $this->groupBy = $column;
        }
    }
    