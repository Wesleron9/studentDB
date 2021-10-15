document.querySelector('#signin').addEventListener('click', () => {
  let login = document.querySelector('#login').value
  let password = document.querySelector('#pass').value

  if (!login || !password) {
    return
  }

  let body = JSON.stringify({login:login, password:password})
  const xhr = new XMLHttpRequest()
  xhr.open('POST', '../../authorization.php', false)
  xhr.send(body)
  
  if (xhr.status != 200) {
    alert(xhr.status + ': ' + xhr.statusText ); 
  } else {
    alert(xhr.responseText); 
  }
})