// Скрипт, который управляет сменой экранов
const $start_InnerHTML = ``
const $auth_InnerHTML = `<!-- Top bar с лого и кнопкой -->
<div class="top-bar _anim">
  <div id="back-btn" class="button-back hidden">
    <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
      <title />
      <path
        d="M39.3756,48.0022l30.47-25.39a6.0035,6.0035,0,0,0-7.6878-9.223L26.1563,43.3906a6.0092,6.0092,0,0,0,0,9.2231L62.1578,82.615a6.0035,6.0035,0,0,0,7.6878-9.2231Z" />
    </svg>
    Назад
  </div>
  <img class="logo" src="/image/LOGO2.svg" alt="LOGO" />
</div>

<!-- Окно "Вход в аккаунт" -->
<div class="screen login-screen">
  <div class="login">
    <img class="_anim" src="/image/icons/user.png" alt="user.png" />
    <input class="_anim" id="log-login" type="text" name="login" placeholder="Логин" value="test" />
    <input class="_anim" id="log-pass" type="password" name="password" placeholder="Пароль" value="test123" />
    <div class="buttons">
      <div id="log-btn" class="button _anim">Войти</div>
      <div id="reg-btn" class="button _anim">Регистрация</div>
    </div>
  </div>
</div>

<!-- Окно "Регистрация" -->
<div class="screen reg-screen">
  <div class="col col1">
    <img src="/image/icons/anonymous.png" alt="Who are you" />
  </div>
  <div class="col col2">
    <div class="registration">
      <input id="reg-name" type="text" name="name" placeholder="Ваше Ф.И.О." />
      <input id="reg-email" type="text" name="email" placeholder="Ваша почта" />
      <input id="reg-tel" type="tel" name="tel" placeholder="Ваш телефон" maxlength="12" />
      <input id="reg-password" type="password" name="password" placeholder="Придумайте пароль" />
      <input id="reg-password2" type="password" name="password" placeholder="Повторите пароль" />
      <div id="send-reg-form-btn" class="button">Регистрация</div>
    </div>
  </div>
</div>`
const $menu_InnerHTML = `<img class="logo _anim" src="image/LOGO2.svg" alt="LOGO">
<div class="user-block _anim">
  <div class="user-photo _anim">
    <img src="${user.photo}" alt="">
  </div>
  <div class="user-info _anim">
    <div class="user-name _anim">${userName}</div>
    <div class="user-role _anim">${user.role}</div>
  </div>
</div>
<hr class="_anim">
<div class="preloader">
<div class="dot d1"></div>
<div class="dot d2"></div>
<div class="dot d3"></div>
</div>
<div class="bottom-bar">
<svg class="bottom-bar-button" id="logout-btn" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><path d="M20.484 54H66a6 6 0 0 0 0-12H20.484l7.758-7.758a6 6 0 0 0-8.484-8.484l-18 18a5.998 5.998 0 0 0 0 8.484l18 18a6 6 0 1 0 8.484-8.484Z" class="fill-000000"></path><path d="M90 0H42a5.997 5.997 0 0 0-6 6v12a6 6 0 0 0 12 0v-6h36v72H48v-6a6 6 0 0 0-12 0v12a5.997 5.997 0 0 0 6 6h48a5.997 5.997 0 0 0 6-6V6a5.997 5.997 0 0 0-6-6Z"  class="fill-000000"></path></svg>
</div>`
