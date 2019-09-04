<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxColumnsException;


    /**
     * Manage columns to use in sql queries
     */
    class Columns 
    {
        /**
         * All the columns
         */
        const ALL = "*";



        /**
         * The columns to use
         *
         * @var string
         */
        private $columns = self::ALL;



        /**
         * Get the columns to use
         *
         * @return string
         */
        public function getColumns () : string
        {
            return $this->columns;
        }



        /**
         * Set which columns to use in SELECT type queries
         *
         * @param mixed ...$columns
         * @return void
         */
        public function setColumns (...$columns) : void
        {
            if (!empty($columns[0])) {
                $items = [];

                if (is_array($columns[0]) && !is_array($columns[0][0])) {
                    foreach ($columns[0] as $item) {
                        $items[] = $item;
                    }
                } else {
                    $items = $this->extractValuesInArray($columns, "AS");
                }

                $columns = implode(", ", $items);
            }

            $this->columns = empty($columns[0]) ? self::ALL : $columns;
        }



        /**
         * Set which columns to use in INSERT or UPDATE type queries
         *
         * @param array ...$columns
         * @return void
         */
        public function setColumnsWithClauseSET (...$columns) : void
        {
            $items = [];

            if (!empty($columns[0])) {
                if (is_array($columns[0][0])) {
                    $items = $this->extractValuesInArray($columns, "=");
                } else {
                    throw new SyntaxColumnsException("The columns method parameter must be an array");
                }
            } else {
                throw new SyntaxColumnsException("The parameter of the column method is not defined");
            }

            $columns = implode(", ", $items);
            $this->columns = "SET $columns";
        }



        /**
         * Extract the value of the parameters of a method
         *
         * @param  mixed  $columns
         * @param  string $separator  "=" or "AS"
         * @param  array  $items
         * @return void
         */
        public function extractValuesInArray ($columns, string $separator, array $items = []) 
        {
            $columns = $columns[0][0];

            if (is_array($columns) && array_key_exists(0, $columns)) {
                foreach ($columns as $item) {
                    $items[] = implode(" $separator ", $item);
                }
            } else {
                foreach ($columns as $key => $item) {
                    $items[] = "$key $separator $item";
                }
            }

            return $items;
        }
    }