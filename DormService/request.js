function SendRequest(method, url, data) {
  const xhr = new XMLHttpRequest()
  xhr.open(method, url, false) //Позже нужно сделать запросы асинхронными
  xhr.send(JSON.stringify(data))

  if (xhr.status != 200) {
    alert(xhr.status + ": " + xhr.statusText)
  } else {
    alert(xhr.responseText)
  }
}