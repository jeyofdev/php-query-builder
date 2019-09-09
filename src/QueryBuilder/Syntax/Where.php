<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxWhereException;
    use jeyofdev\Php\Query\Builder\Helpers\SyntaxHelpers;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\ComparisonOperators;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\LogicOperators;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\Operators;


    /**
     * Manage the condition of SQL queries
     */
    class Where extends Operators
    {
        /**
         * @var ComparisonOperators
         */
        private $comparisonOperators;



        /**
         * @var LogicOperators
         */
        private $logicOperator;



        /**
         * The condition
         *
         * @var string
         */
        private $condition;



        public function __construct() 
        {
            $this->comparisonOperators = new ComparisonOperators();
            $this->logicOperator = new LogicOperators();
        }



        /**
         * Get the condition
         *
         * @return string|null
         */
        public function getCondition () : ?string
        {
            return $this->condition;
        }



        /**
         * Set the condition
         *
         * @param  string      $column            The column of the table  
         * @param  string|int  $value             The parameter or the value of the condition
         * @param  string      $operator          The comparison operator used in the condition 
         * @param  string|null $logicOperator     The logic operator if necessary
         * @param  boolean     $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean     $begin             Activate the opening parenthesis
         * @param  boolean     $end               Activate the closing parenthesis       
         * @return void
         */
        public function setCondition (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            $this->generateCondition($column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
        }



        /**
         * Generate a condition
         *
         * @param  string            $column            The column of the table  
         * @param  string|int|array  $value             The parameter or the value of the condition
         * @param  string            $operator          The comparison operator used in the condition 
         * @param  string|null       $logicOperator     The logic operator if necessary
         * @param  boolean           $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean           $begin             Activate the opening parenthesis
         * @param  boolean           $end               Activate the closing parenthesis       
         * @return void
         */
        private function generateCondition (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            if ($operator != null) {
                if (!SyntaxHelpers::checkStringIsInArray($operator, self::COMPARISON_OPERATOR)) {
                    if (!SyntaxHelpers::checkStringIsInArray($operator, self::LOGIC_OPERATOR)) {
                        throw new SyntaxWhereException("The 3rd parameter of the where method is an operator that is not allowed");
                    }
                }

                if (is_array($value)) {
                    if ($operator !== self::LOGIC_BETWEEN) {
                        $items = implode(", ", $value);
                        $value = "($items)";
                    }
                }

                if (is_string($value)) {
                    if ($operator === self::LOGIC_LIKE) {
                        if (!preg_match('/([%_])/', $value)){  
                            throw new SyntaxWhereException("The value of the 2nd parameter of the where method does not match a search");
                        }
                    }
                }

                $this->logicOperator->setLogicOperatorNOT($logicOperatorNOT);
                $not = $this->logicOperator->getLogicOperatorNOT();

                if ($this->condition === null) {
                    $this->condition = $this->addLogicOperatorNOT($column, $value, $operator, $not);
                } else {
                    if ($logicOperator != null) {
                        $this->logicOperator->setLogicOperator($logicOperator);
                        $logicOperator = $this->logicOperator->getLogicOperator();

                        $this->condition .= " $logicOperator ";
                        $this->condition .= $begin ? "(" : null;
                        $this->condition .= $this->addLogicOperatorNOT($column, $value, $operator, $not);
                        $this->condition .= $end ? ")" : null;
                    } else {
                        throw new SyntaxWhereException("The 4rd parameter of the where method is a logic operator that is not defined");
                    }
                }
            }
        }



        /**
         * Add the NOT logical operator in the condition
         *
         * @param  string            $column            The column of the table   
         * @param  string|int|array  $value             The parameter or the value of the condition
         * @param  string            $operator          The comparison operator used in the condition 
         * @param  string|null       $logicOperatorNot  The Logic Operator NOT 
         * @return string
         */
        private function addLogicOperatorNOT (string $column, $value, string $operator, ?string $logicOperatorNot = null) : string
        {
            $condition = ($logicOperatorNot != null) ? "$logicOperatorNot " : null; 

            if ($this->checkConditionOptionExist($operator, self::LOGIC_IN)) {
                $condition .= "$column $operator $value";
            } else if (($this->checkConditionOptionExist($operator, self::LOGIC_IS_NULL)) || ($this->checkConditionOptionExist($operator, self::LOGIC_IS_NOT_NULL))) {
                $condition .= "$column $operator";
            } else if ($this->checkConditionOptionExist($operator, self::LOGIC_BETWEEN)) {
                $value = implode(" AND ", $value);
                $condition .= "$column $operator $value";
            } else {
                $condition .= "$column $operator {$this->formatConditionParameter($value)}";
            }

            return $condition;
        }


        
        /**
         * Check that the condition has an allowed option
         *
         * @param  string  $operator  The comparison operator used in the condition 
         * @param  string  $option    The logic operator who serves as an option to the condition
         * @return boolean
         */
        private function checkConditionOptionExist (string $operator, string $option) : bool
        {
            $exist = ($operator === $option) ? true  : false;
            return $exist;
        }



        /**
         * Format the parameter ot the value of the condition
         *
         * @param  string|int $value  The parameter or the value of the condition
         * @return string
         */
        private function formatConditionParameter ($value) : string
        {
            if(is_string($value)){
                if (substr($value, 0, 1) != ":") {
                    $value = $value = "'$value'";
                }
            }

            return $value;
        }
    }

