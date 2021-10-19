<?php
session_start();
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));
$login = filter_var(trim($data->login),
    FILTER_SANITIZE_STRING);
$modules = filter_var(trim($data->modules),
    FILTER_SANITIZE_STRING);
if ($_SESSION['user name']<>$login)
    echo 'Ошибка авторизации';
    else{
        require "../../connection-to-db.php";

        $result = $mysql->query("SELECT `access level` FROM `users` WHERE  `login` = '$_SESSION[login]'");
        $access_user  =$result->fetch_assoc();
        $result = $mysql->query("SELECT `access level`, `wey`  FROM `modeules` WHERE  `name` = '$modules'");
        $access_user  =$result->fetch_assoc();
    }
