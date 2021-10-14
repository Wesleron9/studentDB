document.querySelector('#signin').addEventListener('click', () => {
  let login = document.querySelector('#login').value
  let password = document.querySelector('#pass').value

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