document.querySelector('#signin').addEventListener('click', () => {
  let login = documen.querySelector('#login').value
  let password = documen.querySelector('#pass').value

  if (!login || !password) {
    return
  }

  const xhr = new XMLHttpRequest()
  xhr.open('POST', '../../test.php', false)
  xhr.send(login,password)
  
  if (xhr.status != 200) {
    alert(xhr.status + ': ' + xhr.statusText ); 
  } else {
    alert(xhr.responseText); 
  }
})