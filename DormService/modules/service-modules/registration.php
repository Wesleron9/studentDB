<?php
//Подключаемся к БД
require "../../config/DB-Config.php";
//Подключаем функции ответа
include 'response.php';
//Подключаем функции траслита
include 'translit.php';
//Подключаем двухфакторку
require_once('../two-factor-authentication/GoogleAuthenticator.php');
//Объявляем на какие данные расчитан этот скрипт
header("Content-Type: application/json");

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
// Валидация и приведение к стандарту
$tel_forming = substr($tel, 0, 2);
if ($tel_forming != '+7'){
    if ($tel_forming == '89'){
        $tel =substr($tel, 1);
        $tel = "+7".$tel;
        if (strlen($tel) != 12){
            systemMessage("Номер телефона введён неверно.");

            exit();
        }
    }
    else{
        systemMessage("Номер телефона введён неверно.");
        exit();
    }
}
elseif (strlen($tel) != 12){
    systemMessage("Номер телефона введён неверно.");
    exit();
}
else{
    echo $tel;
}
$email_val = preg_split('@', $email);
if (strpos($email, '@') === false || strpos($email_val[1], '.') === false) {
    systemMessage("Email введён неверно.");
}
//Проверяем есть ли пользователь с такой почтой
$validation_email = $mysql->query("SELECT `email` FROM `users` WHERE  `email` = '$email'");
$validation_email = $validation_email->fetch_assoc();
//Проверяем есть ли пользователь с таким номером телефона
$validation_tel = $mysql->query("SELECT `tel` FROM `users` WHERE  `tel` = '$tel'");
$validation_tel = $validation_tel->fetch_assoc();

if (mb_strlen($password) < 8 || mb_strlen($login) > 32) {
    systemMessage("Недопустимая длина пароля (от 8 до 32 символов)");
    $mysql->close();
    exit();
}
elseif (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    systemMessage("Недопустимая длина ФИО (от 3 до 50 символов)");
    $mysql->close();
    exit();
}
elseif (count($validation_email) != 0) {
    systemMessage("Email ".'"'.$email.'"'." уже зарегестрирован!");
    $mysql->close();
    exit();
}
elseif (count($validation_tel) != 0){
    systemMessage("Номер ".'"'.$tel.'"'." уже зарегестрирован!");
    $mysql->close();
    exit();
}
//Проверяем есть ли пользователь с такой почтой в ожидающих подтверждение
$validation_email = $mysql->query("SELECT `email` FROM `temp-users` WHERE  `email` = '$email'");
$validation_email = $validation_email->fetch_assoc();
//Проверяем есть ли пользователь с таким номером телефона в ожидающих подтверждение
$validation_tel = $mysql->query("SELECT `tel` FROM `temp-users` WHERE  `tel` = '$tel'");
$validation_tel = $validation_tel->fetch_assoc();
if (count($validation_email) != 0) {
    systemMessage("Email " . '"' . $email . '"' . " уже зарегестрирован!");
    $mysql->close();
    exit();
}
elseif (count($validation_tel) != 0) {
    systemMessage("Номер " . '"' . $tel . '"' . " уже зарегестрирован!");
    $mysql->close();
    exit();
}
// Функция создания логина
function forming_login ($num_surname, $num_name, $num_patronymic)
{
    global $name, $mysql;
    // Трансформируем ФИО в транслит
    $login_string = rus2translit($name);
// Разделяем ФИО
    $login = preg_split('#\s+#', $login_string);
    $login_surname = $login[0];
    $login_name = $login[1];
    $login_patronymic = $login[2];
// Сокращяем ФИО
    $login_surname = substr($login_surname, 0, $num_surname);
    $login_name = substr($login_name, 0, $num_name);
    $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
// Формируем логин
    $login = $login_surname . $login_name . $login_patronymic;
    $login = strtolower($login);
//  Проверяем есть ли такой логин в БД
    return ($login);
}
// Задаем длину логина
$num_surname = 7;
$num_name = 1;
$num_patronymic = 1;
// Формируем логин
$login = forming_login($num_surname, $num_name, $num_patronymic);
$login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
$login_DB_user = $login_DB_user->fetch_assoc();
if (count($login_DB_user) != 0) { // Если такой логин уже есть в таблице пользователей
    while (count($login_DB_user) != 0) { // Добавляем 1 букву фамилии
        $num_surname++;
        $login = forming_login($num_surname, $num_name, $num_patronymic);
        $login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
        $login_DB_user = $login_DB_user->fetch_assoc();
        if (count($login_DB_user) != 0) { // Если есть и такой то одну букву к имени
            $num_name++;
            $login = forming_login($num_surname, $num_name, $num_patronymic);
            $login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
            $login_DB_user = $login_DB_user->fetch_assoc();
            if (count($login_DB_user) != 0) { // Если есть и такой то одну букву к отчеству
                $num_patronymic++;
                $login = forming_login($num_surname, $num_name, $num_patronymic);
            }
        }
    }
}
//  Проверяем есть ли такой логин в таблице временных пользователей
$login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
$login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
if (count($login_DB_temp_users) != 0) { // Если есть
    while (count($login_DB_temp_users) != 0) { // Добавляем 1 букву фамилии
        $num_surname ++;
        $login = forming_login($num_surname, $num_name, $num_patronymic);
        $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
        $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
        if (count($login_DB_temp_users) != 0) { // Если есть и такой то одну букву к имени
            $num_name++;
            $login = forming_login($num_surname, $num_name, $num_patronymic);
            $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
            $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
            if (count($login_DB_temp_users) != 0) { // Если есть и такой то одну букву к отчеству
                $num_patronymic++;
                $login = forming_login($num_surname, $num_name, $num_patronymic);
                $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
                $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
            }
        }
    }
}
//Добавляем соль к паролю и хешируем
$password = md5($password . "matveeva");

//Создаём секрет
$secret=new GoogleAuthenticator;
$secret = $secret->generateSecret();
//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `temp-users` (`name`, `login`, `pass`, `tel`, `email`, `secret`) VALUES ('$name', '$login', '$password', '$tel', '$email', '$secret')");

//Закрываем соеденение с БД
$mysql->close();
// Выводим сообщение
systemMessage("Запрос на регистрацию был отправлен. Ожидайте подверждения.");
