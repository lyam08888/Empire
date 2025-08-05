const changeAction = type => {
  if (type === "login") {
    const url = `http://${document.loginForm.universe.value}/action.html`;
    document.getElementById("loginForm").action = url;
  } else if (type === "getpw") {
    const url = `http://${document.loginForm.universe.value}/mail.html`;
    document.loginForm.action = url;
    document.loginForm.submit();
  } else if (type === "register") {
    const url = `http://${document.registerForm.universe.value}/register.html`;
    document.registerForm.action = url;
  }
};
