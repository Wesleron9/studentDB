<?php
require_once('GoogleAuthenticator.php');
$ga=new GoogleAuthenticator;
$user->secret=$ga->generateSecret();
print_r($user);
