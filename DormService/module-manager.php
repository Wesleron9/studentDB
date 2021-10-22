<?php
require "connection-to-db.php";
// Скрипт для получения меню
// header("Content-Type: application/json");
// $user = json_decode(file_get_contents("php://input"));

// Reg module
$menu_item = [
  "Студенты" => [
    "icon" => "image/icons/menu-icons/multiple-users-silhouette",
    "modules" => [
      [
        "module-name" => "work-with-stud",
        "Text" => "Работа с карточками студентов"
      ]
    ]
  ]  
];

$menu_item = json_encode($menu_item, JSON_UNESCAPED_UNICODE);
$mysql->query("INSERT INTO `menu` (`key`, `menu`) VALUES (NULL, '$menu_item')");