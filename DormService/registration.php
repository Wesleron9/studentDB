<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));
    $login = filter_var(trim($data->login),
    FILTER_SANITIZE_STRING);
    $passwd = filter_var(trim($data->password),
    FILTER_SANITIZE_STRING);
   $name = filter_var(trim($data->name),
   FILTER_SANITIZE_STRING);

   if(mb_strlen($login) <4 || mb_strlen($login) > 90) {
       echo "Недопустимая длина логина (От 4 до 90 символов)";
       exit();
    }  else if (mb_strlen($passwd) <8 || mb_strlen($login) > 32) {
        echo "Недопустимая длина пароля (от 8 до 32 символов)";
        exit();
    }   else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
        echo "Недопустимая длина ФИО (от 3 до 50 символов)";
        exit();
    }

    $passwd = md5($passwd."matveeva");

require "connection-to-db.php";
    $mysql->query("INSERT INTO `temp users` (`login`, `pass`, `name`)
    VALUES ('$login', '$passwd', '$name')");
   $mysql->close();
//echo $_POST['login'];
//$login = $_POST['login'];
//echo "Вы успешно зарегистрировались<br>";
//echo "Все";
?> 