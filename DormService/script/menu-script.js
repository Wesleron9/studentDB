let MENU = []

let menuWrapper = document.querySelector(".side-menu .menu")

function displayMenu(menu) {
  if (!menu) {
    createPopUp("message", "Ошибка: меню недоступно")
    return
  }

  // Очистка массива меню на случай null внутри
  for (let i = 0; i < menu.length; i++) {
    if (menu[i] === null) {
      console.warn("Пустой пункт меню!")
      menu.splice(i, 1)
      i = -1
    }
  }

  // Удаляем прелоадер
  document.querySelector(".preloader").remove()

  MENU = [
    ...menu.filter((menu_item) => {
      return menu_item.module_type === "basic" || menu_item.module_type === "menu-item"
    }),
  ]

  console.log(MENU)

  // Сортировка меню
  for (let i = 0; i < MENU.length - 1; i++) {
    for (let n = 0; n < MENU.length - i; n++) {
      let left = MENU[i]
      let right = MENU[i + 1]

      if (parseInt(MENU[i].order) > parseInt(MENU[i + 1].order) && parseInt(MENU[i + 1].order)) {
        MENU[i] = right
        MENU[i + 1] = left
      }
    }
  }

  // Выводим все пункты меню
  MENU.forEach((menuItem, index) => {
    setTimeout(() => {
      menuWrapper.insertAdjacentHTML(
        "beforeend",
        `<li class="menu-item fadeIn" data-module="${menuItem.module}">
            <img src="${menuItem.icon}" alt="">
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

    displayMenu(response)
  }
)
