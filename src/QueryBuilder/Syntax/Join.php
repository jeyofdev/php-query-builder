<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxJoinException;
    use jeyofdev\Php\Query\Builder\Helpers\SyntaxHelpers;


    /**
     * Manage the joins of SQL queries
     */
    class Join
    {
        /**
         * List of allowed join types
         */
        const JOIN_TYPES_ALLOWED = [
            "JOIN",
            "INNER JOIN",
            "CROSS JOIN",
            "LEFT JOIN",
            "RIGHT JOIN",
            "FULL JOIN"
        ];



        /**
         * The type of join and the join table
         *
         * @var string
         */
        private $join;



        /**
         * The join table
         *
         * @var string
         */
        private $joinTable;



        /**
         * The columns that serve as a join between the 2 tables
         *
         * @var string
         */
        private $on;



        /**
         * Get the type of join and the join table
         *
         * @return string|null
         */
        public function getJoin () : ?string
        {
            return $this->join;
        }



        /**
         * Set the type of join and the join table
         *
         * @param  string       $joinType   The type of join
         * @param  string       $joinTable  The join table
         * @param  string|null  $joinAlias  The alias of the join table
         * @return void
         */
        public function setJoin (string $joinType, string $joinTable, ?string $joinAlias = null) : void 
        {
            $joinType = strtoupper($joinType);

            if(SyntaxHelpers::checkStringIsInArray($joinType, self::JOIN_TYPES_ALLOWED)) {
                $this->join = $joinType;
            } else {
                throw new SyntaxJoinException("The value of the 1st parameter of the join method is not allowed");
            }

            $this->setJoinTable($joinTable);
            $this->join .= " {$this->joinTable}";

            if (!is_null($joinAlias)) {
                $this->join .= " AS $joinAlias";
            }
        }



        /**
         * Set the join table
         *
         * @param  string  $joinTable
         * @return void
         */
        public function setJoinTable (string $joinTable) : void
        {
            $this->joinTable = $joinTable;
        }



        /**
         * Get the columns that serve as a join between the 2 tables
         *
         * @return string|null
         */
        public function getOn () : ?string
        {
            return $this->on;
        }



        /**
         * Get the columns that serve as a join between the 2 tables
         *
         * @param  string  $relationLeft  The column that serve as a join of the table A
         * @param  string  $relationRight The column that serve as a join of the table B
         * @return void
         */
        public function setOn (string $relationLeft, string $relationRight) : void
        {
            $this->on = "$relationLeft = $relationRight";
        }
    }
    