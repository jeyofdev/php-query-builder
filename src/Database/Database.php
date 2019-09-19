<?php

    namespace jeyofdev\Php\Query\Builder\Database;


    /**
     * Manage a database
     */
    class Database extends AbstractConnection
    {
        /**
         * Create a database
         *
         * @param  string  $db_name  The name of the database
         * @return self
         */
        public function addDatabase (string $db_name) : self
        {
            $this->pdo = $this->getConnection();
            $this->db_name = $db_name;

            $query = "CREATE DATABASE IF NOT EXISTS " . $this->db_name . " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $this->pdo
                ->prepare($query)
                ->execute();

            return $this;
        }



        /**
         * Create a table in the database
         * 
         * @param  string  $query  The query to create a table
         * @return self
         */
        public function addTable (string $query) : self
        {
            $this->pdo = $this->getConnection($this->db_name);
            $this->pdo
                ->prepare($query)
                ->execute();

            return $this;
        }



        /**
         * Empty a table
         *
         * @param  string  $tableName  The name of the table
         * @return self
         */
        public function clear (string $tableName) : self
        {
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $this->pdo->exec("TRUNCATE TABLE {$this->getTableName($tableName)}");
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
            
            return $this;
        }



        /**
         * Get the name of a table
         *
         * @param $tableName
         * @return string
         */
        public function getTableName (string $tableName) : string
        {
            return $tableName;
        }



        /**
         * Get the connection PDO
         *
         * @return void
         */
        public function getDatabase () : void
        {
            $this->pdo = $this->getConnection($this->db_name);
        }
    }

