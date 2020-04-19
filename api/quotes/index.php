<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET,POST,PUT, DELETE");
    header("Access-Control-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With");

    require_once "../../config/Database.php";
    require_once "../../models/Quote.php";
    require_once "../../models/HttpResponse.php";

    $db = new Database();
    $quote = new Quote($db);
    $http = new HttpResponse();

    if(!isset($_SESSION['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])){
        $http->notAuthorized("Access Denied. Authentication Needed");
        exit();
    } else {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $query = "SELECT * FROM users WHERE username=?";
        $result = $db->fetchOne($query, $username);
        if($result === 0 || $result['password'] !== $password){
            $http->notAuthorized("Wrong Details");
            exit();
        } else{
            $user_id = $result['id'];
        }
    }


    // Check incoming GET requests
    if($_SERVER['REQUET_METHOD'] === 'GET '){
        if(isset($_GET['id']) && !filter_var($_GET['id'], FILTER_VALIDATE_INT))
    }