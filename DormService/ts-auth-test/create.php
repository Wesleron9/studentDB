<?php
require_once('GoogleAuthenticator.php');
$ga=new GoogleAuthenticator;
$user->ga_secret=$ga->generateSecret();
$user->save();
print_r($user);