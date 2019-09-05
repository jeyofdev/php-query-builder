<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxOrderByException;
    use jeyofdev\Php\Query\Builder\Helpers\SyntaxHelpers;


    /**
     * Manage the the orderBy command of SQL queries
     */
    class OrderBy
    {

        const ASC = "ASC";
        const DESC = "DESC";



        /**
         * The allowed directions
         */
        const ALLOWED_DIRECTION = [self::ASC, self::DESC];



        /**
         * The columns or an array containing the columns and their directions
         *
         * @var string|array
         */
        private $column;



        /**
         * The direction
         *
         * @var string
         */
        private $direction;



        /**
         * The columns with their directions as array
         *
         * @var array
         */
        private $columnAndDirectionAsArray = [];



        /**
         * The set of columns with their directions
         *
         * @var string
         */
        private $columnAndDirection = [];



        /**
         * Get the columns with their directions
         *
         * @return string|null
         */
        public function getColumnAndDirection () : ?string
        {
            return $this->columnAndDirection;
        }



        /**
         * Set the columns with their directions
         *
         * @param  string|array $column
         * @param  string|null  $direction
         * @return void
         */
        public function setColumnAndDirection ($column, ?string $direction = self::ASC) : void
        {
            if (!is_array($column)) {
                $this->setColumn($column);
                $this->checkDirectionIsAllowed($direction);

                $this->columnAndDirectionAsArray[$this->column] = $this->direction;
            } else {
                if (array_key_exists(0, $column)) {
                    $this->columnAndDirectionAsArray = SyntaxHelpers::transformToArrayAssoc($column);
                } else {
                    $this->columnAndDirectionAsArray = $column;
                }
            }

            $this->columnAndDirection = $this->generateColumnAndDirection();
        }



        /**
         * Generate columns and direction from property $columnAndDirectionAsArray 
         *
         * @return void
         */
        private function generateColumnAndDirection ()
        {
            $items = [];

            foreach ($this->columnAndDirectionAsArray as $key => $value) {
                $this->checkDirectionIsAllowed($value);
                $items[] = "$key $value";
            }

            $columnAndDirection = implode(", ", $items);

            return $columnAndDirection;
        }



        /**
         * Check that a direction is allowed
         *
         * @param  string  $direction
         * @return void
         */
        private function checkDirectionIsAllowed ($direction) : void
        {
            $direction = strtoupper($direction);

            if (in_array($direction, self::ALLOWED_DIRECTION)) {
                $this->setDirection($direction);
            } else {
                throw new SyntaxOrderByException("The defined direction is unknown and is not allowed");
            }
        }



        /**
         * Set the column
         *
         * @param  string|array  $column
         * @return void
         */
        private function setColumn ($column) : void
        {
            $this->column = $column;
        }



        /**
         * Set the direction
         *
         * @param string $direction
         * @return void
         */
        private function setDirection (string $direction) : void
        {
            $this->direction = $direction;
        }
    }