function deleteCookie(name) {
  var domain = location.hostname,
    path = "/" // root path

  document.cookie = [
    name,
    "=",
    "; expires=" + new Date(0).toUTCString(),
    "; path=" + path,
    "; domain=" + domain,
  ].join("")
}

class Menu {
  constructor() {
    this.$sidebar = document.querySelector(".side-menu")
    this.$menuList = document.querySelector(".side-menu .menu")
    this.$mainWindow = document.querySelector(".main")
    this.$logout_btn = document.querySelector("#logout-btn")

    this.MENU // Все доступные пункты меню и подменю
    this.mainMenu // Главное меню
    this.currentMenuItem = {
      module: "",
      element: "",
    }

    this.menuItemClickHandler = (event) => {
      let div = event.target.closest("div.submenu-item")

      // Если кликнули не по элементу подменю
      if (!div) {
        return
      }

      // Находим модуль, по которому кликнули
      let module = this.MENU.find(
        (menu_item) => menu_item.module === div.dataset.module
      )

      // Если модуль не найден
      if (!module) {
        createPopUp("message", "Модуль не найден")
        console.error("Модуль не найден")
        return
      }

      if (
        this.MENU.filter((menu_item) => menu_item.inserted_in === module.module)
          .length > 0
      ) {
        this.displaySubmenuFor(module)
      } else {
        this.displayModule(module)

        this.$mainWindow.removeEventListener("click", this.menuItemClickHandler)
      }
    }

    this.$logout_btn.addEventListener("click", () => {
      SendRequest("POST", "logout.php")
      deleteCookie("PHPSESSID")

      // Сбор элементов для анимации исчезновения
      const elementsForFadeOut = document.querySelectorAll(".side-menu > *")

      this.$mainWindow.remove()
      this.$sidebar.classList.add("auth-wrapper")
      this.$sidebar.classList.remove("side-menu")

      // Даем элементам анимацию поочередного исчезновения
      elementsForFadeOut.forEach((el, index) => {
        setTimeout(() => {
          el.classList.add("fadeOut")
        }, 150 * index)
      })
    })
  }

  // Инициализация меню
  initMenu() {
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
        this.processMenu(response)

        // Отображаем главное меню
        this.displayMainMenu()
      }
    )
  }

  // Обработка меню
  processMenu(response) {
    if (!response) {
      createPopUp("message", "Ошибка: меню недоступно")
      return
    }

    this.MENU = response

    // Очистка массива меню на случай null внутри
    for (let i = 0; i < this.MENU.length; i++) {
      if (this.MENU[i] === null) {
        console.warn("Пустой пункт меню!")
        this.MENU.splice(i, 1)
        i = -1
      }
    }

    // Парсим ресурсы модулей
    this.MENU.forEach((menu_item) => {
      menu_item.sources = JSON.parse(menu_item.sources)
    })

    // Получение списка главного меню
    this.mainMenu = [
      ...this.MENU.filter((menu_item) => {
        return (
          menu_item.module_type === "basic" ||
          menu_item.module_type === "menu-item"
        )
      }),
    ]

    // Сортировка главного меню
    for (let i = 0; i < this.mainMenu.length - 1; i++) {
      for (let n = 0; n < this.mainMenu.length - i; n++) {
        let left = this.mainMenu[i]
        let right = this.mainMenu[i + 1]

        if (
          parseInt(this.mainMenu[i].order) >
            parseInt(this.mainMenu[i + 1].order) &&
          parseInt(this.mainMenu[i + 1].order)
        ) {
          this.mainMenu[i] = right
          this.mainMenu[i + 1] = left
        }
      }
    }
  }

  // Вывод главного меню
  displayMainMenu() {
    // Удаляем прелоадер из меню
    document.querySelector(".side-menu .preloader").remove()

    // Выводим все пункты меню
    this.mainMenu.forEach((menuItem, index) => {
      setTimeout(() => {
        this.$menuList.insertAdjacentHTML(
          "beforeend",
          `<li class="menu-item fadeIn" data-module="${menuItem.module}">
              <img src="${menuItem.sources.icon}" alt="">
              <span>${menuItem["module_text"]}</span>
            </li>`
        )
      }, 100 * index)
    })

    // Обработка клика по пункту в главном меню
    this.$menuList.addEventListener("click", (event) => {
      let li = event.target.closest("li")

      if (!li || li.classList.contains("current-menu-item")) {
        return
      }

      // Находим модуль, по которому кликнули
      let module = this.MENU.find(
        (menu_item) => menu_item.module === li.dataset.module
      )

      // Если модуль не найден
      if (!module) {
        createPopUp("message", "Модуль не найден")
        console.error("Модуль не найден")
        return
      }

      this.currentMenuItem.element = document.querySelector(
        ".side-menu .menu .current-menu-item"
      )

      // Удаляем класс current-menu-item у элемента меню активного ранее
      if (this.currentMenuItem.element) {
        this.currentMenuItem.element.classList.remove("current-menu-item")

        // Если активный до этого элемент был пунктом меню, который содержал подменю
        if (this.currentMenuItem.module.module_type === "menu-item") {
          this.$mainWindow.removeEventListener(
            "click",
            this.menuItemClickHandler
          )
        }
      }

      this.currentMenuItem.module = module

      li.classList.add("current-menu-item")

      if (module.module_type === "basic") {
        // Если это "basic" модуль, запрашиваем и выводим на экран
        this.displayModule(module)
      } else if (module.module_type === "menu-item") {
        // Если это "menu-item" модуль(содержит подменю), то нужно вывести на экран подменю
        this.displaySubmenuFor(module)
      } else {
        // Если был передан неверный тип модуля
        createPopUp("message", "Неправильный тип модуля." + module.module)
        console.error("Неправильный тип модуля." + module.module)
      }
    })

    // Удаляем ненужные классы после анимации появления меню
    setTimeout(() => {
      document.querySelectorAll(".fadeIn").forEach((el) => {
        el.classList.remove("fadeIn")
      })
      document.querySelectorAll("._anim").forEach((el) => {
        el.classList.remove("_anim")
      })
    }, 400)
  }

  // Вывод подменю
  displaySubmenuFor(module) {
    // Находим модули, которые вставлены в текущий
    let modules = this.MENU.filter(
      (menu_item) => menu_item.inserted_in === module.module
    )

    this.$mainWindow.innerHTML = ""

    modules.forEach((menu_item) => {
      this.$mainWindow.insertAdjacentHTML(
        "beforeend",
        `
      <div class="submenu-item" data-module="${menu_item.module}">
        <span class="submenu-title">${menu_item.module_text}</span>
        <p class="submenu-description">${module.description}</p>
      </div>
      `
      )
    })

    this.$mainWindow.addEventListener("click", this.menuItemClickHandler)
  }

  // Вывод модуля
  displayModule(module) {
    // Очистка окна
    this.$mainWindow.innerHTML = ""

    // Делаем запрос разметки и вставляем ее после получения
    SendRequest("GET", module.sources.html, "", (response) => {
      this.$mainWindow.insertAdjacentHTML("beforeend", response)

      // Подключение скрипта модуля
      const script = document.createElement("script")
      script.src = module.sources.js
      this.$mainWindow.insertAdjacentElement("afterbegin", script)
    })

    // Подключение стилей модуля
    const link = document.createElement("link")
    link.rel = "stylesheet"
    link.href = module.sources.css
    this.$mainWindow.insertAdjacentElement("afterbegin", link)
  }
}

const menu = new Menu()
menu.initMenu()
