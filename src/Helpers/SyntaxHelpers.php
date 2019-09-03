<?php

    namespace jeyofdev\Php\Query\Builder\Helpers;


    /**
     * Defines the helpers for the sql queries
     */
    class SyntaxHelpers
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
    }

