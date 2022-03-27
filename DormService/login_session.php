<?php
//Стартуем сессию
session_start();
$login = $_SESSION['user_name'];
//Берём данные пользователя из БД
$result = $mysql->query("SELECT `name`, `role`, `photo` FROM `users` WHERE  `login` = '$login'");
$user = $result->fetch_assoc();
//Узнаем роль пользователя
$role_result = $mysql->query("SELECT `role`, `role id` FROM `role` WHERE  `role id` = $user[role]");
$role = $role_result->fetch_assoc();
//Закрываем соеденение с БД
$mysql->close();
//Создаём массив для передачи на фронт, и передаём его как json объект
$user = ["name" => $user["name"], "role" => $role["role"], "photo" => $user['photo']];
systemResponse($user);
