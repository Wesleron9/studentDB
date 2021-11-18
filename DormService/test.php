<?php
//Подключаемся к БД
require "DB-Config.php";
require "response.php";

$available_modules = $mysql->query("SELECT `module` FROM `modules-user` WHERE  `login` = 'test'"); // Запрос к БД какие модули доступны

if ($available_modules->num_rows > 0) { // Если запрос отдал больше 0 строк

  while ($module = $available_modules->fetch_assoc()) { // Выбераем записи
    $module_name = $module["module"];
    array_push($response, $mysql->query("SELECT `module`, `module_text`, `sources`, `order` FROM `modules` WHERE  `module` = '$module_name'")); // Добавляем записи в массив
  }
  systemResponse($response); // Отправляем маcсив на фронт
} else { // Если запрос не отдал ни одной строки
  systemMessage("Не один пункт меню не доступен, обратитесь к администратору");
}

$mysql->close(); // Закрываем соеденение с БД
exit(); // Завершаем скрипт