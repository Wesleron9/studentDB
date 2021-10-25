<?php
//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

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
$name = filter_var(
    trim($data->name),
    FILTER_SANITIZE_STRING
);

//Валидация
if (mb_strlen($login) < 4 || mb_strlen($login) > 90) {
    systemError("Недопустимая длина логина (От 4 до 90 символов)");
    exit();
} else if (mb_strlen($passwd) < 8 || mb_strlen($login) > 32) {
    systemError("Недопустимая длина пароля (от 8 до 32 символов)");
    exit();
} else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    systemError("Недопустимая длина ФИО (от 3 до 50 символов)");
    exit();
}

//Добавляем соль к паролю и хешируем
$passwd = md5($passwd . "matveeva");

//Подключаемся к БД
require "connection-to-db.php";

//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `temp users` (`login`, `pass`, `name`) VALUES ('$login', '$passwd', '$name')");

//Закрываем соеденение с БД
$mysql->close();