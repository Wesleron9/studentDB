<title>two-step auth test</title>
<link rel="stylesheet" href="/style/common-styles.css" />

<?php
require_once('GoogleAuthenticator.php');
require "/DB-Config.php";
$login = filter_var(
  trim($_POST['login']),
  FILTER_SANITIZE_STRING
);

$password = filter_var(
  trim($_POST['password']),
  FILTER_SANITIZE_STRING
);
$code = filter_var(
  trim($_POST['code']),
  FILTER_SANITIZE_STRING
);
$password = md5($password . "matveeva");
$result = $mysql->query("SELECT `secret` FROM `users` WHERE  `login` = '$login' and `pass` = '$password'");
$user = $result->fetch_assoc();
$secret = filter_var(
    trim($user['secret']),
    FILTER_SANITIZE_STRING
);
print_r($secret);
$mysql->close();
if (count($user) != 0) {
  echo '<form method="post">
          <input type="text" name="code" placeholder="Код" />
          <input type="submit" value="Ввести код" />
        </form>';

  exit();
}
else{
    echo '<h1 style="color:#DC143C	;">Логин или пароль неверен</h1>';
    exit();
}
$ga=new PHPGangsta_GoogleAuthenticator;
$check_code =$ga->verifyCode($secret, $code, 2);
if ($check_code) {
  echo '<h1 style="color:#00FF00;">ЮХУ! Успешная авторизация</h1>';
  exit();
}
else {
    echo '<h1 style="color:#DC143C;">Код неверен</h1>';
    exit();
}
?>


<form method="post">
  <input type="text" name="login" placeholder="Логин" value="test" />
  <input type="password" name="password" placeholder="Пароль" value="test123" />
  <input type="submit" value="Войти" />
</form>