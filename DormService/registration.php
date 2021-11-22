<?php
//Подключаемся к БД
require "DB-Config.php";
include 'response.php';
include 'translit.php';
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
$email_DB = $mysql->query("SELECT `Email` FROM `users` WHERE  `Email` = '$email'");
$email_DB = $email_DB->fetch_assoc();
//Валидация
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
elseif (count($email_DB) != 0) {
    systemMessage("Пользователь с таким Email уже зарегестрирован!");
    $mysql->close();
    exit();
}
// Трансформируем ФИО в транслит
$login_string = rus2translit($name);
// Разделяем ФИО
$login = preg_split('#\s+#', $login_string);
$login_surname = $login[0];
$login_name = $login[1];
$login_patronymic = $login[2];
// Формируем логин
$num_surname = 7;
$num_name = 1;
$num_patronymic = 1;
$login_surname = substr($login_surname, 0, $num_surname);
$login_name = substr($login_name, 0, $num_name);
$login_patronymic = substr($login_patronymic, 0, $num_patronymic);
$login = $login_surname.$login_name.$login_patronymic;
$login = strtolower($login);
$login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
$login_DB_user = $login_DB_user->fetch_assoc();
if (count($login_DB_user) != 0) {
    while (count($login_DB_user) != 0) {
        $login_string = rus2translit($name);
        $login = preg_split('#\s+#', $login_string);
        $login_surname = $login[0];
        $login_name = $login[1];
        $login_patronymic = $login[2];
        $num_surname++;
        $login_surname = substr($login_surname, 0, $num_surname);
        $login_name = substr($login_name, 0, $num_name);
        $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
        $login = $login_surname . $login_name . $login_patronymic;
        $login = strtolower($login);
        print_r($login);
        $login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
        $login_DB_user = $login_DB_user->fetch_assoc();
        if (count($login_DB_user) != 0) {
            $login_string = rus2translit($name);
            $login = preg_split('#\s+#', $login_string);
            $login_name = $login[0];
            $login_name = $login[1];
            $login_patronymic = $login[2];
            $num_name++;
            $login_surname = substr($login_surname, 0, $num_surname);
            $login_name = substr($login_name, 0, $num_name);
            $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
            $login = $login_surname . $login_name . $login_patronymic;
            $login = strtolower($login);
            print_r($login);
            $login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
            $login_DB_user = $login_DB_user->fetch_assoc();
            if (count($login_DB_user) != 0) {
                $login_string = rus2translit($name);
                $login = preg_split('#\s+#', $login_string);
                $login_name = $login[0];
                $login_name = $login[1];
                $login_patronymic = $login[2];
                $num_patronymic++;
                $login_surname = substr($login_surname, 0, $num_surname);
                $login_name = substr($login_name, 0, $num_name);
                $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
                $login = $login_surname . $login_name . $login_patronymic;
                $login = strtolower($login);
                print_r($login);
                $login_DB_user = $mysql->query("SELECT `login` FROM `users` WHERE  `login` = '$login'");
                $login_DB_user = $login_DB_user->fetch_assoc();
            }
        }
    }
}
$login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
$login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
if (count($login_DB_temp_users) != 0) {
    while (count($login_DB_temp_users) != 0) {
        $login = preg_split('#\s+#', $login_string);
        $login_surname = $login[0];
        $login_name = $login[1];
        $login_patronymic = $login[2];
        $num_surname ++;
        $login_surname = substr($login_surname, 0, $num_surname);
        $login_name = substr($login_name, 0, $num_name);
        $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
        $login = $login_surname . $login_name . $login_patronymic;
        $login = strtolower($login);
        $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
        $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
        if (count($login_DB_temp_users) != 0) {
            $login_string = rus2translit($name);
            $login = preg_split('#\s+#', $login_string);
            $login_surname = $login[0];
            $login_name = $login[1];
            $login_patronymic = $login[2];
            $num_name++;
            $login_surname = substr($login_surname, 0, $num_surname);
            $login_name = substr($login_name, 0, $num_name);
            $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
            $login = $login_surname . $login_name . $login_patronymic;
            $login = strtolower($login);
            print_r($login);
            $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
            $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
            if (count($login_DB_temp_users) != 0) {
                $login_string = rus2translit($name);
                $login = preg_split('#\s+#', $login_string);
                $login_surname = $login[0];
                $login_name = $login[1];
                $login_patronymic = $login[2];
                $num_patronymic++;
                $login_surname = substr($login_surname, 0, $num_surname);
                $login_name = substr($login_name, 0, $num_name);
                $login_patronymic = substr($login_patronymic, 0, $num_patronymic);
                $login = $login_surname . $login_name . $login_patronymic;
                $login = strtolower($login);
                print_r($login);
                $login_DB_temp_users = $mysql->query("SELECT `login` FROM `temp-users` WHERE  `login` = '$login'");
                $login_DB_temp_users = $login_DB_temp_users->fetch_assoc();
            }
        }
    }
}
//Добавляем соль к паролю и хешируем
$password = md5($password . "matveeva");

//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `temp-users` (`name`, `login`, `pass`, `tel`, `email`) VALUES ('$name', '$login', '$password', '$tel', '$email')");

//Закрываем соеденение с БД
$mysql->close();

systemMessage("Запрос на регистрацию был отправлен. Ожидайте подверждения.");
