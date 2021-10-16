<?php
    $login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $passwd = filter_var(trim($_POST['password']),
    FILTER_SANITIZE_STRING);
//   $name = filter_var(trim($_POST['name']),
//   FILTER_SANITIZE_STRING);
    $name = "test";
    if(mb_strlen($login) <5 || mb_strlen($login) > 90) {
       echo "Недопустимая длина логина (От 5 до 90 символов)";
       exit();
    }  else if (mb_strlen($passwd) <8 || mb_strlen($login) > 32) {
        echo "Недопустимая длина пароля (от 8 до 32 символов)";
        exit();
    }   else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
        echo "Недопустимая длина ФИО (от 3 до 50 символов)";
        exit();
    }
    $mysql = new mysqli('127.0.0.1', 'root', 'rs2076571', 'dorm_db');
    $mysql->query("INSERT INTO `users` (`login`, `pass`, `name`)
    VALUES ('$login', '$passwd', '$name')");
    $mysql->close();
//echo $_POST['login'];
//$login = $_POST['login'];
//echo $login;
?> 