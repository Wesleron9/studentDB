function lockButton(button) {
  if (button.classList.contains("unavailable")) {
    return
  }

  button.classList.add("unavailable")
}
//----------------------------------------------------
//------------------------Вход------------------------
//----------------------------------------------------
let log_loginInput = document.querySelector("#log-login") //Поле логина в форме входа
let log_passwordInput = document.querySelector("#log-pass") //Поле пароля в форме входа
let logBtn = document.querySelector("#log-btn") //Кнопка "Войти"

// Обработка нажатия на кнопку "Войти"
logBtn.addEventListener("click", () => {
  let login = log_loginInput.value
  let password = log_passwordInput.value

  // Доступна ли кнопка
  if (logBtn.classList.contains("unavailable")) {
    return
  }

  // Валидация логина и пароля
  // Если нет логина
  if (!login) {
    log_loginInput.classList.add("wrongInput")
  }

  // Если нет пароля
  if (!password) {
    log_passwordInput.classList.add("wrongInput")
  }

  if (!login || !password) {
    lockButton(logBtn)
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
      // response = JSON.parse(response)

      if (response.message) {
        createPopUp("message", response.message)
        return
      }

      createPopUp("message", response)

      // transformToMenu()
    }
  )
})

// Удаляем красную метку у инпутов при начале их редактирования + разблокировка кнопок
document.querySelectorAll(".auth-wrapper input").forEach((input) => {
  input.addEventListener("focus", function () {
    //Отммена выделения красным у поля
    this.classList.remove("wrongInput")
  })
  input.addEventListener("keydown", function () {
    // Разблокирование кнопок
    if (logBtn.classList.contains("unavailable")) {
      logBtn.classList.remove("unavailable")
    }

    if (regBtn.classList.contains("unavailable")) {
      regBtn.classList.remove("unavailable")
    }
  })
})

// Обработка нажатия на кнопку "Регистрация" (Переход к форме регистрации)
document.querySelector("#reg-btn").addEventListener("click", () => {
  document.querySelector(".login-screen").classList.add("up")
  setTimeout(() => {
    document.querySelector(".button-back").classList.remove("hidden")
  }, 600)
})

//----------------------------------------------------
//---------------------Регистрация--------------------
//----------------------------------------------------

// Обработка нажатия на кнопку "Назад" (возврат к авторизации)
document.querySelector("#back-btn").addEventListener("click", () => {
  document.querySelector(".login-screen").classList.remove("up")
  document.querySelector(".button-back").classList.add("hidden")
})
let reg_nameInput = document.querySelector("#reg-name") //Поле имени в форме регистрации
let reg_emailInput = document.querySelector("#reg-email") //Поле почты в форме регистрации
let reg_telInput = document.querySelector("#reg-tel") //Поле телефона в форме регистрации
let reg_loginInput = document.querySelector("#reg-login") //Поле логина в форме регистрации
let reg_passwordInput = document.querySelector("#reg-password") //Поле пароля в форме регистрации
let regBtn = document.querySelector("#send-reg-form-btn") //Кнопка "Регистрация"

// Обработка нажатия на кнопку "Регистрация" (отправка формы регистрации)
regBtn.addEventListener("click", () => {
  let name = reg_nameInput.value
  let email = reg_emailInput.value
  let tel = reg_telInput.value
  let login = reg_loginInput.value
  let password = reg_passwordInput.value

  if (regBtn.classList.contains("unavailable")) {
    return
  }

  // Валидация
  if (!name) {
    reg_nameInput.classList.add("wrongInput")
  }

  if (!email) {
    reg_emailInput.classList.add("wrongInput")
  }

  if (!tel) {
    reg_telInput.classList.add("wrongInput")
  }

  if (!login) {
    reg_loginInput.classList.add("wrongInput")
  }

  if (!password) {
    reg_passwordInput.classList.add("wrongInput")
  }

  if (!name || !login || !password || !email || !tel) {
    lockButton(regBtn)
    return
  }

  SendRequest(
    "POST",
    "registration.php",
    {
      name: name,
      email: email,
      tel: tel,
      login: login,
      password: password,
    },
    (response) => {
      response = JSON.parse(response)

      if (response.message) {
        createPopUp("message", response.message)
      }
    }
  )
})
