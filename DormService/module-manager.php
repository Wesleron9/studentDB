<?php
include "response.php"; // Подключаем функции ответа

require "connection-to-db.php"; // Подключаемся к БД

header("Content-Type: application/json"); // Объявляем на какие данные расчитан этот скрипт

session_start(); // Стартуем сессию

$data = json_decode(file_get_contents("php://input")); // Принимаем данные с фронта
$task = filter_var(
    trim($data->task),
    FILTER_SANITIZE_STRING
);
$module = filter_var(
    trim($data->module),
    FILTER_SANITIZE_STRING
);
$function = filter_var(
    trim($data->function),
    FILTER_SANITIZE_STRING
);

$user = $_SESSION['user name']; // Проверяем кто авторизован

if ($user == " ") { // Если никто не авторизован

    systemMessage("Ошибка авторизации, попробуйте снова");
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
} elseif ($task == "menu") { // Запрос меню

    $result = $mysql->query("SELECT `module`, `module name`, `ico`, `#` FROM `mudels-user` WHERE  `login` = '$user' ORDER BY `#`"); // Запрос к БД какие модули доступны

    if ($result->num_rows > 0) { // Если запрос отдал больше 0 строк
        while ($menu = $result->fetch_assoc()) { // Выбераем записи
            $arr[$menu['#']] = array("menu-name" => $menu['module'], "module-name" => $menu['module name'], "path-ico" => $menu['ico']); // Добавляем записи в массив
        }
        systemResponse($arr); // Отправляем маcсив на фронт
    } else { // Если запрос не отдал ни одной строки
        systemMessage("Не один пункт меню не доступен, обратитесь к администратору");
    }

    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
} elseif ($task == "module") { // Запрос модуля

    $result = $mysql->query("SELECT `module`FROM `mudels-user` WHERE  `login` = '$user' and `module` = '$module'"); // Проверяем доступен ли модуль пользователю

    if ($result->num_rows > 0) { // Если доступен

        $result = $mysql->query("SELECT `css`, `java`, `html`, `php` FROM `mudels` WHERE  `mudels` = '$module'"); // Находим пути до модуля
        $path_modules = $result->fetch_assoc(); // Выбераем записи

        $arr = ["css" => $path_modules['css'], "java" => $path_modules['java'], "html" => $path_modules['html'], "php" => $path_modules['php']]; // Добавляем записи в массив
        systemResponse($arr); // Отправляем маcсив на фронт


    } else { // Если недоступен
        systemMessage("Недостаточно прав для просмотра этого модуля, обратитесь к администратору");
    }
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
} elseif ($task == "function") { // Запрос доступа к функции
    $result = $mysql->query("SELECT `function` FROM `$module` WHERE  `login` = '$user' and `function` = '$function'"); // Проверяем доступна ли функция пользователю
    if ($result->num_rows > 0) { // Если доступна
        $arr = [true];
        systemResponse($arr); // Отправляем маcсив на фронт
    } else {
        systemMessage("Недостаточно прав для использования этой функции, обратитесь к администратору");
    }
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
} else { // Если поступила неизвестная задача
    systemMessage("Неизвестная задача");
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
}
