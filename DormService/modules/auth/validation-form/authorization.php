<?php
session_start();
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));
$login = filter_var(trim($data->login),
    FILTER_SANITIZE_STRING);
$passwd = filter_var(trim($data->password),
    FILTER_SANITIZE_STRING);

$passwd = md5($passwd."matveeva");

require "../../../connection-to-db.php";

$result = $mysql->query("SELECT `login`, `pass`, `name`, `role`, `key`, `way to photo` FROM `users` WHERE  `login` = '$login' and `pass` = '$passwd'");
$user =$result->fetch_assoc();
if(count($user) ==0){
    echo "Неверный логин или пароль";
    exit();
    
}

$_SESSION['user name'] = $login;
$_SESSION[key] = $user[key];
$role_result = $mysql->query("SELECT `role`, `role id` FROM `role` WHERE  `role id` = $user[role]");
    $role =$role_result->fetch_assoc();
$mysql->close();

$user = [name=> $user[name], role=> $role[role], photo=> $user['way to photo']];
$json = json_encode($user, JSON_UNESCAPED_UNICODE);
print_r($json);
?>