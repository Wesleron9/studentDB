<title>two-step auth test</title>
<link rel="stylesheet" href="/style/common-styles.css" />

<?php
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

if ($login == "test" && $password == 'test123') {
  echo '<form method="post">
          <input type="text" name="code" placeholder="Код" />
          <input type="submit" value="Ввести код" />
        </form>';
  exit();
} else if ($code === "123") {
  echo '<h1 style="color:tomato;">ЮХУ! Успешная авторизация</h1>';
  exit();
}
?>


<form method="post">
  <input type="text" name="login" placeholder="Логин" value="test" />
  <input type="password" name="password" placeholder="Пароль" value="test123" />
  <input type="submit" value="Войти" />
</form>