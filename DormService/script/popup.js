function createPopUp(type, text, ...btnHandlers) {
  let body = document.querySelector("body")

  if (document.querySelector(".pop-up-wrapper")) {
    console.error("Error: pop-up already exists!")
    return
  }

  switch (type) {
    case "message":
      let popUp_wrapper = document.createElement("div")
      popUp_wrapper.classList.add("pop-up-wrapper")

      popUp_wrapper.innerHTML = `<div class="pop-up">
          <div class="top">
          Сообщение системы
          </div>
          <div class="message">
            ${text}
          </div>
          <div class="bottom">
            <div id="pop-up-btn1" class="button">ОК</div>
          </div>
      </div>`

      document.body.insertAdjacentElement("beforeend",popUp_wrapper)
      //Удаляем поп-ап по клику
      popUp_wrapper.querySelector("#pop-up-btn1").addEventListener("click", () => {
        popUp_wrapper.remove()
      })
      break
    
      case "confirm":
      body.insertAdjacentHTML(
        "beforeend",
        `<div class="pop-up-wrapper">
        <div class="pop-up">
          <div class="top">
          Сообщение системы
          </div>
          <div class="message">
            ${text}
          </div>
          <div class="bottom">
            <div id="pop-up-btn1" class="button">ОК</div>
            <div id="pop-up-btn2" class="button">Отмена</div>
          </div>
        </div>
      </div>`
      )
      document
        .querySelector("#pop-up-btn1")
        .addEventListener("click", btnHandlers[0])
      document
        .querySelector("#pop-up-btn2")
        .addEventListener("click", btnHandlers[1])
  }
}

createPopUp("message", "Какое-то сообщение")
createPopUp("message", "Какое-то сообщение")
createPopUp("message", "Какое-то сообщение")
createPopUp("message", "Какое-то сообщение")