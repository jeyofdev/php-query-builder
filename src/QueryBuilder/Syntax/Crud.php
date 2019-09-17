<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxCrudException;
    use jeyofdev\Php\Query\Builder\Helpers\QueryBuilderHelpers;


    /**
     * Handle the crud of the sql queries
     */
    class Crud
    {
        /**
         * List of allowed values ​​for the crud
         */
        const CRUD_ALLOWED = ["INSERT INTO", "SELECT", "UPDATE", "DELETE"];
        const OPTIONS_SELECT = ["DISTINCT", "SQL_CACHE", "SQL_NO_CACHE"];



        /**
         * The value of the crud
         *
         * @var string
         */
        private $crud;



        /**
         * The options of the crud
         *
         * @var string
         */
        private $option;



        /**
         * Get the value of the crud
         *
         * @return string
         */
        public function getCrud () : string
        {
            return $this->crud;
        }



        /**
         * Set the value of the crud
         *
         * @param  string $crud  The value of the crud
         * @return void
         */
        public function setCrud (string $crud) : void
        {
            $crud = strtoupper($crud);

            if (QueryBuilderHelpers::checkStringIsInArray($crud, self::CRUD_ALLOWED)) {
                $this->crud = $crud;
            } else {
                throw new SyntaxCrudException("The value of the parameter of the crud method is not allowed");
            }
        }



        /**
         * Get the options of the crud
         *
         * @return string|null
         */
        public function getOption () : ?string
        {
            return $this->option;
        }



        /**
         * Set the options of the crud
         *
         * @param  array $options
         * @return void
         */
        public function setOption (...$options)
        {
            $options = $options[0][0];

            foreach ($options as $option) {
                $option = strtoupper($option);
                
                if ($this->crud === "SELECT") {
                    if (QueryBuilderHelpers::checkStringIsInArray($option, self::OPTIONS_SELECT)) {
                        if (is_null($this->option)) {
                            $this->option = $option;
                        } else {
                            $this->option .= " $option";
                        }
                    } else {
                        throw new SyntaxCrudException("The option in parameter of the crud is not allowed");
                    }
                }
            }
        }



        /**
         * Empty the crud and its options 
         *
         * @return void
         */
        public function empty () : void
        {
            $this->crud = null;
            $this->option = null;
        }
    }

