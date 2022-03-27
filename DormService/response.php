<?php
// Функция для отправки данных на фронт
function systemResponse($data)
{
  if (!$data) { //Проверяем не пустые ли данные
    echo json_encode(["error" => "Пустой ответ от сервера"]);
    exit();
  }
  // Если все в порядке и есть что отправлять, отправляем ответ на фронт 
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

// Функция, которую необходимо вызывать, если необходимо отдать ошибку на фронт
function systemMessage($message)
{
  echo json_encode(["message" => $message], JSON_UNESCAPED_UNICODE);
}
