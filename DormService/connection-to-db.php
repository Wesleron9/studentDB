<?php
//Подключаемся к БД
$mysql = new mysqli('server71.hosting.reg.ru:3306/', 'u1466303_dormdb', '6ZFF5imM5rvWHv8', 'u1466303_dormdb');

// Установка кодировки соединения
$mysql->query("SET NAMES utf8");
$mysql->query("SET CHARACTER SET utf8");
$mysql->query("SET character_set_connection=utf8");
