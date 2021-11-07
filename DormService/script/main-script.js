setScreenTabs()

function setScreenTabs() {
  const loginElements = [
    ...document.querySelectorAll(".login-screen .button"),
    ...document.querySelectorAll(".login-screen input"),
  ]

  const regElements = [
    ...document.querySelectorAll(".reg-screen .button"),
    ...document.querySelectorAll(".reg-screen input"),
    document.querySelector(".button-back"),
  ]

  // Очищаем всем tabindex
  document.querySelectorAll("*").forEach((el) => {
    el.setAttribute("tabindex", -999)
  })

  // В нужном screen выставляем всем tabindex
  if (document.querySelector(".login-screen").classList.contains("up")) {
    regElements.forEach((el) => {
      el.setAttribute("tabindex", 0)
    })
  } else {
    loginElements.forEach((el) => {
      el.setAttribute("tabindex", 0)
    })
  }
}

function lockButton(button) {
  if (button.classList.contains("unavailable")) {
    return
  }

  button.classList.add("unavailable")
}

function transformToWorkspace(name, role, photoPath) {
  const wrapper = document.querySelector(".auth-wrapper")
  wrapper.querySelector(".reg-screen").remove()
  const elementsForFadeOut = wrapper.querySelectorAll("._anim")
  setTimeout(() => {
    wrapper.classList.add("side-menu")
  }, 150 * elementsForFadeOut.length)
  elementsForFadeOut.forEach((el, index) => {
    setTimeout(() => {
      el.classList.add("fadeOut")
    }, 150 * index)
  })
  // wrapper.classList.add("side-menu")
  // alert(`Name: ${name}, Role: ${role}, Photo: ${photoPath}`)
}
//----------------------------------------------------
//------------------------Вход------------------------
//----------------------------------------------------
let log_loginInput = document.querySelector("#log-login") //Поле логина в форме входа
let log_passwordInput = document.querySelector("#log-pass") //Поле пароля в форме входа
let logBtn = document.querySelector("#log-btn") //Кнопка "Войти"

function signIn() {
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
      response = JSON.parse(response)

      if (response.message) {
        createPopUp("message", response.message)
        return
      }

      transformToWorkspace(response.name, response.role, response.photo)
    }
  )
}

// Обработка нажатия на кнопку "Войти"
logBtn.addEventListener("click", signIn)
logBtn.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    signIn()
  }
})

log_loginInput.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    signIn()
  }
})

log_passwordInput.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    signIn()
  }
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
function moveTosignUpForm() {
  document.querySelector(".login-screen").classList.add("up")
  setScreenTabs()
  setTimeout(() => {
    document.querySelector(".button-back").classList.remove("hidden")
  }, 600)
}
document.querySelector("#reg-btn").addEventListener("click", moveTosignUpForm)
document.querySelector("#reg-btn").addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    moveTosignUpForm()
  }
})

//----------------------------------------------------
//---------------------Регистрация--------------------
//----------------------------------------------------

// Обработка нажатия на кнопку "Назад" (возврат к авторизации)
const backBtn = document.querySelector("#back-btn")

function moveTosignInForm() {
  document.querySelector(".login-screen").classList.remove("up")
  setScreenTabs()
  document.querySelector(".button-back").classList.add("hidden")
}

backBtn.addEventListener("click", moveTosignInForm)
backBtn.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    moveTosignInForm()
  }
})

const reg_nameInput = document.querySelector("#reg-name") //Поле имени в форме регистрации
const reg_emailInput = document.querySelector("#reg-email") //Поле почты в форме регистрации
const reg_telInput = document.querySelector("#reg-tel") //Поле телефона в форме регистрации
const reg_passwordInput = document.querySelector("#reg-password") //Поле пароля в форме регистрации
const regBtn = document.querySelector("#send-reg-form-btn") //Кнопка "Регистрация"

function signUp() {
  let name = reg_nameInput.value
  let email = reg_emailInput.value
  let tel = reg_telInput.value
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

  if (!password) {
    reg_passwordInput.classList.add("wrongInput")
  }

  if (!name || !password || !email || !tel) {
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
}

// Обработка нажатия на кнопку "Регистрация" (отправка формы регистрации)
regBtn.addEventListener("click", signUp)

regBtn.addEventListener("keydown", (event) => {
  if (event.key === "Enter") {
    signUp()
  }
})
