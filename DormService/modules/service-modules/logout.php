<?php
session_start(); // Стартуем сессию

// Очистить массив $_SESSION полностью
session_unset();

// Удалить временное хранилище (файл сессии) на сервере
session_destroy();

// Принудительное удаление сессионной cookie
setcookie(session_name(), session_id(), time() - 3600);
exit(); // Завершаем скрипт
?>