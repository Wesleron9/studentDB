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
    console.log(response)
  }
)
