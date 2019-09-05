<?php
    
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxOffsetException;


    /**
     * Manage the "OFFSET" command of SQL queries
     */
    class Offset
    {
        /**
         * The value of the OFFSET command
         *
         * @var integer
         */
        private $offset;



        /**
         * Get the offset
         *
         * @return integer|null
         */
        public function getOffset () : ?int
        {
            return $this->offset;
        }



        /**
         * Set the offset
         *
         * @param  integer  $offset
         * @return void
         */
        public function setOffset (int $offset) : void
        {
            $this->offset = ($offset > 0) ? $offset : 0;
        }



        /**
         * Check that the value of the limit command is greater than 0
         *
         * @param  integer|null $limit
         * @return boolean
         */
        public function checkThatLimitIsGreaterThanZero (?int $limit = null) : ?bool
        {
            if (($limit === null) && ($limit <= 0)) {
                throw new SyntaxOffsetException("An offset must have a limit clause > 0");
            }

            return true;
        }
    }