<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxWhereException;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\ComparisonOperators;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\LogicOperators;


    /**
     * Manage the condition of SQL queries
     */
    class Where
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
         * @return void
         */
        public function setCondition (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false) : void
        {
            $this->generateCondition($column, $value, $operator, $logicOperator, $logicOperatorNOT);
        }



        /**
         * Generate a condition
         *
         * @param  string      $column            The column of the table  
         * @param  string|int  $value             The parameter or the value of the condition
         * @param  string      $operator          The comparison operator used in the condition 
         * @param  string|null $logicOperator     The logic operator if necessary
         * @param  boolean     $logicOperatorNOT  The Logic Operator NOT if necessary
         * @return void
         */
        private function generateCondition (string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false) : void
        {
            if ($operator != null) {
                $this->comparisonOperators->checkComparisonOperatorIsAllowed($operator);

                $this->logicOperator->setLogicOperatorNOT($logicOperatorNOT);
                $not = $this->logicOperator->getLogicOperatorNOT();

                if ($this->condition === null) {
                    $this->condition = $this->addLogicOperatorNOT($column, $value, $operator, $not);
                } else {
                    if ($logicOperator != null) {
                        $this->logicOperator->setLogicOperator($logicOperator);
                        $logicOperator = $this->logicOperator->getLogicOperator();
                        
                        $this->condition .= " $logicOperator ";
                        $this->condition .= $this->addLogicOperatorNOT($column, $value, $operator, $not);
                    } else {
                        throw new SyntaxWhereException("The 4rd parameter of the where method is a logic operator that is not defined");
                    }
                }
            }
        }



        /**
         * Add the NOT logical operator in the condition
         *
         * @param  string      $column    The column of the table   
         * @param  string|int  $value     The parameter or the value of the condition
         * @param  string      $operator  The comparison operator used in the condition 
         * @param  string|null $not       The Logic Operator NOT 
         * @return string
         */
        private function addLogicOperatorNOT (string $column, $value, string $operator, ?string $logicOperatorNot = null) : string
        {
            $condition = ($logicOperatorNot != null) ? "$logicOperatorNot " : null; 
            $condition .= "$column $operator {$this->formatConditionParameter($value)}";

            return $condition;
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

