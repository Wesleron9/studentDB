<?php
// Скрипт для получения меню
header("Content-Type: application/json");
$user = json_decode(file_get_contents("php://input"));

