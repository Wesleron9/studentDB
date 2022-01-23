<?php
require_once('GoogleAuthenticator.php');
$ga=new PHPGangsta_GoogleAuthenticator;
$secret=$ga->createSecret();
$login = 'sidorenri';
$qrurl = $ga->getQRCodeGoogleUrl("Dorm srevice@".$login,$secret);
echo '<img src="'.$qrurl.'">';
echo $secret;
