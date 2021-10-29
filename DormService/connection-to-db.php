<?php
//Подключаемся к БД
$mysql = new mysqli('dorm-service.ru:3306/', 'dewal778_html', 'Rs6730489!', 'dewal778_dorm');

// Установка кодировки соединения
$mysql->query("SET NAMES utf8");
$mysql->query("SET CHARACTER SET utf8");
$mysql->query("SET character_set_connection=utf8");
