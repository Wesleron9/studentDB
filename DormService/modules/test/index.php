<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Форма регистрации</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-4">

    <?php
    if ($_COOKIE['user'] == '' ):
    ?>
    <div class="row">
        <div class="col">
            <h1>Форма регистрации</h1>
            <form action="php/registration.php" method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
                <input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"><br>
                <button class="btn btn-success" type="submit">Зарегистрировать</button>
            </form>
        </div>
        <div class="col">
            <h1>Форма авторизации</h1>
            <form action="php/authorization.php" method="post">
                <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"><br>
                <button class="btn btn-success" type="submit">Войти</button>
            </form>
        </div>
        <?php else:?>
            <p>Привет <?=$_COOKIE['user']?>. чтобы выйти нажмите <a href="/exit.php">здесь</a>.</p>
        <?php endif;?>

    </div>

</div>
</body>
</html>