function SendRequest(method, url, data, responseHandler = (response) => {alert(`Нет обработчика данных. Ответ сервера: ${response}`)}) {
  const xhr = new XMLHttpRequest()
  xhr.open(method, url, true)
  xhr.send(JSON.stringify(data))

  xhr.onreadystatechange = function () {
    if (xhr.readyState != 4) {
      return
    }
    // Если нет ошибок, то запускаем хэндлер для полученных данных
    if (xhr.status != 200) {
      alert(xhr.status + ": " + xhr.statusText)
    } else {
      responseHandler(xhr.responseText)
    }
  }
}