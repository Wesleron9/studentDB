<?php
//session_start();
//$_SESSION['test'] = "Эврика";
setcookie("user", "батя", time() +60*5 );
    echo "Значение задано";