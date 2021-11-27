function SendRequest(
  method,
  url,
  data = "",
  responseHandler = (response) => {
    createPopUp("message", `Нет обработчика данных. Ответ сервера: ${response}`)
  }
) {
  const xhr = new XMLHttpRequest()

  if (method === "POST") {
    xhr.open(method, url, true)
    xhr.send(JSON.stringify(data))
  } else if (method === "GET") {
    xhr.open(method, url, true)
    xhr.send()
  }

  xhr.onreadystatechange = function () {
    if (xhr.readyState != 4) {
      return
    }
    // Если нет ошибок, то запускаем хэндлер для полученных данных
    if (xhr.status != 200) {
      createPopUp("message", `${xhr.status} : ${xhr.statusText}`)
    } else {
      responseHandler(xhr.responseText)
    }
  }
}
