<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    /**
     * Manage the "LIMIT" command of SQL queries
     */
    class Limit
    {
        /**
         * The value of the LIMIT command
         *
         * @var integer
         */
        private $limit;



        /**
         * Get the limit
         *
         * @return integer|null
         */
        public function getLimit () : ?int
        {
            return $this->limit;
        }



        /**
         * Set the limit
         *
         * @param  integer $limit
         * @return void
         */
        public function setLimit ($limit) : void
        {
            $this->limit = ($limit > 0) ? $limit : null;
        }
    }