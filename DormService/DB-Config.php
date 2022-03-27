<?php
//Подключаемся к БД
$mysql = new mysqli('95.31.35.72:3306', 'dorm-service', 'XlPSUbi$O~G#QIDBdpwnNQsH', 'dorm-service');

// Установка кодировки соединения
$mysql->query("SET NAMES utf8");
$mysql->query("SET CHARACTER SET utf8");
$mysql->query("SET character_set_connection=utf8");
