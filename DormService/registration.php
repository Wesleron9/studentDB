<?php
include 'response.php';
//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

//Принимаем данные с фронта
$data = json_decode(file_get_contents("php://input"));
$login = filter_var(
    trim($data->login),
    FILTER_SANITIZE_STRING
);
$password = filter_var(
    trim($data->password),
    FILTER_SANITIZE_STRING
);
$name = filter_var(
    trim($data->name),
    FILTER_SANITIZE_STRING
);

$email = filter_var(
    trim($data->email),
    FILTER_SANITIZE_STRING
);
$tel = filter_var(
    trim($data->tel),
    FILTER_SANITIZE_STRING
);

//Валидация
if (mb_strlen($login) < 4 || mb_strlen($login) > 90) {
    systemMessage("Недопустимая длина логина (От 4 до 90 символов)");
    exit();
}
elseif (mb_strlen($password) < 8 || mb_strlen($login) > 32) {
    systemMessage("Недопустимая длина пароля (от 8 до 32 символов)");
    exit();
}
elseif (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    systemMessage("Недопустимая длина ФИО (от 3 до 50 символов)");
    exit();
}

//Добавляем соль к паролю и хешируем
$password = md5($password . "matveeva");

//Подключаемся к БД
require "DB-Config.php";

//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `temp-users` (`name`, `login`, `pass`, `tel`, `email`) VALUES ('$name', '$login', '$password', '$tel', '$email')");

//Закрываем соеденение с БД
$mysql->close();

systemMessage("Запрос на регистрацию был отправлен. Ожидайте подверждения.");
