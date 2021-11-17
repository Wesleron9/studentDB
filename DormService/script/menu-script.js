let menuWrapper = document.querySelector(".side-menu .menu")

function displayMenu(menu) {
  if (!menu) {
    createPopUp("message", "Ошибка: меню недоступно")
    return
  }

  menu.forEach((menuItem, index) => {
    setTimeout(() => {
      menuWrapper.insertAdjacentHTML(
        "beforeend",
        `<li class="menu-item fadeIn">
            <img src="${menuItem.icon}" alt="">
            <span>${menuItem["module-name"]}</span>
          </li>`
      )
    }, 100 * index)

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

    const menu = response

    // Сортировка меню
    for (let i = 0; i < menu.lenght; i++) {
      for (let n = 0; n < menu.lenght - 1; n++) {
        let left = parseInt(menu[i])
        let right = parseInt(menu[i + 1])

        if (menu[i].order > menu[i + 1].order) {
          menu[i] = right
          menu[i + 1] = left
        }
      }
    }
    displayMenu(menu)
  }
)
