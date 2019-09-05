<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Operators;


    use jeyofdev\Php\Query\Builder\Exception\Operators\LogicOperatorsException;


    /**
     * Manage the comparison operators
     */
    class LogicOperators extends Operators
    {
        /**
         * The logic operator of the current condition
         *
         * @var string
         */
        private $logicOperator;



        /**
         * The Logic Operator NOT 
         *
         * @var string
         */
        private $logicOperatorNOT;



        /**
         * Get the logic operator
         *
         * @return string
         */
        public function getLogicOperator () : string
        {
            return $this->logicOperator;
        }



        /**
         * Set the logic operator
         *
         * @param  string  $logicOperator
         * @return void
         */
        public function setLogicOperator (string $logicOperator) : void
        {
            $logicOperator = strtoupper($logicOperator);
            
            if (in_array($logicOperator, $this::LOGIC_OPERATOR)) {
                $this->logicOperator = $logicOperator;
            } else {
                throw new LogicOperatorsException("The 4rd parameter of the where method is a logic operator that is not allowed");
            }
        }



        /**
         * Get the Logic Operator NOT 
         *
         * @return string|null
         */
        public function getLogicOperatorNOT () : ?string
        {
            return $this->logicOperatorNOT;
        }



        /**
         * Set the Logic Operator NOT 
         *
         * @param  string  $logicOperatorNOT
         * @return void
         */
        public function setLogicOperatorNOT (bool $logicOperatorNOT = false) : void
        {
            if ($logicOperatorNOT) {
                $this->logicOperatorNOT = $this::LOGIC_NOT;
            } else {
                $this->logicOperatorNOT = null;
            }
        }
    }
