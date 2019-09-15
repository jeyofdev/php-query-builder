<?php
    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxHavingException;
    use jeyofdev\Php\Query\Builder\Helpers\QueryBuilderHelpers;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Syntax\FunctionsSql\AggregateFunctionSql;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\ComparisonOperators;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\LogicOperators;
    use jeyofdev\Php\Query\Builder\QueryBuilder\Operators\Operators;


    /**
     * Manage the "HAVING" command of SQL queries
     */
    class Having extends Operators
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
         * @var AggregateFunctionSql
         */
        private $aggregateFunctionSql;



        /**
         * The having clause
         *
         * @var string
         */
        private $having;



        /**
         * @param AggregateFunctionSql $aggregateFunctionSql
         */
        public function __construct (AggregateFunctionSql $aggregateFunctionSql)
        {
            $this->comparisonOperators = new ComparisonOperators();
            $this->logicOperator = new LogicOperators();
            $this->aggregateFunctionSql = $aggregateFunctionSql;
        }



        /**
         * Get the HAVING clause
         *
         * @return string|null
         */
        public function getHaving () : ?string
        {
            return $this->having;
        }



        /**
         * Set the HAVING clause
         *
         * @param  string           $functionSql       The sql function
         * @param  string           $column            The column of the table  
         * @param  string|int|array  $value             The parameter or the value of the having clause
         * @param  string           $operator          The comparison operator used in the having clause
         * @param  string|null      $logicOperator     The logic operator if necessary
         * @param  boolean          $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean          $begin             Activate the opening parenthesis
         * @param  boolean          $end               Activate the closing parenthesis       
         * @return void
         */
        public function setHaving (string $functionSql, string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            $this->generateHaving($functionSql, $column, $value, $operator, $logicOperator, $logicOperatorNOT, $begin, $end);
        }



        /**
         * Generate the HAVING clause
         *
         * @param  string            $functionSql       The sql function
         * @param  string            $column            The column of the table  
         * @param  string|int|array  $value             The parameter or the value of the having clause
         * @param  string            $operator          The comparison operator used in the having clause
         * @param  string|null       $logicOperator     The logic operator if necessary
         * @param  boolean           $logicOperatorNOT  The Logic Operator NOT if necessary
         * @param  boolean           $begin             Activate the opening parenthesis
         * @param  boolean           $end               Activate the closing parenthesis       
         * @return void
         */
        private function generateHaving (string $functionSql, string $column, $value, string $operator, ?string $logicOperator = null, bool $logicOperatorNOT = false, bool $begin = false, bool $end = false) : void
        {
            $functionSql = strtoupper($functionSql);
            if ($operator != null) {
                if (!QueryBuilderHelpers::checkStringIsInArray($operator, self::COMPARISON_OPERATOR)) {
                    if (!QueryBuilderHelpers::checkStringIsInArray($operator, self::LOGIC_OPERATOR)) {
                        throw new SyntaxHavingException("The 4th parameter of the having method is an operator that is not allowed");
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
                            throw new SyntaxHavingException("The value of the 3rd parameter of the having method does not match a search");
                        }
                    }
                }

                $this->logicOperator->setLogicOperatorNOT($logicOperatorNOT);
                $not = $this->logicOperator->getLogicOperatorNOT();

                if ($this->having === null) {
                    $this->having = $this->addLogicOperatorNOT($functionSql, $column, $value, $operator, $not);
                } else {
                    if ($logicOperator != null) {
                        $this->logicOperator->setLogicOperator($logicOperator);
                        $logicOperator = $this->logicOperator->getLogicOperator();

                        $this->having .= " $logicOperator ";
                        $this->having .= $begin ? "(" : null;
                        $this->having .= $this->addLogicOperatorNOT($functionSql, $column, $value, $operator, $not);
                        $this->having .= $end ? ")" : null;
                    } else {
                        throw new SyntaxHavingException("The 5th parameter of the having method is a logic operator that is not defined");
                    }
                }
            }
        }



        /**
         * Add the NOT logical operator in the HAVING clause
         *
         * @param  string            $functionSql       The sql function
         * @param  string            $column            The column of the table   
         * @param  string|int|array  $value             The parameter or the value of the having clause
         * @param  string            $operator          The comparison operator used in the having clause
         * @param  string|null       $logicOperatorNot  The Logic Operator NOT 
         * @return string
         */
        private function addLogicOperatorNOT (string $functionSql, string $column, $value, string $operator, ?string $logicOperatorNot = null) : string
        {
            $having = ($logicOperatorNot != null) ? "$logicOperatorNot " : null; 

            if ($this->checkHavingOptionExist($operator, self::LOGIC_IN)) {
                $having .= "$functionSql($column) $operator $value";
            } else if (($this->checkHavingOptionExist($operator, self::LOGIC_IS_NULL)) || ($this->checkHavingOptionExist($operator, self::LOGIC_IS_NOT_NULL))) {
                $having .= "$functionSql($column) $operator";
            } else if ($this->checkHavingOptionExist($operator, self::LOGIC_BETWEEN)) {
                $value = implode(" AND ", $value);
                $having .= "$functionSql($column) $operator $value";
            } else {
                $having .= "$functionSql($column) $operator {$this->formatHavingParameter($value)}";
            }

            return $having;
        }



        /**
         * Check that the having clause has an allowed option
         *
         * @param  string  $operator  The comparison operator used in the having clause
         * @param  string  $option    The logic operator who serves as an option to the having clause
         * @return boolean
         */
        private function checkHavingOptionExist (string $operator, string $option) : bool
        {
            $exist = ($operator === $option) ? true  : false;
            return $exist;
        }



        /**
         * Format the parameter ot the value of the having clause
         *
         * @param  string|int $value  The parameter or the value of the having clause
         * @return string
         */
        private function formatHavingParameter ($value) : string
        {
            if(is_string($value)){
                if (substr($value, 0, 1) != ":") {
                    $value = $value = "'$value'";
                }
            }

            return $value;
        }
    }