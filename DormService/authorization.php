<?php
    $login = filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $passwd = filter_var(trim($_POST['pass']),
    FILTER_SANITIZE_STRING);

    if(mb_strlen($login) <5 || mb_strlen($login) > 90) {
        echo "Недопустимая длина логина (От 5 до 90 символов)"
        exit();
        }
        else if (mb_strlen($passwd) <8 || mb_strlen($login) > 32) {
    echo "Недопустимая длина пароля (от 8 до 32 символов"
            exit();
    }

    $mysql = new mysqli("127.0.0.1:3306", "root", "rs2076571", "Dorm_DB");
?>
