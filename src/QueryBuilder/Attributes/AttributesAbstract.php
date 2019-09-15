<?php

    namespace jeyofdev\Php\Query\Builder\QueryBuilder\Attributes;



    /**
     * Manage the PDO attributes values
     */
    abstract class AttributesAbstract
    {
        /**
         * List of allowed attributes
         */
        const ATTRIBUTES_ALLOWED = [
            "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
            "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION",
            "TIMEOUT", "DEFAULT_FETCH_MODE"
        ];



        /**
         * The allowed values ​​for the errmode attribute
         *
         * @var array
         */
        protected $ATTRIBUTES_ERRMODE_ALLOWED = [
            "SILENT", "WARNING", "EXCEPTION"
        ];



        /**
         * The allowed values ​​for the case attribute
         *
         * @var array
         */
        protected $ATTRIBUTES_CASE_ALLOWED = [
            "LOWER", "NATURAL", "UPPER"
        ];



        /**
         * The allowed values ​​for the fetch mode attribute
         *
         * @var array
         */
        protected $ATTRIBUTES_DEFAULT_FETCH_MODE_ALLOWED = [
            "FETCH_ASSOC", "FETCH_BOTH", "FETCH_CLASS", "FETCH_INTO", "FETCH_LAZY", 
            "FETCH_NAMED", "FETCH_NUM", "FETCH_OBJ", "FETCH_PROPS_LATE"
        ];
    }