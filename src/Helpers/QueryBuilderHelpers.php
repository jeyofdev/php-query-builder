<?php

    namespace jeyofdev\Php\Query\Builder\Helpers;


    /**
     * Set the helpers for the query builder
     */
    class QueryBuilderHelpers
    {
        /**
         * Check that a value is contained in an array
         *
         * @param  string $value
         * @param  array $datasAllowed
         * @return boolean
         */
        public static function checkStringIsInArray (string $value, array $datasAllowed) : bool
        {
            if (!in_array($value, $datasAllowed)) {
                return false;
            }

            return true;
        }



        /**
         * Edit an array to an associative array
         *
         * @param  array $datas 
         * @return array
         */
        public static function transformToArrayAssoc (array $datas) : array
        {
            $items = [];

            foreach ($datas as $data) {
                foreach ($data as $key => $item) {
                    $items[$key] = $item;
                }
            }
            $newArray = $items;

            return $newArray;
        }
    }

