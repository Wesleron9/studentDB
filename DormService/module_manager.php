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
if ($user = " "){ // Если никто не авторизован
    systemMessage("Ошибка авторизации, попробуйте снова");
}
elseif ($task = "menu"){ // Запрос меню
    $result = $mysql->query("SELECT `module`, `module name`, `ico`, `#` FROM `mudels-user` WHERE  `login` = '$user' ORDER BY `#`"); // Запрос к БД какие меню доступны

         if ($result->num_rows > 0) { // Если запрос отдал больше 0 строк
             while ($menu = $result->fetch_assoc()) { // Выбераем записи
                $arr[$menu['#']] = array("menu-name" => $menu['module'], "module-name" => $menu['module name'], "wey-ico" => $menu['ico']); // Добавляем записи в массив
             }
            systemResponse($arr); // Отправляем масив на фронт
         }
        else{ // Если запрос не отдал ни одной строки
            systemMessage("Не один пункт меню не доступен, обратитесь к администратору");
        }

        $mysql->close(); // Закрываем соеденение с БД
        exit(); // Завершаем скрипт
}
elseif ($task ="module"){ // Запрос модуля
    $result = $mysql->query("SELECT `css`, `java`, `html`, `php` FROM `mudels` WHERE  `mudels` = '$module'");
}
elseif ($task = "access"){ // Запрос доступа к функции

}
else{ // Если поступила неизвестная задача
    systemMessage("Неизвестная задача");
    $mysql->close(); // Закрываем соеденение с БД
    exit(); // Завершаем скрипт
}
