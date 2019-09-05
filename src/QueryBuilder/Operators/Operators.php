<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Operators;


    /**
     * Manage the operators
     */
    class Operators
    {
        const EQUAL = "=";
        const GREATER_THAN = ">";
        const LESS_THAN = "<";
        const GREATER_THAN_OR_EQUAL = ">=";
        const LESS_THAN_OR_EQUAL = "<=";
        const NOT_EQUAL_SYNTAX_A = "!=";
        const NOT_EQUAL_SYNTAX_B = "<>";

        const LOGIC_AND = "AND";
        const LOGIC_OR = "OR";
        
        const LOGIC_NOT = "NOT";



        /**
         * The allowed comparison operators
         */
        const COMPARISON_OPERATOR = [
            self::EQUAL, 
            self::GREATER_THAN, 
            self::LESS_THAN, 
            self::GREATER_THAN_OR_EQUAL, 
            self::LESS_THAN_OR_EQUAL, 
            self::NOT_EQUAL_SYNTAX_A,
            self::NOT_EQUAL_SYNTAX_B
        ];



        /**
         * The allowed logic operators
         */
        const LOGIC_OPERATOR = [
            self::LOGIC_AND, 
            self::LOGIC_OR
        ];
    }
