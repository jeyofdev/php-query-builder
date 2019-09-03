<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Syntax;


    use jeyofdev\Php\Query\Builder\Exception\SyntaxCrudException;
    use jeyofdev\Php\Query\Builder\Helpers\SyntaxHelpers;


    /**
     * Handle the crud of the sql queries
     */
    class Crud
    {
        /**
         * List of allowed values ​​for the crud
         */
        const CRUD_ALLOWED = ["INSERT INTO", "SELECT", "UPDATE", "DELETE"];



        /**
         * The value of the crud
         *
         * @var string
         */
        private $crud;



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

            if (SyntaxHelpers::checkStringIsInArray($crud, self::CRUD_ALLOWED)) {
                $this->crud = $crud;
            } else {
                throw new SyntaxCrudException();
            }
        }
    }

