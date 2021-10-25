<?php
include "response.php"; // Подключаем функции ответа
//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

//Стартуем сессию
session_start();

//Принимаем данные с фронта
$data = json_decode(file_get_contents("php://input"));
$login = filter_var(
    trim($data->login),
    FILTER_SANITIZE_STRING
);
$passwd = filter_var(
    trim($data->password),
    FILTER_SANITIZE_STRING
);

//Валидация
if ($login == "") {
    systemError("Введите логин");
    exit();
} else if ($passwd == "") {
    systemError("Введите пароль");
    exit();
}

//Добавляем соль к паролю и хешируем
$passwd = md5($passwd . "matveeva");

//Подключаемся к БД
require "connection-to-db.php";

//Проверяем есть ли пользователь в таблице временных пользователей
$result_temp = $mysql->query("SELECT `login`, `pass` FROM `temp users` WHERE  `login` = '$login' and `pass` = '$passwd'");
$user_temp = $result_temp->fetch_assoc();

//Проверяем есть ли пользователь в таблице основных пользователей
$result = $mysql->query("SELECT `login`, `pass`, `name`, `role`, `key`, `way to photo` FROM `users` WHERE  `login` = '$login' and `pass` = '$passwd'");
$user = $result->fetch_assoc();

//Если есть во временных пользователях
if (count($user_temp) <> 0) {
    systemError("Ожидайте подверждение вашей учетной записи");
    $mysql->close();
    exit();
} else if (count($user) == 0) { //Если нет в основных пользователях
    systemError("Неверный логин или пароль");
    $mysql->close();
    exit();
}

//После умпешной авторизации добавляем логин и ключ в сессию
$_SESSION['user name'] = $login;
$_SESSION["key"] = $user["key"];

//Узнаем роль пользователя
$role_result = $mysql->query("SELECT `role`, `role id` FROM `role` WHERE  `role id` = $user[role]");
$role = $role_result->fetch_assoc();

//Закрываем соеденение с БД
$mysql->close();

//Создаём массив для передачи на фронт, и передаём его как json объект
$user = ["name" => $user["name"], "role" => $role["role"], "photo" => $user['way to photo']];
systemResponse($user);