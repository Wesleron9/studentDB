let MENU // Все доступные пункты меню и подменю
let mainMenu // Главное меню

const menuWrapper = document.querySelector(".side-menu .menu")
const mainWrapper = document.querySelector(".main")

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
  MENU.forEach((menu_item) => {
    menu_item.sources = JSON.parse(menu_item.sources)
  })

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
  document.querySelector(".side-menu .preloader").remove()

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
  })

  // Обработка клика по пункту в главном меню
  menuWrapper.addEventListener("click", (event) => {
    let li = event.target.closest("li")

    if (!li) {
      return
    }

    // Получаем имя модуля, котрому принадлежит этот пункт меню
    let type = li.dataset.module

    // Находим модуль, по которому кликнули
    let module = MENU.find((menu_item) => menu_item.module === type)

    // Если модуль не найден
    if (!module) {
      createPopUp("message", "Модуль не найден")
      console.error("Модуль не найден")
      return
    }

    if (module.module_type === "basic") {
      // Если это "basic" модуль, запрашиваем и выводим на экран
      displayModule(module)
    } else if (module.module_type === "menu-item") {
      // Если это "menu-item" модуль(содержит пункты подменю), то нужно запросить и вывести на экран
      displaySubmenuFor(module)
    } else {
      // Если был передан неверный тип модуля
      createPopUp("message", "Неправильный тип модуля." + module.module)
      console.error("Неправильный тип модуля." + module.module)
    }
  })

  // Удаляем ненужные классы после анимации
  setTimeout(() => {
    document.querySelectorAll(".fadeIn").forEach((el) => {
      el.classList.remove("fadeIn")
    })
    document.querySelectorAll("._anim").forEach((el) => {
      el.classList.remove("_anim")
    })
  }, 400)
}

function displayModule(module) {
  // Очистка окна
  mainWrapper.innerHTML = ""

  // Делаем запрос разметки и вставляем ее после получения
  SendRequest("GET", module.sources.html, "", (response) => {
    mainWrapper.insertAdjacentHTML("beforeend", response)
    
    // Подключение скрипта модуля
    const script = document.createElement("script")
    script.src = module.sources.js
    mainWrapper.insertAdjacentElement("afterbegin", script)
  })

  // Подключение стилей модуля
  const link = document.createElement("link")
  link.rel = "stylesheet"
  link.href = module.sources.css
  mainWrapper.insertAdjacentElement("afterbegin", link)
}

function displaySubmenuFor(module) {
  // Находим модули, которые вставлены в текущий
  let modules = MENU.filter((menu_item) => menu_item.inserted_in === module.module)
  console.log(modules)
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
