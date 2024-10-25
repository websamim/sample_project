<?php
    //START SESSION
    session_start();

    class Database {  
        //HOST NAME
        private $host = "localhost";
        //DATABASE NAME
        private $db_name = "finance";
        //USERNAME
        private $username = "root";
        //PASSWORD
        private $password = "";
        // SMTP USEERNAME
        public $smtpUsername = "example@gmail.com";
        public $smtpPassword = "emailpassword";
        public $companyName = "The Finance";

        private $conn;
        //LOGIN SESSION NAME
        private $sessionName = 'user_id';
        //DATABASE CONNECTION WITH UTF-8 ENCODE
        public function dbConnection() {

            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );

            $this->conn = null;    

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $options);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            } 
            return $this->conn;
        }
        
        // SESSION NAME
        public function session_name() {
            return $this->sessionName;
        }
    } //END CLASS DATABASE

?>