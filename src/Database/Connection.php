<?php

    namespace jeyofdev\Php\Query\Builder\Database;


    use PDO;
    use PDOException;


    /**
     * Manage the PDO connection
     */
    abstract class Connection
    {
        /**
         * PDO parameters
         *
         * @var string
         */
        protected $db_host;
        protected $db_user;
        protected $db_password;
        protected $db_name;


        /**
         * PDO options
         */
        const PDO_OPTIONS = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];


        /**
         * The connexion PDO
         *
         * @var PDO
         */
        protected $pdo;


        /**
         * @param string      $db_host
         * @param string      $db_user      
         * @param string      $db_password
         * @param string|null $db_name
         */
        public function __construct(string $db_host, string $db_user, string $db_password, ?string $db_name = null)
        {
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_password = $db_password;
            $this->db_name = $db_name;
        }


        /**
         * Get the connection PDO
         *
         * @param  string|null $db_name  The name of the database
         * @return PDO
         */
        public function getConnexion(?string $db_name = null) : PDO
        {
            try {
                if (!is_null($this->setPDO($db_name))) {
                    $this->db_name = $db_name;
                    $this->setPDO($db_name);
                }
            }
            catch(PDOException $e){
                throw new PDOException("the connection failed, the error returned is : " . $e->getMessage());
            }
            
            return $this->pdo;
        }



        /**
         * Set the connection PDO
         *
         * @param  string|null $db_name  The name of the database
         * @return void
         */
        public function setPDO (?string $db_name = null) : void
        {
            if ($db_name === null) {
                $this->pdo = new PDO("mysql:host=" . $this->db_host, $this->db_user, $this->db_password , self::PDO_OPTIONS);
            } else {
                $this->db_name = $db_name;
                $this->pdo = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";", $this->db_user, $this->db_password , self::PDO_OPTIONS);
            }
        }
    }
    