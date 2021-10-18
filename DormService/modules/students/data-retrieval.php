<?php
include "../../connection-to-db.php";
$result = $mysql->query("SELECT `name` FROM `stud` WHERE `Check out Date` = ''");
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        echo 'ФИО: '.$row['name'].'<br>';
    }
}

else
    echo "Данных нет!";
$mysql->close();
?>