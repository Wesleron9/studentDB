function createPopUp(type, text) {
  let body = document.querySelector('body')

  if (document.querySelector('pop-up-wrapper')) {
    console.error('Error: поп-ап уже существует')
    return
  }

  switch (type) {
    case 'message':
      type = 'Сообщение'
      body.insertAdjacentHTML(
        'beforeend',
        `<div class="pop-up-wrapper">
        <div class="pop-up">
          <div class="top">
           ${type}
          </div>
          <div class="message">
            ${text}
          </div>
          <div class="bottom">
            <div class="button">ОК</div>
          </div>
        </div>
      </div>`
      )
  }
}