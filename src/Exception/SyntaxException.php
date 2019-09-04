<?php

    namespace jeyofdev\Php\Query\Builder\Exception;


    use Exception;


    /**
     * Handle exceptions related to the syntax of the sql queries
     */
    final class SyntaxException extends Exception
    {
        public function __construct (string $method)
        {
            $this->message = "The method $method must be called";
        }
    }

