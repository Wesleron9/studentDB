<?php
include "../../connection-to-db.php";
$result = $mysql->query("SELECT `name`, `id`, `room` FROM `stud` WHERE `Check out Date` = ''");
$num = 1;
$user = 1;
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $arr[$num][] =array($row['name'], $row['id']);
        //echo "КОД:  ".$arr[$user][0][1]."  ---  ФИО: ".$arr[$user][0][0].'<br>';
        //$user++;
        $num ++;
       //echo 'ФИО: '.$row['name'].'<br>';
    }
}
else{
    echo "Данных нет!";
    }
$mysql->close();

$json = json_encode($arr, JSON_UNESCAPED_UNICODE);
$qrdata ='';
echo '<a href="http://qrcoder.ru" target="_blank"><img src="http://qrcoder.ru/code/?http%3A%2F%2F192.168.1.116%2Fmodules%2Fstudents%2Fdata-retrieval.php&4&0" width="164" height="164" border="0" title="QR код"></a>'
//$user = 1;
//echo $arr[$user][0][1];
?>
