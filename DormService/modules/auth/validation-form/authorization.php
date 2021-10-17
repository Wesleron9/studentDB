<?php
$login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
$passwd = filter_var(trim($_POST['password']),
    FILTER_SANITIZE_STRING);

$passwd = md5($passwd."matveeva");

include "connection-to-db.php";

$result = $mysql->query("SELECT `login`, `pass`, `name` FROM `users` WHERE  `login` = '$login' and `pass` = '$passwd'");
$user =$result->fetch_assoc();
if(count($user) ==0){
    echo "Неверный логин или пароль";
    exit();
}

setcookie('user', $user['name'], time() + 3600 * 24, "/");

$mysql->close();
header('location: /');
?>