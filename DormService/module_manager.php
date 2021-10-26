<?php
include "response.php";// Подключаем функции ответа

//Подключаемся к БД
require "connection-to-db.php";

//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

//Стартуем сессию
session_start();

//Принимаем данные с фронта
$data = json_decode(file_get_contents("php://input"));
$function = filter_var(
    trim($data->function),
    FILTER_SANITIZE_STRING
);
$module = filter_var(
    trim($data->module),
    FILTER_SANITIZE_STRING
);

//$user = $_SESSION['user name'];
$user = 'root';
//if ($function = "menu"){
    $result = $mysql->query("SELECT `module`, `module name` FROM `mudels-user` WHERE  `login` = '$user'");
    while ($menu = $result->fetch_assoc()){
        echo "Пункты меню: ".$menu['module'].'<br>';
    }

//}
//elseif ($function ="module"){
//
//}
//elseif ($function = "access"){
//
//}
print_r($menu);
$mysql->close();