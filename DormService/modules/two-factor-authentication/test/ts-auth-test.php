<?php
session_start();
require_once('../GoogleAuthenticator.php');
require "../../../config/DB-Config.php";

$login = filter_var(
    trim($_POST['login']),
    FILTER_SANITIZE_STRING
);

$password = filter_var(
    trim($_POST['password']),
    FILTER_SANITIZE_STRING
);

$password = md5($password . "matveeva");
$result = $mysql->query("SELECT `secret` FROM `users` WHERE  `login` = '$login' and `pass` = '$password'");
$user = $result->fetch_assoc();
$secret = filter_var(
    trim($user['secret']),
    FILTER_SANITIZE_STRING
);
$mysql->close();
$_SESSION['sec'] = $secret;
if (count($user) != 0) {
    header('Location: http://test/modules/two-factor-authentication/test/code.html');
}

else{
    echo '<h1 style="color:#DC143C	;">Логин или пароль неверен</h1>';
    exit();
}