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

// Обработка нажатия на кнопку "Войти"
document.querySelector("#log-btn").addEventListener("click", () => {
  let login = document.querySelector("#log-login").value
  let password = document.querySelector("#log-pass").value

  if (!login || !password) {
    return
  }

  // Отправка логина и пароля на сервер
  SendRequest("POST", "../../test-log.php", { login: login, password: password })
})

// Обработка нажатия на кнопку "Регистрация" (Переход к форме регистрации)
document.querySelector("#reg-btn").addEventListener("click", () => {
  document.querySelector(".login-screen").classList.add("up")
  setTimeout(() => {
    document.querySelector(".button-back").classList.remove("hidden")
  }, 600)
})

// Обработка нажатия на кнопку "Назад"
document.querySelector("#back-btn").addEventListener("click", () => {
  document.querySelector(".login-screen").classList.remove("up")
  document.querySelector(".button-back").classList.add("hidden")
})

// Обработка нажатия на кнопку "Регистрация" (отправка формы регистрации)
document.querySelector("#send-reg-form-btn").addEventListener("click", () => {
  let name = document.querySelector("#reg-name").value
  let login = document.querySelector("#reg-login").value
  let password = document.querySelector("#reg-password").value

  if (!name || !login || !password) {
    return
  }

  SendRequest("POST", "../../test-reg.php", { login: login, password: password })
})
