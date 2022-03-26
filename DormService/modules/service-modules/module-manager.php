<?php
include "response.php"; // Подключаем функции ответа

require "../../config/DB-Config.php"; // Подключаемся к БД

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

$user = $_SESSION['user_name']; // Проверяем кто авторизован

if (!$user) { // Если никто не авторизован
    systemMessage("Ошибка авторизации");
    // Очистить массив $_SESSION полностью
    session_unset();

    // Удалить временное хранилище (файл сессии) на сервере
    session_destroy();

    // Принудительное удаление сессионной cookie
    setcookie(session_name(), session_id(), time() - 3600);
    exit(); // Завершаем скрипт
} elseif ($task == "menu") { // Запрос меню
    $available_modules = $mysql->query("SELECT `module` FROM `modules-user` WHERE  `login` = '$user'"); // Запрос к БД какие модули доступны

    if ($available_modules->num_rows <= 0) {
        systemMessage("Не один пункт меню не доступен, обратитесь к администратору");
        $mysql->close(); // Закрываем соеденение с БД
        exit(); // Завершаем скрипт
    }

    $response = [];

    while ($module = $available_modules->fetch_assoc()) { // Выбераем записи
        $module_name = $module["module"];
        array_push($response, $mysql->query("SELECT `module`, `description`, `module_text`, `module_type`, `inserted_in`, `sources`, `order` FROM `modules` WHERE  `module` = '$module_name'")->fetch_assoc()); // Добавляем записи в массив
    }

    systemResponse($response); // Отправляем маcсив на фронт

    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
} elseif ($task == "module") { // Запрос модуля




    $result = $mysql->query("SELECT `module` FROM `modules-user` WHERE  `login` = '$user' and `module` = '$module'"); // Проверяем доступен ли модуль пользователю

    if ($result->num_rows > 0) { // Если доступен

        $result = $mysql->query("SELECT `css`, `java`, `html`, `php` FROM `mudels` WHERE  `mudels` = '$module'"); // Находим пути до модуля
        $path_modules = $result->fetch_assoc(); // Выбераем записи

        $response = ["css" => $path_modules['css'], "java" => $path_modules['java'], "html" => $path_modules['html'], "php" => $path_modules['php']]; // Добавляем записи в массив
        systemResponse($response); // Отправляем маcсив на фронт


    } else { // Если недоступен
        systemMessage("Недостаточно прав для просмотра этого модуля, обратитесь к администратору");
    }
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт





} elseif ($task == "function") { // Запрос доступа к функции
    $result = $mysql->query("SELECT `function` FROM `$module` WHERE  `login` = '$user' and `function` = '$function'"); // Проверяем доступна ли функция пользователю
    if ($result->num_rows > 0) { // Если доступна
        $response = [true];
        systemResponse($response); // Отправляем маcсив на фронт
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
