let MENU // Все доступные пункты меню и подменю
let mainMenu // Главное меню

let menuWrapper = document.querySelector(".side-menu .menu")

function processMenu(menu) {
  if (!menu) {
    createPopUp("message", "Ошибка: меню недоступно")
    return
  }

  MENU = menu

  // Очистка массива меню на случай null внутри
  for (let i = 0; i < MENU.length; i++) {
    if (MENU[i] === null) {
      console.warn("Пустой пункт меню!")
      MENU.splice(i, 1)
      i = -1
    }
  }

  // Парсим ресурсы модуля
  MENU.forEach(menu_item => {
    menu_item.sources = JSON.parse(menu_item.sources)
  });

  // Получение списка главного меню
  mainMenu = [
    ...MENU.filter((menu_item) => {
      return (
        menu_item.module_type === "basic" ||
        menu_item.module_type === "menu-item"
      )
    }),
  ]

  // Сортировка главного меню
  for (let i = 0; i < mainMenu.length - 1; i++) {
    for (let n = 0; n < mainMenu.length - i; n++) {
      let left = mainMenu[i]
      let right = mainMenu[i + 1]

      if (
        parseInt(mainMenu[i].order) > parseInt(mainMenu[i + 1].order) &&
        parseInt(mainMenu[i + 1].order)
      ) {
        mainMenu[i] = right
        mainMenu[i + 1] = left
      }
    }
  }
}

function displayMainMenu() {
  // Удаляем прелоадер из меню
  document.querySelector(".preloader").remove()

  // Выводим все пункты меню
  mainMenu.forEach((menuItem, index) => {
    setTimeout(() => {
      menuWrapper.insertAdjacentHTML(
        "beforeend",
        `<li class="menu-item fadeIn" data-module="${menuItem.module}">
            <img src="${menuItem.sources.icon}" alt="">
            <span>${menuItem["module_text"]}</span>
          </li>`
      )
    }, 100 * index)

    // Удаляем ненужные классы после анимации
    setTimeout(() => {
      document.querySelectorAll(".fadeIn").forEach((el) => {
        el.classList.remove("fadeIn")
      })
      document.querySelectorAll("._anim").forEach((el) => {
        el.classList.remove("_anim")
      })
    }, 400)
  })
}

// Запрос меню
SendRequest(
  "POST",
  "module-manager.php",
  {
    task: "menu",
  },
  (response) => {
    response = JSON.parse(response)

    if (response.message) {
      createPopUp("message", response.message)
      return
    }

    // Передаем меню в обработчик
    processMenu(response)

    // Отображаем главное меню
    displayMainMenu()
  }
)
