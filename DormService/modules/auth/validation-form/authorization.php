<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));
$login = filter_var(trim($data->login),
    FILTER_SANITIZE_STRING);
$passwd = filter_var(trim($data->password),
    FILTER_SANITIZE_STRING);

$passwd = md5($passwd."matveeva");

require "connection-db.php";

$result = $mysql->query("SELECT `login`, `pass`, `name` FROM `users` WHERE  `login` = '$login' and `pass` = '$passwd'");
$user =$result->fetch_assoc();
if(count($user) ==0){
    echo "Неверный логин или пароль";
    exit();
}

setcookie('user', $user['name'], time() + 3600 * 24, "/");

$mysql->close();
echo "Вы автаризованы"
?>