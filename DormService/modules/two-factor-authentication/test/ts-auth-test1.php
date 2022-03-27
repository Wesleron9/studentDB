<?php
session_start();
require_once('../GoogleAuthenticator.php');
require "../../../config/DB-Config.php";

$code = filter_var(
    trim($_POST['code']),
    FILTER_SANITIZE_STRING
);
$secret = $_SESSION['sec'];
$ga=new PHPGangsta_GoogleAuthenticator;
$check_code =$ga->verifyCode($secret, $code, 2);
if ($check_code) {
    echo '<h1 style="color:#00FF00;">ЮХУ! Успешная авторизация</h1>';
    exit();
}
else {
    echo '<h1 style="color:#DC143C;">Код неверен</h1>';
    exit();
}