<?php
include "connection-to-db.php";
$result = $mysql->query("SELECT `fio` FROM `stud`");
//print_r($result);
print_r($mysql);
?>