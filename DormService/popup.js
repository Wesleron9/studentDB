function createPopUp(type, text, ...btnHandlers) {
  let body = document.querySelector("body")

  if (document.querySelector("pop-up-wrapper")) {
    console.error("Error: pop-up already exists!")
    return
  }

  switch (type) {
    case "message":
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
          </div>
        </div>
      </div>`
      )
      //Удаляем поп-ап по клику
      document.querySelector("#pop-up-btn1").addEventListener("click", () => {
        document.querySelector("pop-up-wrapper").remove()
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
