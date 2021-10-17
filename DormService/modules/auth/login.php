<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="script.js" defer></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    if ($_COOKIE['user'] == '' ):
    ?>
  <div class="login-container">
    <form method="post" action="/modules/auth/validation-form/authorization.php" class="login">
      <img src="../../resources/image/icons/user 1.png" alt="user 1.png">
      <input id="login" type="text" name="login" placeholder="Логин">
      <input id="pass" type="password" name="password" placeholder="Пароль">
      <div class="buttons">
        <button id="signin" class="button">Войти</button>
        <a href="#" id="reg" class="button">Регистрация</a>
      </div>
    </form>
  </div>
  <div class="reg-container"></div>
          <?php else:?>
            <p>Привет <?=$_COOKIE['user']?>. чтобы выйти нажмите <a href="/modules/auth/exit.php">здесь</a>.</p>
        <?php endif;?>
</body>

</html>