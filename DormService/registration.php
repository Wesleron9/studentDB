<?php
include 'response.php';
//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

include 'translit.php';

//Принимаем данные с фронта
$data = json_decode(file_get_contents("php://input"));

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
if (mb_strlen($password) < 8 || mb_strlen($login) > 32) {
    systemMessage("Недопустимая длина пароля (от 8 до 32 символов)");
    exit();
}
elseif (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    systemMessage("Недопустимая длина ФИО (от 3 до 50 символов)");
    exit();
}
systemMessage($data);
// Трансформируем ФИО в транслит
$login_string = rus2translit($name);
// Разделяем ФИО
$login = preg_split('#\s+#', $login_string);
$login_surname = $login[0];
$login_name = $login[1];
$login_patronymic = $login[2];
// Формируем логин
$login_surname = substr($login_surname, 0, 7);
$login_name = substr($login_name, 0, 1);
$login_patronymic = substr($login_patronymic, 0, 1);
$login = $login_surname.$login_name.$login_patronymic;
$login = strtolower($login);

//Добавляем соль к паролю и хешируем
$password = md5($password . "matveeva");

//Подключаемся к БД
require "DB-Config.php";

//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `temp-users` (`name`, `login`, `pass`, `tel`, `email`) VALUES ('$name', '$login', '$password', '$tel', '$email')");

//Закрываем соеденение с БД
$mysql->close();

systemMessage("Запрос на регистрацию был отправлен. Ожидайте подверждения.");
