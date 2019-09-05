<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Operators;


    use jeyofdev\Php\Query\Builder\Exception\Operators\ComparisonOperatorsException;


    /**
     * Manage the comparison operators
     */
    class ComparisonOperators extends Operators
    {
        /**
         * Check that the comparison operator used in a condition of an SQL query is allowed
         *
         * @param  string  $operator 
         * @return boolean|null
         */
        public function checkComparisonOperatorIsAllowed (string $operator) : ?bool
        {
            if (!in_array($operator, self::COMPARISON_OPERATOR)) {
                throw new ComparisonOperatorsException("The 3rd parameter of the where method is a comparison operator that is not allowed");
            }

            return true;
        }
    }
