<?php

    class Database {

        // Class Variables
        private $host_name = "localhost";
        private $db_name = "quote_api";
        private $username = "root";
        private $password = "";
        private $pdo;

        // start database connection
        public function __construct() {
            $this->pdo = null;
            $dsn = 'mysql:host='.$this->host_name.';dbname='.$this->db_name;
            try {
                $this->pdo = new PDO($dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){
                echo "Error: ".$e->getMessage();
            }
        }

        // Method fetches everything included in the query parameter
        public function fetchAll($query){
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $row=$stmt->rowCount();
            if($row<=0){
                return 0;
            } else{
                return $stmt->fetchAll();
            }
        }

        // Method fetches only one result
        public function fetchOne($query, $param) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([param]);
            $row = $stmt->rowCount();
            if($row<=0){
                return 0;
            } else{
                return $stmt->fetch();
            }
        }

        // Method keeps track of  Calls made to the API
        public function executeCall($username,$call_allowed,$timeoutSecs) {
            $query ="   
                        SELECT plan, calls_made, time_start, time_end
                        FROM users
                        WHERE username = '$username'
                    ";
            $stmt=$this->pdo->prepare($query);
            $stmt->execute([$username]);
            $result = $stmt->fetch();

            $timeOut = date(time()) - $result['time_start'] >= $timeOutSeconds || $result['time_start'] === 0;

            // update calls made in respect to timeout
            $query ="
                        UPDATE users
                        SET calls_made
                    ";
            $query .= $timeout ?
        }

    }



?>