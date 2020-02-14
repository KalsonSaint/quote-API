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
        public function executeCall($username, $calls_allowed, $timeoutSecs) {
            $query ="SELECT plan, calls_made, time_start, time_end FROM users WHERE username = '$username'";
            $stmt=$this->pdo->prepare($query);
            $stmt->execute([$username]);
            $result = $stmt->fetch();

            $timeOut = date(time()) - $result['time_start'] >= $timeOutSeconds || $result['time_start'] === 0;

            // update calls made in respect to timeout
            $query = "UPDATE users SET calls_made";
            $query .= $timeOut ? " 1, time_start = ".date(time()). " , time_end = ".strtotime("+ $timeOutSeconds seconds"): " calls_made + 1";
            $query .= "WHERE username = ?";

            $result['call_made'] = $timeOut ? 1 : $calls_made + 1;
            $result['time_end'] = $timeOut ? strtotime(" + $timeOutSeconds seconds") : $result['time_end'];

            // validate users subscription(plans)
            if($result['plan'] === 'unlimited'){
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$username]);
                return  $result;
            } else{
                if($timeOut === false && $result['calls_made'] >= $calls_allowed){
                    return -1;
                } else{
                    // grant access
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([$username]);
                    return $results;
                }
            }
        }

        // Method handles POST request
        public function insertOne($query, $body, $user_id, $category_id, $date){
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$body, $category_id, $date, $id]);
        }

        // Method handles PUT request
        public function insertUser($query, $firstName, $lastName, $password, $username){
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$firstName, $lastName, $password, $username]);
        }

        // Method handles PUT request
        public function updateOne($query, $body, $category_id, $date, $id){
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$body, $category_id, $date, $id]);
        }

        // Method handles DELETE request
        public function deleteOne($query, $id){
            $stmt = $this->pdo->prepapre($query);
            $stmt->execute([$id]);
        }
    }



?>