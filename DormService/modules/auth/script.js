document.querySelector('#signin').addEventListener('click', () => {
  let login = documen.querySelector('input#login').value
  let password = documen.querySelector('input#pass').value

  if (!login || !password) {
    return
  }

  const xhr = new XMLHttpRequest()
  xhr.open('POST', '../../authorization.php', false)
  xhr.send({login:login, password:password})
  if (xhr.status != 200) {
    alert(xhr.status + ': ' + xhr.statusText ); 
  } else {
    alert(xhr.responseText); 
  }
})