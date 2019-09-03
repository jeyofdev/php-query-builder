<?php

    namespace jeyofdev\Php\Query\Builder\Exception;


    use Exception;


    /**
     * Handle exceptions related to the crud of the sql queries
     */
    final class SyntaxCrudException extends Exception
    {
        public function __construct ()
        {
            $this->message = "The value of the parameter of the crud method is not allowed";
        }
    }

