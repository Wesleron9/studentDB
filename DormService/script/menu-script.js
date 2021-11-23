const MENU = {
  "module": {

  }
}
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

  // Сортировка меню
  for (let i = 0; i < menu.length; i++) {
    for (let n = 0; n < menu.length - 1; n++) {
      let left = parseInt(menu[i])
      let right = parseInt(menu[i + 1])

      if (menu[i].order > menu[i + 1].order) {
        menu[i] = right
        menu[i + 1] = left
      }
    }
  }

  // Удаляем прелоадер
  document.querySelector(".preloader").remove()

  // Выводим все пункты меню
  // menu.forEach((menuItem, index) => {
  //   setTimeout(() => {
  //     menuWrapper.insertAdjacentHTML(
  //       "beforeend",
  //       `<li class="menu-item fadeIn">
  //           <img src="${menuItem.icon}" alt="">
  //           <span>${menuItem["module_text"]}</span>
  //         </li>`
  //     )
  //   }, 100 * index)

  //   // Удаляем ненужные классы после анимации
  //   setTimeout(() => {
  //     document.querySelectorAll(".fadeIn").forEach((el) => {
  //       el.classList.remove("fadeIn")
  //     })
  //     document.querySelectorAll("._anim").forEach((el) => {
  //       el.classList.remove("_anim")
  //     })
  //   }, 400)
  // })
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
