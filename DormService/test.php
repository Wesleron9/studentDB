<?php
//Добавляем соль к паролю и хешируем
$password = md5("test123" . "matveeva");

//Подключаемся к БД
require "DB-Config.php";

//Вносим данные о регистрации в таблицу не подтвержденных ползователей
$mysql->query("INSERT INTO `users` (`name`, `login`, `pass`, `role`, `photo`) VALUES ('TEST USER', 'test', '$password', 'Администратор', '/resources/user-photo/avatar2.jpg')");

//Закрываем соеденение с БД
$mysql->close();