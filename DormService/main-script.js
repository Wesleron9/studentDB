//----------------------------------------------------
//-----------------Регистрация и вход-----------------
//----------------------------------------------------

// Обработка нажатия на кнопку "Войти"
document.querySelector("#log-btn").addEventListener("click", () => {
  let login = document.querySelector("#log-login").value
  let password = document.querySelector("#log-pass").value

  // Валидация логина и пароля
  if (!login) {
    createPopUp('message', "Введите логин!")
    return
  } else if (!password) {
    createPopUp('message', "Введите пароль!")
    return
  }

  // Отправка логина и пароля на сервер
  SendRequest(
    "POST",
    "authorization.php",
    {
      login: login,
      password: password,
    },
    (response) => {
      response = JSON.parse(response)

      if (response.error) {
        createPopUp("message", response.error)
      }
    }
  )
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

  SendRequest("POST", "registration.php", {
    name: name,
    login: login,
    password: password,
  })
})
