<?php

    namespace jeyofdev\Php\Query\Builder\Database;


    /**
     * Manage a database
     */
    class Database extends Connection
    {
        /**
         * Create a database
         *
         * @param  string  $db_name  The name of the database
         * @return self
         */
        public function addDatabase (string $db_name) : self
        {
            $this->pdo = $this->getConnexion();
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
            $this->pdo = $this->getConnexion($this->db_name);
            $this->pdo
                ->prepare($query)
                ->execute();

            return $this;
        }
    }

