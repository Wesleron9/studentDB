<?php
require_once('GoogleAuthenticator.php');
//require_once('phpqrcode-2010100721_1.1.4/qrlib.php');
$ga=new GoogleAuthenticator;
$user->secret=$ga->generateSecret();
print_r($user);
$login = 'sidorenri';
$qrdata = $ga->getUrl($login,'dorm-service.ru',$user->secret);
echo '<a href="http://qrcoder.ru" target="_blank"><img src="http://qrcoder.ru/code/?http%3A%2F%2F192.168.1.116%2Fmodules%2Fstudents%2Fdata-retrieval.php&4&0" width="164" height="164" border="0" title="QR код"></a>'

